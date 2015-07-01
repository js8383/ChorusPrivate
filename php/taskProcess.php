<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/Task.php';

if(isset($_REQUEST['action'])&&isset($_REQUEST['task'])){
	
	$action = $_REQUEST['action'];

	//$stage = $_REQUEST['stage'];
	$task = $_REQUEST['task'];
	//$mturkId = $_REQUEST['mturkId'];
	
	$nowTask = new Task($task);
	
	switch ($action){
		
		case "stopTask":
			$nowTask->stopTask();
		break;
		
		case "startTask":
			$nowTask->startTask();
		break;
		
		case "isFinished":
			echo($nowTask->isFinished());
		break;
		
		case "stageControl":
			if(isset($_REQUEST['stage'])){
				$stage = $_REQUEST['stage'];
				echo($nowTask->isDoneStage($stage));
			}else{
				echo("taskProcess: stage is not set!");
			}
		break;
		
		case "isUntouchedStage":
			if(isset($_REQUEST['stage'])){
				$stage = $_REQUEST['stage'];
				echo($nowTask->isUntouchedStage($stage));
			}else{
				echo("taskProcess: stage is not set!");
			}
		break;
		
		case "activateStage":
			if(isset($_REQUEST['stage'])){
				$stage = $_REQUEST['stage'];
				$nowTask->activateStage($stage);
			}else{
				echo("taskProcess: stage is not set!");
			}
		break;
		
		case "getTaskStatus":
			echo($nowTask->getTaskArray());
		break;
		
		/*
		case "update":
			if(isset($_REQUEST['votedArrayStr'])&&isset($_REQUEST['type'])){
				$votedArray = json_decode(stripslashes($_POST['votedArrayStr']));
				$voteId = $nowVote->update($votedArray, $_REQUEST['type']);
				echo($voteId);
			}else{
				echo("voteProcess: votedArray/type is not set!");
			}
		break;
		
		case "updateChatVoteResult":
			echo($nowVote->updateChatVoteResult());
		break;
		*/	
		
		/*
		case "updateCandidate":
			$newChatLine = $nowPara->updateCandidate($_REQUEST['nowLineNum']);
			echo($newChatLine);
		break;
		*/

	}
	
}else{
	echo("taskProcess: task/action is not set!");
}




?>