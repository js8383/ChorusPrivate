<?php 

//require_once("MTurk.php");
require_once("DB.php");

class Chat{
	
	private $chatLine;//text of chat
	private $role;//"requester", "crowd"
	
	private $workerId;
	
	private $accepted;
	
	private $speaker;
	private $speakerId;
	
	private $task;
	private $taskId;
	
	private $stage;
	private $stageId;
	
	private $displayName;
	
	private $mturkId;
	
	private $dbh;
	
	public function __construct($role, $workerId, $task){
		$this->role = $role;
		$this->dbh = new DB();
		$this->task = $task;
		$this->workerId = $workerId;
		//$this->$taskId = $this->$dbh->getId("tasks", "task", $this->$speaker);
	}
	
	/*
	public function fetchNewChat($lastChatId){
		
	}
	*/
	/*
	public function setMTurkId($mturkId){
		$this->mturkId = $mturkId;
		//$this->mturkObj = $mturkObj;
		//$this->setSpeaker($this->$mturkObj->getWorkerId());
	}
	*/
	
	public function setDisplayName($displayName){
		$this->displayName = $displayName;
	}
	
	public function setSpeaker($speaker){
		$this->speaker = $speaker;
		$this->speakerId = $this->$dbh->getId("users", "user", $this->$speaker);
	}
	
	/*
	public function setChatLine($chatLine){
		$this->$chatLine = $chatLine;
	}
	*/
	/*
	public function updateChatNotice(){
		
	}
	*/

	public function getLastExpiredChatId($chatTimeoutInSec){
		
		$propArray = array(
				"task" => $this->task
		);
		
		//public function getRowsTimeout($table, $propArray, $timeFieldName, $timeWindowInSec){
		$rows = $this->dbh->getExpiredRows("chat", $propArray, "time", $chatTimeoutInSec);
		if(count($rows)>0){
			return intval($rows[count($rows)-1]['id']);
		}
		return -1;
	}
	
	
	public function fetchNewChatRequester($lastChatId){
		
		$propArray = array(
				"task" => $this->task,
				"accepted" => true
		);
		
		$newLastChatId = $this->dbh->getLastIdOrderBy("chat", $propArray, "acceptedTime");
		//return $lastChatId;
		if($newLastChatId!=$lastChatId){
			$newChats = $this->dbh->getRowsBeginFromEndOrderBy("chat", $propArray, $lastChatId, "acceptedTime");
			//return count($newChats);
			for($i=0;$i<count($newChats);$i++){
				$chatStr = $newChats[$i]['chatLine'];
				$newChats[$i]['chatLine'] = $this->link_it($chatStr);
			}
			//foreach($newChats as $key => $chat){
				//$chat['chatLine'] = $this->link_it($chat['chatLine']);
			//}
			return $newChats;
		}else{
			return false;
		}
		
	}
	
	public function fetchNewChat($lastChatId){
		
		$propArray = array(
				"task" => $this->task
		);
		
		$newLastChatId = $this->dbh->getLastId("chat", $propArray);
		if($newLastChatId>$lastChatId){
			$newChats = $this->dbh->getRowsBeginFrom("chat", $propArray, $lastChatId+1);
			return $newChats;
		}else{
			return false;
		}
		
	}
	
	public function post($chatLine){
		
		//$linkedChatLine = $this->link_it($chatLine);
		
		$timestamp =  date('Y-m-d H:i:s', time());
		//public function updateFields($table, $field, $value, $propArray){
		//$this->dbh->updateFields("mturk", "updateTime", $timestamp, $propArray);
		
		$propArray = array(
			"chatLine" => $chatLine,
			"role" => $this->role,
			"task" => $this->task,
			"workerId" => $this->workerId,
			"acceptedTime" => $timestamp
		);
		
		if($this->role=='requester'||$this->role=='system'){
			$propArray['accepted'] = true;
		}
		
		$chatId = $this->dbh->index("chat", $propArray);
		return $chatId;
		/*
		if($this->$speakerId){
			$this->$speakerId = $dbUtil->getId("users", "user", $this->$speaker);
		}
		*/
		//get speakerId (insert speakerId if new)
		
	}
	
	/*
	 * Make URL a link.
	 * http://buildinternet.com/2010/05/how-to-automatically-linkify-text-with-php-regular-expressions/
	 * http://stackoverflow.com/questions/5341168/best-way-to-make-links-clickable-in-block-of-text
	 */
	function link_it($text){
		//function make_links_clickable($text){
		return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a target="_blank" href="$1">$1</a>', $text);
		//}
		//$text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t&lt;]*)/is", "$1$2&lt;a href=\"$3\" &gt;$3&lt;/a&gt;", $text);
		//$text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r&lt;]*)/is", "$1$2&lt;a href=\"http://$3\" &gt;$3&lt;/a&gt;", $text);
		//$text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1&lt;a href=\"mailto:$2@$3\"&gt;$2@$3&lt;/a&gt;", $text);
		//return($text);
	}
	
	
	//only add chat, no remove
	public function update(){
		
		$propArray = array(
				//"chatLine" => $chatLine,
				//"role" => $this->role,
				"task" => $this->task,
				"accepted" => true
		);
		
		//$newLineNum = $this->dbh->getCount("chat", $propArray);
		//if($nowLineNum<$newLineNum){
			$chatArray = $this->dbh->getRows("chat", $propArray);
			$result = "";
			for($i=0;$i<count($chatArray);$i++){
				$nowChatLi = $this->chatToLi($chatArray[$i]);
				$result .= $nowChatLi;
			}
			return $result;
		//}
		
		
		
		//$newLines = "<li>newLines</li>";
		//return $newLineNum;
		
	}
	
	
	private function chatToLi($chatRow){
		$chatRole = $chatRow['role'];
		if($chatRole=='system'||$chatRole=='crowd'){
			$chatRole = 'chorus';
		}
		$chatLine = $chatRow['chatLine'];
		$chatId = $chatRow['id'];
		//$chatRole are used to set colot
		return "<li class='chat $chatRole' type='chat' chatId='$chatId'><span class='$chatRole'>$chatRole</span>$chatLine</li>";
	}
	
	private function chatCandidateToLi($chatRow){
		$chatRole = $chatRow['role'];
		$chatLine = $chatRow['chatLine'];
		$chatId = $chatRow['id'];
		return "<li class='button chat candidate' type='chat' chatId='$chatId'>$chatLine</li>";
	}
	
	
	//update (both add and remove)
	public function updateCandidate(){
	
		$propArray = array(
				//"chatLine" => $chatLine,
				"role" => $this->role,
				"task" => $this->task,
				"accepted" => false
		);
	
		//$newLineNum = $this->dbh->getCount("chat", $propArray);
		//if($nowLineNum<$newLineNum){
			$chatArray = $this->dbh->getRows("chat", $propArray);
			//return (count($chatArray));
			$result = "";
			for($i=0;$i<count($chatArray);$i++){
				$nowChatLi = $this->chatCandidateToLi($chatArray[$i]);
				$result .= $nowChatLi;
			}
			return $result;
		//}
		//$newLines = "<li>newLines</li>";
		//return $newLineNum;
	
	}
	
}



?>