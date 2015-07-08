<?php 

require_once 'DB.php';

class MTurk{
	
	//for security reason, set each ping a upper bound to add score
	private $maxIncreasePoint = 30000;
	
	private $id;
	private $dbh;
	
	private $propArray;
	
	private $hitId;
	private $assignmentId;
	private $workerId;
	private $turkSubmitTo;
	
	public function __construct($hitId, $assignmentId, $workerId, $turkSubmitTo, $task){
		
		$this->task = $task;
		$this->hitId = $hitId;
		$this->assignmentId = $assignmentId;
		$this->workerId = $workerId;
		$this->turkSubmitTo = $turkSubmitTo;
		
		$propArray = array(
			"hitId" => $hitId,
			"assignmentId" => $assignmentId,
			"workerId" => $workerId,
			"turkSubmitTo" => $turkSubmitTo,
			"task" => $task
		);


		$propArray2 = array(
			"task" => $task
		);
		
		$this->dbh = new DB();
		if($row = $this->dbh->getFirstRow("mturk", $propArray)){
			$this->id = $row['id'];
		}else{
			$this->id = $this->dbh->index("mturk", $propArray);
		}

		if($row = $this->dbh->getFirstRow("requesterLog", $propArray2)){
			$this->id = $row['id'];
		}else{
			$this->id = $this->dbh->index("requesterLog", $propArray2);
		}
		
	}
	
	public function getActiveWorkerNum($workerTimeoutInSec){
		
		$propArray = array(
				//"hitId" => $this->hitId,
				//"assignmentId" => $this->assignmentId,
				//"workerId" => $this->workerId,
				//"turkSubmitTo" => $this->turkSubmitTo,
				"task" => $this->task
		);
		
		//public function getCountTimeout($table, $propArray, $timeFieldName, $timeWindowInSec){
		return ($this->dbh->getCountTimeout("mturk", $propArray, "updateTime", $workerTimeoutInSec));

		
	}

	public function distributeTask($workerTimeoutInSec){ 
		return ($this->dbh->getLeastParticipatedTask("mturk", "updateTime", $workerTimeoutInSec));
	}

	public function logRequester() {
		$propArray = array(
				"hitId" => $this->hitId,
				"assignmentId" => $this->assignmentId,
				"workerId" => $this->workerId,
				"turkSubmitTo" => $this->turkSubmitTo,
				"task" => $this->task
		);
		$timestamp =  date('Y-m-d H:i:s', time());
		$this->dbh->updateFields("mturk", "updateTime", $timestamp, $propArray);
	}

	//sync score at the same time
	//save check for odd increace, trust database more
	public function logWorker($score){
		$propArray = array(
				"hitId" => $this->hitId,
				"assignmentId" => $this->assignmentId,
				"workerId" => $this->workerId,
				"turkSubmitTo" => $this->turkSubmitTo,
				"task" => $this->task
		);
		$timestamp =  date('Y-m-d H:i:s', time());
		//public function updateFields($table, $field, $value, $propArray){
		$this->dbh->updateFields("mturk", "updateTime", $timestamp, $propArray);
		
		$nowRow = $this->dbh->getFirstRow("mturk", $propArray);
		$dbScore = intval($nowRow['score']);
		if(intval($score)-$dbScore<=$this->maxIncreasePoint){
			$this->dbh->updateFields("mturk", "score", $score, $propArray);
		}
		
		
		//getFirstRow($table, $propArray)
		/*
		$nowRow = $this->dbh->getFirstRow("mturk", $propArray);
		//$this->dbh->updateFields("mturk", "score", $score, $propArray);
		
		$dbScore = $nowRow['score'];
		if($score==0){//reload page
			if($score<$dbScore){//no update, just sync the score
				return $dbScore;
			}
			return $score;
		}else{//update page
			if($score<$dbScore){//add score
				if($score<=$maxIncreasePoint){//safe check
					$this->dbh->updateFields("mturk", "score", $dbScore+$score, $propArray);
					return ($dbScore+$score);
				}//else{//not safe, just return old score
				return ($dbScore);
				//}
			}else if($score>$dbScore){//update score
				if($dbScore-$score<=$maxIncreasePoint){//safe check
					$this->dbh->updateFields("mturk", "score", $score, $propArray);
					return ($score);
				}//else{//not safe, keep the old one
				return ($dbScore);
				//}
			}
			return $score;
		}
		*/
		
		
		//return 
	}
	
	public function getId(){
		return $this->id;
	}
	
	/*
	public static function withParameters($hitId, $assignmentId, $workerId, $turkSubmitTo) {
		$nowObj = new self();
		
		$nowObj->setHitId($hitId);
		$nowObj->setAssignmentId($assignmentId);
		$nowObj->setWorkerId($workerId);
		$nowObj->setTurkSubmitTo($turkSubmitTo);
		
		return $nowObj;
	}
	
	public static function withParameterArray($paraArray) {
		$nowObj = new self();
		$nowObj->setHitId($paraArray['hitId']);
		$nowObj->setAssignmentId($paraArray['assignmentId']);
		$nowObj->setWorkerId($paraArray['workerId']);
		$nowObj->setTurkSubmitTo($paraArray['turkSubmitTo']);
		return $nowObj;
	}
	*/
	/*
	public function setHitId($hitId){
		$this->hitId = $hitId;
	}
	
	public function setAssignmentId($assignmentId){
		$this->assignmentId = $assignmentId;
	}
	
	public function setWorkerId($workerId){
		$this->workerId = $workerId;
	}
	
	public function setTurkSubmitTo($turkSubmitTo){
		$this->turkSubmitTo = $turkSubmitTo;
	}
	*/
	
	public function getHitId(){
		return $this->hitId;
	}
	
	public function getAssignmentId(){
		return $this->assignmentId;
	}
	
	public function getWorkerId(){
		return $this->workerId;
	}
	
	public function getTurkSubmitTo(){
		return $this->turkSubmitTo;
	}
	
}


?>