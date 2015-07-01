
<html><body>

<?php 

error_reporting(E_ALL);
ini_set("display_errors", 1);

//require_once("Class/lib/_hit_config.php");

require_once("Class/lib/turk50/Turk50.php");
require_once("Class/lib/key.php");

//$turk50 = new Turk50($AccessKey, $SecretKey);

$turk50 = new Turk50($AccessKey, $SecretKey, array("sandbox" => TRUE));

//$GetAccountBalanceResponse = $turk50->GetAccountBalance();
//print_r($GetAccountBalanceResponse);

//$Amount = $GetAccountBalanceResponse->GetAccountBalanceResult->AvailableBalance->Amount;
//echo($Amount);


// prepare ExternalQuestion
$Question =
"<ExternalQuestion xmlns='http://mechanicalturk.amazonaws.com/AWSMechanicalTurkDataSchemas/2006-07-14/ExternalQuestion.xsd'>" .
"<ExternalURL>https://www.google.com</ExternalURL>" .
"<FrameHeight>400</FrameHeight>" .
"</ExternalQuestion>";

// prepare Request
$Request = array(
		"Title" => "Kenneth 20150114 8",
		"Description" => "Bar",
		"Question" => $Question,
		"Reward" => array("Amount" => "0.01", "CurrencyCode" => "USD"),
		"AssignmentDurationInSeconds" => "300",
		"LifetimeInSeconds" => "300"//,
		//"MaxAssignments" => "10"
		//"QualificationRequirement" => $QualificationRequirement
);

// invoke CreateHIT
//echo("<html><body>");

$numAssignment = 10;
$sleepInSec = 2;

echo("<p>numAssignment: $numAssignment</p>");
echo("<p>sleepInSec: $sleepInSec</p>");
$beginTime = time();
for($i=0;$i<$numAssignment;$i++){
	$CreateHITResponse = $turk50->CreateHIT($Request);
	//print_r($CreateHITResponse);
	//echo("<p>");
	if($i<$numAssignment-1){
		sleep($sleepInSec);
	}
}
$endTime = time();
$timeSpent = $endTime-$beginTime;
echo("<p>$timeSpent sec</p>")

//echo("</html></body>");
//echo("Done");

?>


</html></body>
