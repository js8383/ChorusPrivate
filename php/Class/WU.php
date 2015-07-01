<?php

require_once('lib/OAuth.php');
require_once('AbstractApi.php');
require_once("DB.php");

class WU extends AbstractApi{
	
	/*
	private $CONSUMER_KEY = "VY0gc5U7gQOfizKk61sHGQ";
	private $CONSUMER_SECRET = "qmy1Tz575EQgsi7G7EoE27jo5xM";
	private $TOKEN = "C-KfcZc_56LLtM7CUKD7rrN8EaQrlIds";
	private $TOKEN_SECRET = "PX9t-iB26r6oyWF3N7Ota7WvHPA";
	
	private $API_HOST = 'api.yelp.com';
	
	private $DEFAULT_TERM = 'dinner';
	private $DEFAULT_LOCATION = 'San Francisco, CA';
	
	private $SEARCH_LIMIT = 10;
	
	private $SEARCH_PATH = '/v2/search/';
	private $BUSINESS_PATH = '/v2/business/';
	*/
	
	private $dbh;
	
	public function __construct(){
		$this->dbh = new DB();
	}
	
	public function trigger($parameterArray){
		
		//return($this->search($parameterArray['term'], $parameterArray['location']));
		
		$state = urlencode($parameterArray['state']);
		$city = urlencode($parameterArray['city']);
		
		//$url = "http://api.wunderground.com/api/4824e116cfa5e9d6/forecast/geolookup/conditions/q/$state/$city.json";
		//echo($url);
		$json_string = file_get_contents("http://api.wunderground.com/api/4824e116cfa5e9d6/forecast/geolookup/conditions/q/$state/$city.json");
		echo($json_string);
		/*
		$parsed_json = json_decode($json_string);
		$location = $parsed_json->{'location'}->{'city'};
		$temp_f = $parsed_json->{'current_observation'}->{'temp_f'};
		echo "Current temperature in ${location} is: ${temp_f}\n";
		*/
		
		
	}
	
	public function getJsonViz($task){
		
		$taskPropArray = array(
				"taskName" => $task
		);
		
		$nowParaRow = $this->dbh->getFirstRow("task", $taskPropArray);
		$state = urlencode(trim($nowParaRow['stage1Value']));
		$city = urlencode(trim($nowParaRow['stage2Value']));
		
		$json_string = file_get_contents("http://api.wunderground.com/api/4824e116cfa5e9d6/forecast/geolookup/conditions/q/$state/$city.json");
		
		return($json_string);
		//return(var_dump($nowParaRow));
		//return($this->search("chinese", "pittsburgh"));
		//return($this->search($term, $location));
		
	}
	
	public function isFixedInputs($parameterName){
		return false;
	}
	
	public function listValidInputs($parameterName){
		return array();
	}
	
	public function validateParameters($parameterArray){
		return true;
	}
	
}



?>