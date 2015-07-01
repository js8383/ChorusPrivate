<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/Memory.php';

if(isset($_REQUEST['action'])&&isset($_REQUEST['task'])&&isset($_REQUEST['workerId'])){
	
	$action = $_REQUEST['action'];
	//$role = $_REQUEST['role'];
	$task = $_REQUEST['task'];
	$workerId = $_REQUEST['workerId'];
	
	$nowMemory = new Memory($workerId, $task);
	
	switch ($action){
		
		case "postMemory":
			$memoryId = $nowMemory->postMemory($_REQUEST['memoryLine']);
			echo($memoryId);
		break;
		
		case "fetchNewMemory":
			$lastMemoryId = $_REQUEST['lastMemoryId'];
			$newMemoryArray = $nowMemory->fetchNewMemory($lastMemoryId);
			echo(json_encode($newMemoryArray));
		break;
		
		/*
		case "fetchNewChatRequester":
			$lastChatId = $_REQUEST['lastChatId'];
			$newChatArray = $nowChat->fetchNewChatRequester($lastChatId);
			echo(json_encode($newChatArray));
		break;
		
		case "expireChats":
			$chatTimeoutInSec = $_REQUEST['chatTimeoutInSec'];
			$lastExpiredChatId = $nowChat->getLastExpiredChatId($chatTimeoutInSec);
			echo($lastExpiredChatId);
		break;
		*/
		
		/*
		case "updateCandidate":
			$newChatLines = $nowChat->updateCandidate();
			echo($newChatLines);
		break;
		*/

	}
	
}else{
	echo("chatProcess.php: role/task/action/workerId is not set!");
}




?>