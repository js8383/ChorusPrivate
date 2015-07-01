<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/Vote.php';

if(isset($_REQUEST['action'])&&isset($_REQUEST['task'])&&isset($_REQUEST['workerId'])){
	
	$action = $_REQUEST['action'];

	$task = $_REQUEST['task'];
	$workerId = $_REQUEST['workerId'];
	
	$nowVote = new Vote($task, $workerId);
	
	switch ($action){
		
		case "post":
			if(isset($_REQUEST['voteTo'])&&isset($_REQUEST['type'])){
				$voteId = $nowVote->post($_REQUEST['voteTo'], $_REQUEST['type']);
				echo($voteId);
			}else{
				echo("voteProcess: voteTo/type is not set!");
			}
		break;
		
		case "getVotedChats":
			if(isset($_REQUEST['type'])){
				$votedChats = $nowVote->getVotedChats($_REQUEST['type']);
				echo(json_encode($votedChats));
			}else{
				echo("voteProcess: type is not set!");
			}

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
		*/
		
		case "updateChatVoteResult":
			if(isset($_REQUEST['consentProportion'])&&isset($_REQUEST['workerTimeoutInSec'])&&isset($_REQUEST['chatTimeoutInSec'])){
				$consentProportion = doubleval($_REQUEST['consentProportion']);
				$workerTimeoutInSec = intval($_REQUEST['workerTimeoutInSec']);
				$chatTimeoutInSec = intval($_REQUEST['chatTimeoutInSec']);
				echo(json_encode($nowVote->updateChatVoteResult($consentProportion, $workerTimeoutInSec, $chatTimeoutInSec)));
			}else{
				echo("voteProcess: consentProportion/workerTimeoutInSec/chatTimeoutInSec is not set!");
			}			
		break;
		
		/*
		case "updateParameterVoteResult":
			echo($nowVote->updateParameterVoteResult());
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
	echo("voteProcess: action/task/workerId is not set!");
}




?>