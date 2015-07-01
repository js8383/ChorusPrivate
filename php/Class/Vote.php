<?php 

//require_once("MTurk.php");
require_once("DB.php");

class Vote{
	
	private $voteThreshold = 0.4;
	
	private $task;
	private $workerId;
	
	private $type;//chat, memory
	private $voteTo;//id
	
	private $dbh;
	
	public function __construct($task, $workerId){
		$this->task = $task;
		$this->workerId =  $workerId;
		$this->dbh = new DB();
	}

	public function post($voteTo, $type){
		
		$propArray = array(
			"voteTo" => $voteTo,
			"task" => $this->task,
			"workerId" => $this->workerId,
			"type" => $type
		);
		
		//check dup
		if($this->dbh->getCount("vote", $propArray)==0){
			$voteId = $this->dbh->index("vote", $propArray);
			return $voteId;
		}else{
			return false;
		}
		
	}
	
	public function getVotedChats($type){
		
		$propArray = array(
				"task" => $this->task,
				"workerId" => $this->workerId,
				"type" => $type
		);
		
		$rowsArray = $this->dbh->getRows("vote", $propArray);
		$result = array();
		for($i=0;$i<count($rowsArray);$i++){
			array_push($result, $rowsArray[$i]['voteTo']);
		}
		return $result;
		
	}
	
	//refresh the page w/ the crowd's votes
	//return the newly selected one if any
	public function update($selectedArray, $type){
		
		$propArray = array(
				//"voteTo" => $voteTo,
				"task" => $this->task,
				"mturkId" => $this->mturkId,
				"stage" => $this->stage,
				"type" => $type
		);
		
		$rowsArray = $this->dbh->getRows("vote", $propArray);
		
		if(count($selectedArray)<count($rowsArray)){//update needed
			$result = array();
			foreach ($rowsArray as $key => $chat) {
				//echo(gettype  );
				if(!in_array((string)$chat['voteTo'], $selectedArray)){
					array_push($result, $chat['voteTo']);
				}
			}
			//return (gettype($selectedArray));
			return json_encode($result);
		}else{
			return false;
		}
		
	}
	
	//updateChatVoteResult($_REQUEST['consentProportion'], $_REQUEST['timeoutInSec']));
			
	//set "accepted" to true if the chat is voted by 40% of workers
	//$consentProportion, $workerTimeoutInSec, $chatTimeoutInSec
	public function updateChatVoteResult($consentProportion, $workerTimeoutInSec, $chatTimeoutInSec){
		//return "haha";
		$chatPropArray = array(
			"role" => "crowd",
			"accepted" => false,
			"task" => $this->task
		);
		
		$chatOriginPropArray = array(
				"role" => "crowd",
				"accepted" => true,
				"task" => $this->task
		);
		
		$votePropArray = array(
			"task" => $this->task,
			"type" => "chat"
		);
		
		$mturkPropArray = array(
			"task" => $this->task
		);
		//return $workerTimeoutInSec;
		$nowMturks = $this->dbh->getRowsTimeout("mturk", $mturkPropArray, "updateTime", $workerTimeoutInSec);
		//return $nowMturks;
		//votes don't expire, too much calculation
		$nowVotes =  $this->dbh->getRows("vote", $votePropArray);
		//return $nowVotes;
		$nowChats =  $this->dbh->getRowsTimeout("chat", $chatPropArray, "time", $chatTimeoutInSec);
		$acceptedChats =  $this->dbh->getRowsTimeout("chat", $chatOriginPropArray, "time", $chatTimeoutInSec);
		//return count($nowChats);
		//unique workers, avoid same worker opens multiple tab 
		$nowWorkers = array();
		for($i=0;$i<count($nowMturks);$i++){
			$nowWorkerId = $nowMturks[$i]['workerId'];
			if(!in_array($nowWorkerId, $nowWorkers)){
				array_push($nowWorkers, $nowWorkerId);
			}
		}
		
		//cal vote threshold
		$activeWorkerNum = count($nowWorkers);
		$threshold = $activeWorkerNum*$consentProportion;
		
		//sum up votes (chatId, chatNum)
		//iterate unaccepted chats first (set to 1)
		$voteArray = array();
		for($i=0;$i<count($nowChats);$i++){
			//one vote from the proposer
			$voteArray[$nowChats[$i]['id']] = 1;
		}
		//iterate vote
		for($i=0;$i<count($nowVotes);$i++){
			$nowWorkerId = $nowVotes[$i]['workerId'];
			//only count active workers
			if(in_array($nowWorkerId, $nowWorkers)){
				$nowVoteTo = $nowVotes[$i]['voteTo'];
				//if not set => chat expired, no need to care
				if(isset($voteArray[$nowVoteTo])){
					$voteArray[$nowVoteTo]++;
				}
			}
		}
		
		//now get result
		$result = array();
		foreach ($voteArray as $chatId => $voteCount) {
    		if($voteCount>=$threshold){
    			$chatPropArray = array(
    					"id" => $chatId
    					//"task" => $this->task
    			);
    			$this->dbh->updateFields("chat", "accepted", true, $chatPropArray);
    			$timestamp =  date('Y-m-d H:i:s', time());
    			$this->dbh->updateFields("chat", "acceptedTime", $timestamp, $chatPropArray);
    			array_push($result, $chatId);
    		}
		}
		//add original
		for($i=0;$i<count($acceptedChats);$i++){
			array_push($result, $acceptedChats[$i]['id']);
		}
		return $result;
			
	
		
	}
	
	public function updateParameterVoteResult(){
		
		$votePropArray = array(
				"task" => $this->task,
				"stage" => $this->stage,
				"type" => "parameter"
		);
		
		$workerPropArray = array(
				"task" => $this->task
		);
		
		$workers =  $this->dbh->getRows("mturk", $workerPropArray);
		//echo(count($workers));
		
		if(count($workers)>=3){
			
			$allVotes = $this->dbh->getRows("vote", $votePropArray);

			$voteStatus = array();
				
			$minVotes = count($workers)*$this->voteThreshold;
			//echo($minVotes);
			
			foreach($allVotes as $key => $voteTo){
			
				$nowVoteTo = $voteTo['voteTo'];
				if(!isset($voteStatus[$nowVoteTo])){
					$voteStatus[$nowVoteTo] = 1;
				}else{
					$voteStatus[$nowVoteTo]++;
				}
				if($voteStatus[$nowVoteTo]>=$minVotes){
					//echo($nowVoteTo);
					/*
					 * (1) set parameter to accepted
					 * (2) set task/stage to finished
					 * (3) set the parameter value
					 */
					
					$this->setParameterAccepted($nowVoteTo);
					$this->setTaskStageFinished();
					$this->setParameterValue($nowVoteTo);
					
					//we only need one parameter!
					break;
					
				}
				
			}
			
		}
		
		
	}
	
	private function setParameterValue($paraId){
		
		$votePropArray = array(
				"task" => $this->task,
				"stage" => $this->stage,
				"id" => $paraId
		);
		
		$nowParaRow = $this->dbh->getFirstRow("parameters", $votePropArray);
		$nowParaValue = $nowParaRow['value'];
		//echo("<p>$nowParaValue</p>");
		
		$taskPropArray = array(
				//"id" => $paraId,
				"taskName" => $this->task
				//"stage" => $this->stage
		);
		
		$field = "stage".($this->stage)."Value";
		//echo("<p>$field</p>");
		
		$this->dbh->updateFields("task", $field, $nowParaValue, $taskPropArray);
		
		//updateFields("task", $fieldName, true, $votePropArray);
		
	}
	
	private function setTaskStageFinished(){
		
		$votePropArray = array(
				"taskName" => $this->task
		);
		
		$fieldName = "stage".($this->stage);
		$this->dbh->updateFields("task", $fieldName, "finished", $votePropArray);
		
	}	
	
	
	private function setParameterAccepted($paraId){
		//echo("<p>".$paraId."</p>");
		$votePropArray = array(
				"id" => $paraId,
		 		"task" => $this->task,
				"stage" => $this->stage
		 );
		
		$this->dbh->updateFields("parameters", "accepted", true, $votePropArray);
		
	}
	
	/*
	
	private function chatToLi($chatRow){
		$chatLine = $chatRow['value'];
		$chatId = $chatRow['id'];
		return "<li class='button' parameterId='$chatId'>$chatLine</li>";
	}
	
	public function updateCandidate($nowLineNum){
	
		$propArray = array(
				"task" => $this->task,
				"stage" => $this->stage,
				//"mturkId" => $this->mturkId,
				"accepted" => false
		);
	
		$newLineNum = $this->dbh->getCount("parameters", $propArray);
		if($nowLineNum<$newLineNum){
			$chatArray = $this->dbh->getRows("parameters", $propArray);
			$result = "";
			for($i=$nowLineNum;$i<count($chatArray);$i++){
				$nowChatLi = $this->chatToLi($chatArray[$i]);
				$result .= $nowChatLi;
			}
			return $result;
		}
	
	}
	
	*/
	
}



?>