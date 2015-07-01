<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/Chat.php';

if(isset($_REQUEST['action'])&&isset($_REQUEST['role'])&&isset($_REQUEST['task'])&&isset($_REQUEST['workerId'])){
	
	$action = $_REQUEST['action'];
	$role = $_REQUEST['role'];
	$task = $_REQUEST['task'];
	$workerId = $_REQUEST['workerId'];
	
	$nowChat = new Chat($role, $workerId, $task);
	
	switch ($action){
		
		case "post":
			$chatId = $nowChat->post($_REQUEST['chatLine']);
			echo($chatId);
		break;
		
		case "fetchNewChat":
			$lastChatId = $_REQUEST['lastChatId'];
			$newChatArray = $nowChat->fetchNewChat($lastChatId);
			echo(json_encode($newChatArray));
		break;
		
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