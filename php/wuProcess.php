<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once 'Class/WU.php';

if(isset($_REQUEST['action'])){
	
	$action = $_REQUEST['action'];
	
	$nowWU = new WU();
	
	switch ($action){
		
		case "trigger":
			if(isset($_REQUEST['state'])&&isset($_REQUEST['city'])){
				
				$parameterArray = array(
					"state" => $_REQUEST['state'],
					"city" => $_REQUEST['city']
				);
				
				echo($nowWU->trigger($parameterArray));
				//echo($voteId);
			}else{
				echo("wuProcess: country/city is not set!");
			}
		break;
		
		case "getJsonViz":
			
			if(isset($_REQUEST['task'])){
				echo($nowWU->getJsonViz($_REQUEST['task']));
			}else{
				echo("wuProcess: task is not set!");
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
		
		case "updateChatVoteResult":
			echo($nowVote->updateChatVoteResult());
		break;
		
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
	echo("yelpProcess: action is not set!");
}




?>