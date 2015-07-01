<?php 

require_once 'DB.php';

abstract class UserAction{
	
	private $id;
	private $table;
	
	public function __construct($table){
		$this->$table = $table;
	}
	
	/*
	private $type;
	
	private $task;
	private $taskId;
	
	private $stage;
	private $stageId;
	
	private $mturkObj;
	*/
	
	//abstract protected function getValue();
	//abstract protected function prefixValue($prefix);
	
	function index($propArray){
		$dbh = new DB();
		$this->$id = $dbh->index($this->$table, $propArray);
	}
	
}

?>