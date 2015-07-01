<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/DB.php';
//require_once 'Class/MTurk.php';

if(isset($_REQUEST['action'])){
	
	$action = $_REQUEST['action'];
	
	//$nowTask = new Task($task);
	$nowDB = new DB();
	
	switch ($action){
		
		case "isTaskAvailable":
			$taskPropArray = array(
					"status" => "activated"
			);
			//getCount($table, $propArray)
			if($nowDB->getCount("task", $taskPropArray)>0){
				$row = $nowDB->getFirstRow("task", $taskPropArray);
				//echo(var_dump($row));
				echo($row['taskName']);
			}else{
				echo(false);
			}
		break;
		
		case "reainterStatusUpdtae":
			$taskPropArray = array(
					"task" => "waitPage"
			);
			echo($nowDB->getCountTimeout("mturk", $taskPropArray, 5));
		break;
		
		/*
		case "getFirstAvailableTask":
			$taskPropArray = array(
					"status" => "activated"
			);
			
			if(($nowDB->getCount("task", $taskPropArray))>0){
				echo("Haha");
				//$row = $nowDB->getFirstRow("task", $taskPropArray);
				//echo(var_dump($row));
				//echo($row['taskName']);
			}else{
				echo("Fuck");
			}
		break;
		*/
		/*
		case "startTask":
			$nowTask->startTask();
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
		*/
		
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
	echo("retainerProcess: action is not set!");
}




?>