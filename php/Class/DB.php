<?php



class DB{
	
	/*
	private $dbname = global $dbname;
	private $user;
	private $password;
	*/
	
	private $dbh;
	
	public function __construct(){
		///Chorus/API/php/Class/lib/key.php
		require_once("lib/key.php");
		$this->dbh = new PDO("mysql:host=localhost;dbname=$dbname", $user, $password);
		
		if(!$this->dbh){
			echo("new DB error");
		}
		
	}
	
	//insert data, return ID
	/*
	public function insert($table, $field, $value){
		
		$sth = $this->$dbh->query ("SELECT id FROM $table WHERE $field = '$value'");
		$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		if($row) {
			return $row["id"];
		} else {
			$sth = $this->$dbh->query("INSERT INTO $table ($field) VALUES('$value')");
			return $this->$dbh->lastInsertId();
		}
		
	}
	*/
	
	/*
	public function getId($table, $propArray){
		$counter = 0;
		$sql = "SELECT id FROM $table WHERE ";
		foreach ($propArray as $key => $value) {
			$counter++;
			$sql .= "$key = '$value' ";
			if($counter<count($propArray)){
				$sql .= " AND ";
			}
		}
		$sth = $this->dbh->query($sql);
		$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		if($row) {
			return $row["id"];
		} else {
				
		}
	}
	*/
	
	public function getLastId($table, $propArray){
		
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT MAX(id) FROM $table WHERE $chainedKeys";
		
		$exeArray = $this->getExeArray($propArray);
		
		//echo($sql."<br>");
		//echo(var_dump($exeArray)."<br>");
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		
		//$sth = $this->dbh->query($sql);
		//$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		if($row) {
			return intval($row['MAX(id)']);
		}else{
			echo("DB fetch error");
		}
		
	}
	
	public function getLastIdOrderBy($table, $propArray, $orderBy){
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT id FROM $table WHERE $chainedKeys ORDER BY $orderBy";
	
		$exeArray = $this->getExeArray($propArray);
	
		//echo($sql."<br>");
		//echo(var_dump($exeArray)."<br>");
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		
		$lastId = -1;
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			$lastId = $row['id'];
			//array_push($result, $row);
		}
		return intval($lastId);
		
		
		//$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
	
		//$sth = $this->dbh->query($sql);
		//$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		/*
		if($row) {
			return intval($row['MAX(id)']);
		}else{
			echo("DB fetch error");
		}
		*/
	
	}
	
	//insert an object data to database table, return ID (please take care of time)
	public function index($table, $propArray){
			
		$chainedKeys = $this->getChainedFields("", $propArray);
		$chainedValueKeys = $this->getChainedFields(":", $propArray);
		
		$insertSql = "INSERT INTO $table ($chainedKeys) VALUES($chainedValueKeys)"; 
		
		$exeArray = $this->getExeArray($propArray);
		
		$sth = $this->dbh->prepare($insertSql);
		$sth->execute($exeArray);
		
		return $this->dbh->lastInsertId();
	
	}
	
	public function getCount($table, $propArray){
		
		/*
		 * $sth = $dbh->prepare ("SELECT is_accepted AS status FROM chats WHERE id=:cid");
    $sth->execute(array(':cid'=>$id));
    $row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		 */
		
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT COUNT(*) FROM $table WHERE $chainedKeys";
		
		$exeArray = $this->getExeArray($propArray);
		
		//echo($sql."<br>");
		//echo(var_dump($exeArray)."<br>");
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		
		//$sth = $this->dbh->query($sql);
		//$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		if($row) {
			return intval($row['COUNT(*)']);
		}else{
			echo("DB fetch error");
		}
		
	}
	
	public function getFirstRow($table, $propArray){
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT * FROM $table WHERE $chainedKeys";
	
		$exeArray = $this->getExeArray($propArray);
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
	
		return  $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		
		/*
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			array_push($result, $row);
		}
		return $result;
		*/
	
	}
	
	public function getRows($table, $propArray){
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT * FROM $table WHERE $chainedKeys ORDER BY id";
		
		$exeArray = $this->getExeArray($propArray);
		
		//echo($sql."<br>");
		//echo(var_dump($exeArray)."<br>");
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			array_push($result, $row);
		}
		return $result;
		
	}
	
	public function getRowsBeginFrom($table, $propArray, $beginId){
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT * FROM $table WHERE $chainedKeys AND id>='$beginId' ORDER BY id";
	
		$exeArray = $this->getExeArray($propArray);
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
	
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			array_push($result, $row);
		}
		return $result;
	
	}
	
	public function getRowsBeginFromEndOrderBy($table, $propArray, $lastEndId, $orderBy){
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT * FROM $table WHERE $chainedKeys ORDER BY $orderBy";
	
		$exeArray = $this->getExeArray($propArray);
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
	
		$begin = false;
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			if($lastEndId==-1){//initial, or update but nothing
				array_push($result, $row);
			}else{//update
				if($begin){
					array_push($result, $row);
				}
				if(intval($row['id'])==$lastEndId&&$begin==false){
					$begin = true;
				}
			}
		}
		return $result;
	
	}
	
	//get "key1 = :key1 AND key2 = :key2 AND ..."
	private function getChainedFieldsAnd($propArray){
		
		$fields = "";
		$counter = 0;
		foreach ($propArray as $key => $value) {
			$counter++;
			$fields .= " $key = :$key ";
			if($counter<count($propArray)){
				$fields .= " AND ";
			}
		}
		return $fields;
		
	}
	
	//get "<prefix>Para1, <prefix>Para2, ...."
	private function getChainedFields($prefix, $propArray){
		
		$fields = "";
		$counter = 0;
		foreach ($propArray as $key => $value) {
			$counter++;
			$fields .= "$prefix$key";
			if($counter<count($propArray)){
				$fields .= ",";
			}
		}
		return $fields;
	}
	
	private function getExeArray($propArray){
		$exeArray = array();
		foreach ($propArray as $key => $value) {
			$exeArray[":$key"] = $value;
		}
		return $exeArray;
	}
	
	public function getDistinctValues($table, $field, $propArray){
		
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT DISTINCT $field FROM $table WHERE $chainedKeys";
		
		$exeArray = $this->getExeArray($propArray);
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			array_push($result, $row);
		}
		return $result;
		//SELECT DISTINCT voteTo FROM dia_api_scheme.vote;
		
	}
	
	public function updateFields($table, $field, $value, $propArray){
		
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "UPDATE $table SET $field = '$value' WHERE $chainedKeys";
		//echo($sql);
		
		
		
		
		$exeArray = $this->getExeArray($propArray);
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		
	}
	
	public function getCountTimeout($table, $propArray, $timeFieldName, $timeWindowInSec){
		
		
		$timeMysql = date('Y-m-d H:i:s', time()-$timeWindowInSec);
		//$sql = "SELECT COUNT(*) FROM worker_status where page='$dbLabel' AND worker_status.last_ping>='$timeMysql'";
		
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT COUNT(*) FROM $table WHERE $chainedKeys";
		
		$sql .= " AND $timeFieldName >= '$timeMysql'";
		
		$exeArray = $this->getExeArray($propArray);
		
		//echo($sql."<br>");
		//echo(var_dump($exeArray)."<br>");
		
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		
		//$sth = $this->dbh->query($sql);
		//$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);
		if($row) {
			return intval($row['COUNT(*)']);
		}else{
			echo("DB fetch error");
		}
		
	}

	// New function

	public function getLeastParticipatedTask($table, $timeFieldName, $timeWindowInSec){ 


		$timeMysql = date('Y-m-d H:i:s', time()-$timeWindowInSec);

		$sql = "SELECT task, COUNT(task) AS numWorkers FROM $table WHERE $timeFieldName >= '$timeMysql' 
		        GROUP BY task ORDER BY numWorkers LIMIT 1";		
			
		$sth = $this->dbh->query($sql);
		$row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT);

		if($row) {
			return $row['task'];
		}else{
			return -1;
		}

	}
	
	//

	public function getRowsTimeout($table, $propArray, $timeFieldName, $timeWindowInSec){
	
	
		$timeMysql = date('Y-m-d H:i:s', time()-$timeWindowInSec);
		//$sql = "SELECT COUNT(*) FROM worker_status where page='$dbLabel' AND worker_status.last_ping>='$timeMysql'";
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT * FROM $table WHERE $chainedKeys";
	
		$sql .= " AND $timeFieldName >= '$timeMysql'";
		$sql .= " ORDER BY id";
	
		$exeArray = $this->getExeArray($propArray);		

		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
		
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			array_push($result, $row);
		}
		return $result;
	
	}
	
	//getExpiredRows
	public function getExpiredRows($table, $propArray, $timeFieldName, $timeWindowInSec){
	
		$timeMysql = date('Y-m-d H:i:s', time()-$timeWindowInSec);
		//$sql = "SELECT COUNT(*) FROM worker_status where page='$dbLabel' AND worker_status.last_ping>='$timeMysql'";
	
		$chainedKeys = $this->getChainedFieldsAnd($propArray);
		$sql = "SELECT * FROM $table WHERE $chainedKeys";
	
		$sql .= " AND $timeFieldName < '$timeMysql'";
		$sql .= " ORDER BY id";
	
		$exeArray = $this->getExeArray($propArray);
	
		$sth = $this->dbh->prepare($sql);
		$sth->execute($exeArray);
	
		$result = array();
		while($row = $sth->fetch(PDO::FETCH_ASSOC, PDO::FETCH_ORI_NEXT)){
			array_push($result, $row);
		}
		return $result;
	
	}
	
	/*
	private function getDBHandler() {
		return $this->$dbh;
	}
	*/
	
}

?>