function Chat(role, mturkObj) {

  this.role = role;
  this.mturk = mturkObj;
  //this.lastChatId = -1;
  
}

function validateChat(chatLine){
	//var result = [];
	if(chatLine.trim().length==0){
		return "Empty input!";
	}
	if(dupChat(chatLine)){
		return "Duplicate chat!";
	}
	if(noMoreChat()){
		return "No more chats left. Please wait.";
	}
	return true;
}

function noMoreChat(){
	//alert($(".msgNotice").length);
	if($(".msgNotice").length==0){
		return true;
	}
	return false;
}

function dupChat(chatLine){
	//var recentCrowdChats = $("#chat-area li.requester:last").nextAll("li");
	var formattedChatLine = chatLine.trim().toUpperCase();
	
	var recentChats = $("#chat-area li.requester:last").nextAll("li");
	for(var i=0;i<recentChats.length;i++){
		if($(recentChats[i]).children("span.message").text().trim().toUpperCase()==formattedChatLine){
			return true;
		}
	}
	
	return false;
	//alert(recentCrowdChats.length);
}



function playSound(role) {
	
    switch(role){
    
    	case "requester": 
    		requesterSound = soundManager.createSound({
    			id:'requester',
    			url:'sounds/beep-message.mp3'
    		});
    		soundManager.play('requester');
    	break;
    	
    	case "crowd":
    		crowdSound = soundManager.createSound({
    			id:'crowd',
    			url:'sounds/beep-suggestion.mp3'
    		});
    		soundManager.play('crowd');
    	break;
    	
    }
    
}

function scrollToBottom(div, speed){
	$(div).animate({
		scrollTop: $(div)[0].scrollHeight
	}, speed);
}

