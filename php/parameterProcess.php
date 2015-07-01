<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/Parameter.php';

if(isset($_REQUEST['action'])&&isset($_REQUEST['stage'])&&isset($_REQUEST['task'])&&isset($_REQUEST['mturkId'])){
	
	$action = $_REQUEST['action'];
	
	$stage = $_REQUEST['stage'];
	$task = $_REQUEST['task'];
	$mturkId = $_REQUEST['mturkId'];
	
	$nowPara = new Parameter($task, $stage, $mturkId);
	
	switch ($action){
		
		case "post":
			//$nowChat = new Chat($role, $task);
			//$nowChat->setMTurkId($_REQUEST['mturkId']);
			$paraId = $nowPara->post($_REQUEST['value']);
			echo($paraId);
		break;
		
		/*
		case "update":
			//$nowChat = new Chat($role, $task);
			$newChatLine = $nowChat->update($_REQUEST['nowLineNum']);
			echo($newChatLine);
		break;
		*/
		case "updateCandidate":
			$newChatLine = $nowPara->updateCandidate();
			echo($newChatLine);
		break;

	}
	
}else{
	echo("stage/task/action/mturkId is not set!");
}




?>