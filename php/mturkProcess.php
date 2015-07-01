<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/MTurk.php';

if(isset($_REQUEST['task'])&&isset($_REQUEST['hitId'])&&isset($_REQUEST['assignmentId'])&&isset($_REQUEST['workerId'])&&isset($_REQUEST['turkSubmitTo'])){
	
	$action = $_REQUEST['action'];
	
	$hitId = $_REQUEST['hitId'];
	$assignmentId = $_REQUEST['assignmentId'];
	$workerId = $_REQUEST['workerId'];
	$turkSubmitTo = $_REQUEST['turkSubmitTo'];
	
	$task = $_REQUEST['task'];
	
	$nowMTurk = new MTurk($hitId, $assignmentId, $workerId, $turkSubmitTo, $task);
	
	switch ($action){
		
		case "getId":
			$mTurkId = $nowMTurk->getId();
			echo($mTurkId);
		break;
		
		case "logWorker":
			$score = $_REQUEST['score'];
			$nowMTurk->logWorker($score);
		break;
		
		case "updateActiveWorkerNum":
			$workerTimeoutInSec = $_REQUEST['workerTimeoutInSec'];
			echo($nowMTurk->getActiveWorkerNum($workerTimeoutInSec));
		break;
		
	}
	
}else{
	echo("hitId/assignmentId/workerId/turkSubmitTo/task is not set!");
}




?>