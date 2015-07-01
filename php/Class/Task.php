<?php 

//require_once("MTurk.php");
require_once("DB.php");

class Task{
		
	private $task;
		
	private $dbh;
	
	public function __construct($task){
		
		$this->task = $task;
		$this->dbh = new DB();
		
		$propArray = array(
				"taskName" => $this->task
		);
		
		if($this->dbh->getCount("task", $propArray)==0){
			$taskId = $this->dbh->index("task", $propArray);
			return $taskId;
		}else{
			return false;
		}
		
	}
	
	public function isFinished(){
		
		$taskPropArray = array(
				"taskName" => $this->task
		);
		
		$nowParaRow = $this->dbh->getFirstRow("task", $taskPropArray);
		if($nowParaRow['status']=='finished'){
			return true;
		}
		return false;
		
	}
	
	public function startTask(){
	
		$taskPropArray = array(
				"taskName" => $this->task
		);
		$nowParaRow = $this->dbh->updateFields("task", "status", "activated", $taskPropArray);
		
	}
	
	public function stopTask(){
	
		$taskPropArray = array(
				"taskName" => $this->task
		);
		$nowParaRow = $this->dbh->updateFields("task", "status", "finished", $taskPropArray);
	
	}
	
	
	public function gettaskArray(){
		
		$taskPropArray = array(
				"taskName" => $this->task
		);
		$nowParaRow = $this->dbh->getFirstRow("task", $taskPropArray);
		
		$mturkPropArray = array(
				"task" => $this->task
		);
		//getCountTimeout($table, $propArray, $timeWindowInSec){
		$activeWorkerNum = $this->dbh->getCountTimeout("mturk", $mturkPropArray, 10);
		$nowParaRow['activeWorkerNum'] = $activeWorkerNum;
		
		return json_encode($nowParaRow);
		
	}
	
	//check if the task done
	public function isDoneStage($stage){

		$taskPropArray = array(
				"taskName" => $this->task
		);
		
		$nowParaRow = $this->dbh->getFirstRow("task", $taskPropArray);
		
		if($stage==1||$stage==2){
			$stageFieldName = "stage".$stage;
			//echo($stageFieldName);
			//return var_dump($nowParaRow);
			if($nowParaRow[$stageFieldName]=='finished'){
				return true;
			}
		}
		return false;
				
	}
	
	//check if the task done
	public function isActivatedStage($stage){
	
		$taskPropArray = array(
				"taskName" => $this->task
		);
	
		$nowParaRow = $this->dbh->getFirstRow("task", $taskPropArray);
	
		if($stage==1||$stage==2){
			$stageFieldName = "stage".$stage;
			if($nowParaRow[$stageFieldName]=='activated'){
				return true;
			}
		}
		return false;
	
	}
	
	public function isUntouchedStage($stage){
	
		$taskPropArray = array(
				"taskName" => $this->task
		);
	
		$nowParaRow = $this->dbh->getFirstRow("task", $taskPropArray);
	
		if($stage==1||$stage==2||$stage==3){
			$stageFieldName = "stage".$stage;
			if($nowParaRow[$stageFieldName]=='untouched'){
				return true;
			}
		}
		return false;
	
	}

	public function activateStage($stage){
		
		//updateFields($table, $field, $value, $propArray)
		
		$taskPropArray = array(
				"taskName" => $this->task
		);
		
		if($stage==1||$stage==2||$stage==3){
			$stageFieldName = "stage".$stage;
			$this->dbh->updateFields("task", $stageFieldName, "activated", $taskPropArray);
		}
		//return false;
		
	}
	
	/*
	public function index(){
		
	}
	*/
	//refresh the page w/ the crowd's votes
	//return the newly selected one if any
	/*
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
	*/
	//set "accepted" to true if the chat is voted by 40% of workers
	/*
	public function updateChatVoteResult(){
		
		//global $voteThreshold;
		
		$votePropArray = array(
			"task" => $this->task,
			"stage" => $this->stage,
			"type" => "chat"
		);
		
		$workerPropArray = array(
			"task" => $this->task
		);
		
		$workers =  $this->dbh->getRows("mturk", $workerPropArray);
		//return(var_dump($workers));
		
		if(count($workers)>=3){
			
			$allVotes = $this->dbh->getRows("vote", $votePropArray);
			//return var_dump($allVotes);
			
			$voteStatus = array();
			
			$minVotes = count($workers)*$this->voteThreshold;
			//return var_dump($minVotes);
			
			foreach($allVotes as $key => $voteTo){
				
					$nowVoteTo = $voteTo['voteTo'];
					if(!isset($voteStatus[$nowVoteTo])){
						$voteStatus[$nowVoteTo] = 1;
					}else{
						$voteStatus[$nowVoteTo]++;
					}
					if($voteStatus[$nowVoteTo]>=$minVotes){
						
						$votePropArray = array(
								"id" => $nowVoteTo,
								"task" => $this->task
								//"stage" => $this->stage
						);
						
						//return var_dump($votePropArray);
						
						$this->dbh->updateFields("chat", "accepted", true, $votePropArray);
					}
			}
			
			//return var_dump($voteStatus);
			
			return true;
			
		}else{
			
			$nowWorkerNum = count($workers);
			return("Wait for more workers. (Only $nowWorkerNum for now.)");
			
		}
		
	}
	*/
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