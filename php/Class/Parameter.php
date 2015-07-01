<?php 

//require_once("MTurk.php");
require_once("DB.php");

class Parameter{
	
	private $task;
	private $stage;
	private $mturkId;
	
	private $dbh;
	
	public function __construct($task, $stage, $mturkId){
		//$this->role = $role;
		$this->task = $task;
		$this->stage =  $stage;
		$this->mturkId = $mturkId;
		$this->dbh = new DB();
		//$this->$taskId = $this->$dbh->getId("tasks", "task", $this->$speaker);
	}

	public function post($value){
		
		$propArray = array(
			"value" => $value,
			"task" => $this->task,
			"mturkId" => $this->mturkId,
			"stage" => $this->stage
		);
		
		$chatId = $this->dbh->index("parameters", $propArray);
		return $chatId;
		
	}
	
	private function chatToLi($chatRow){
		$chatLine = $chatRow['value'];
		$chatId = $chatRow['id'];
		return "<li class='button parameter candidate' type='parameter' parameterId='$chatId'>$chatLine</li>";
	}
	
	public function updateCandidate(){
	
		$propArray = array(
				"task" => $this->task,
				"stage" => $this->stage,
				//"mturkId" => $this->mturkId,
				"accepted" => false
		);
	
		//$newLineNum = $this->dbh->getCount("parameters", $propArray);
		//if($nowLineNum<$newLineNum){
			$chatArray = $this->dbh->getRows("parameters", $propArray);
			$result = "";
			for($i=0;$i<count($chatArray);$i++){
				$nowChatLi = $this->chatToLi($chatArray[$i]);
				$result .= $nowChatLi;
			}
			return $result;
		//}
	
	}
	
}



?>