<?php 

abstract class AbstractApi{
	
	/*	
	 * parameterName: a string of a parameter name
	 * return: true/false
	 */
	abstract protected function isFixedInputs($parameterName);

	/*	
	 * parameterName: a string of a parameter name
	 * return: an array contains all valid input values
	 */
	abstract protected function listValidInputs($parameterName);
	
	/*
	 * $parameterArray = array(
	 * 		"parameterName1" => $parameterValue1,
	 * 		"parameterName2" => $parameterValue2,
	 * 		...
	 * );
	 * 
	 * succeed:	return JSON string from the API
	 * fail:	if(error message is also passed in a JSON string){
	 * 				return JSON string anyway;
	 * 			}else{//like, return empty string or false...
	 * 				echo(error message);
	 * 				return false;
	 * 			}
	 */
	abstract public function trigger($parameterArray);
	
	/*
	 * $parameterArray = array(
	 		* 		"parameterName1" => $parameterValue1,
	 		* 		"parameterName2" => $parameterValue2,
	 		* 		...
	 		* );
	*
	* succeed:	return true;
	* fail:		echo(error message);
	* 			return false;
	*/
	abstract public function validateParameters($parameterArray);
	
}


?>