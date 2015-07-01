<?php 

session_start();

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/Task.php';

if(isset($_REQUEST['action'])){
	
	$action = $_REQUEST['action'];
	
	switch ($action){
		
		case "getValue":
			if(isset($_REQUEST['sessionFlag'])){
				$sessionFlag = $_REQUEST['sessionFlag'];
				if(isset($_SESSION[$sessionFlag])){
					echo($_SESSION[$sessionFlag]);
				}else{
					//echo("fuck");
					echo(false);
				}
			}else{
				echo("sessionProcess: sessionFlag is not set!");
			}
		break;
		
		
		case "setValue":
			if(isset($_REQUEST['sessionFlag'])&&isset($_REQUEST['sessionValue'])){
				$sessionFlag = $_REQUEST['sessionFlag'];
				$sessionValue = $_REQUEST['sessionValue'];
				echo($sessionFlag);
				$_SESSION[$sessionFlag] = $sessionValue;
			}else{
				echo("taskProcess: sessionFlag/sessionValue is not set!");
			}
		break;
		
		/*
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
	echo("sessionProcess: action is not set!");
}




?>