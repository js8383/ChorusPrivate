/*
 * Notice of #remaining messages
 */
Chat.prototype.updateChatNotice = function(){
	
	var chatSentNum = 0;
	var recentChats = $("#chat-area li.requester:last").nextAll("li");
	for(var i=0;i<recentChats.length;i++){
		if($(recentChats[i]).children("span.username").text().trim()==this.mturk.workerId){
			chatSentNum++;
		}
	}
	//alert(maxChatNum);
	
	var newChatRemainNum = maxChatNum-chatSentNum;
	//alert(newChatRemainNum);
	if(newChatRemainNum>0){
		var nowChatRemainNum = $("img.msgNotice").length;
		//alert(nowChatRemainNum);
		if(nowChatRemainNum>newChatRemainNum){//remove
			var removedNum = nowChatRemainNum-newChatRemainNum;
			for(var i=0;i<removedNum;i++){
				$("img.msgNotice:last").remove();
				//alert("remove");
			}
		}else if(nowChatRemainNum<newChatRemainNum){//add
			//alert("nowChatRemainNum: "+nowChatRemainNum);
			//alert("newChatRemainNum: "+newChatRemainNum);
			var addedNum = newChatRemainNum-nowChatRemainNum;
			for(var i=0;i<addedNum;i++){
				var nowMsgNotice = $("<img class='icons msgNotice'></img>");
				nowMsgNotice.attr("src", "image/icon.gif");
				nowMsgNotice.attr("title", "message");
				nowMsgNotice.css("display", "inline");
				$("#participation").append(nowMsgNotice);
				//alert("add");
				//alert(i);
				//alert("nowChatRemainNum: "+nowChatRemainNum);
				//alert("newChatRemainNum: "+newChatRemainNum);
			}
			
		}
	}else{
		$("img.msgNotice").remove();
	}
	
	var newChatLeftNum = $("img.msgNotice").length;
	$("#votes-allowed").text(newChatLeftNum);
	if(newChatLeftNum<=0){
		$("#txt").prop('disabled', true);
		//$("#txt").val("Maximum number of messages has been reached. Please wait for requester's response. (Vote is still allowed!)");
	}else{
		$("#txt").prop('disabled', false);
		//$("#txt").val("");
	}
	
}

/*
 * Crowd post chat, role = 'crowd'; (always)
 */
Chat.prototype.postChat = function(chatLine){
	
	//var role = this.role;
	
	var validateResult = validateChat(chatLine);
	if(validateResult!=true){
		alert(validateResult);
		return false;
	}
	
	$.ajax({
        url: "php/chatProcess.php",
        type: "POST",
        async: false,
        data: {
        	action: "post",
            role: this.role,
            task: this.mturk.task,
            workerId: this.mturk.workerId,
            chatLine: chatLine
        },
        success: function (d) {
        	
        	//$("body").append(d);
        	$("#newMessages").hide();
        	scrollToBottom($("#chat-area"), 1000);
        	//if(role=='crowd'){
        	//post chat get some point
        	legion_reward("message", $("#txt"));
        	//}
        	
        	//alert(d);
        	//$("body").append(d);
        }
	});
	
};

/*
 * get the latest expired chat ID,
 * expired the chat
 */
Chat.prototype.expireChats = function(chatArea){
	
	$.ajax({
        url: "php/chatProcess.php",
        type: "POST",
        data: {
        	action: "expireChats",
        	role: this.role,
            task: this.mturk.task,
            workerId: -1,
            chatTimeoutInSec: chatTimeoutInSec
        },
        success: function (lastExpiredChatId) {
        	
        	lastExpiredChatIdVal = parseInt(lastExpiredChatId);
        	//$("body").append(lastExpiredChatId);
        	//var lastExpiredChatId = 10000;
        	
        	$(chatArea).find("li.voted").each(function() {
        		//alert("!");
        		//if($(this).hasClass("voted")||$(this).hasClass("inplay")){
        			if(parseInt($(this).attr("chat_id"))<=lastExpiredChatIdVal){
        				$(this).removeClass("voted");
        				//$(this).removeClass("inplay");
        				$(this).addClass("expired");
        				$(this).find(".visible").text("expired");
        			}
        		//}
        	});
        	
        	$(chatArea).find("li.inplay").each(function() {
        		//if($(this).hasClass("voted")||$(this).hasClass("inplay")){
        			if(parseInt($(this).attr("chat_id"))<=lastExpiredChatIdVal){
        				//$(this).removeClass("voted");
        				$(this).removeClass("inplay");
        				$(this).addClass("expired");
        				$(this).find(".visible").text("expired");
        			}
        		//}
        	});
        	
        	
        }
	});
	
	
}

/*
 * Fetch new chat based on last fetched chat_id
 * chat only appends at the end
 */
Chat.prototype.fetchNewChat = function(chatArea, callbackType){
	
	var lastChatId = -1;
	var lastChat = $(chatArea).find("li:last-child");
	if(lastChat&&lastChat!=null&&lastChat.length>0){
		lastChatId = $(lastChat).attr("chat_id");
	}
	
	var workerId = this.mturk.workerId;
	//alert(workerId);
	
	$.ajax({
        url: "php/chatProcess.php",
        type: "POST",
        async: false,//avoid dup chat lines display
        data: {
        	action: "fetchNewChat",
        	role: this.role,
            task: this.mturk.task,
            workerId: this.mturk.workerId,
            lastChatId: lastChatId
        },
        success: function (chatArrayJsonStr) {
        	//$("body").append(chatArrayJsonStr);
        	if(chatArrayJsonStr){
            	//$("body").append(chatArrayJsonStr);
            	var newChatArray = JSON.parse(chatArrayJsonStr);
            	//var nowLastId = -1;
            	if(newChatArray.length>0){
            		
            		var lastWorkerId ="";
            		var lastRole = "";
            		
            		for(var i=0;i<newChatArray.length;i++){
            			lastWorkerId = newChatArray[i].workerId;
            			lastRole = newChatArray[i].role;
            			$(chatArea).append(chatToLi(newChatArray[i], workerId));
            		}
            		
            		if(callbackType=="initial"){//initial load page
            			this.updateChatNotice;
            			scrollToBottom($("#chat-area"), 1000);
            			/*
            			$("#chat-area").animate({
            				scrollTop: $('#chat-area')[0].scrollHeight
            			}, 1000);
            			*/
            		}else if(callbackType=="update"){//regular new chat
            			//if the last chat it posted by current worker, don't show the notice
            			//becasue the bottom scroll down first!
            			if(lastWorkerId==workerId&&lastRole=='crowd'){
            				//alert("It's you!");
            			}else{
            				$("#newMessages").show();
            			}
            			playSound("crowd");
            			//$("#newMessages").show();
            		}
            		
            		
            	}
            	
        	}
        }
	});
	
}

function chatToLi(chatRow, workerId){
	
	var resultLi = $("<li></li>");
	
	$(resultLi).attr("votes", 0);
	$(resultLi).attr("status", 0);
	$(resultLi).attr("rejected", 0);
	$(resultLi).attr("chat_id", chatRow.id);
	$(resultLi).attr("id", "chat_"+chatRow.id);
	
	$(resultLi).addClass("messages");
	
	$(resultLi).addClass(chatRow.role);
	if(chatRow.role=="crowd"){
		$(resultLi).addClass("inplay");
	}
	
	var roleSpan = "<span class='role'>"+chatRow.role+"</span>";
	var usernameSpan = "<span class='username'>"+chatRow.workerId+"</span>: ";
	var messageSpan = "<span class='message'>"+chatRow.chatLine+"</span>";
	resultLi.append(roleSpan);
	resultLi.append(usernameSpan);
	resultLi.append(messageSpan);
	
	if(chatRow.accepted==1){
		$(resultLi).removeClass("inplay");
		$(resultLi).addClass("confirmed");
		var visibleSpan = "<span class='visible'>visible</span>";
		resultLi.append(visibleSpan);
	}else{
		var visibleSpan = "<span class='visible'>invisible</span>";
		resultLi.append(visibleSpan);
		
		if(chatRow.workerId==workerId){
			$(resultLi).removeClass("inplay");
			$(resultLi).addClass("voted");
		}
		
	}
	
	/*
	<li votes="0" class="messages crowd inplay" chat_id="14073" id="chat_14073" status="0" rejected="0">
    	<span class="role">crowd</span>
    	<span class="username">ni7dkoc4o9j1ssce090j2ssc12</span>:
    	<span class="message">Hello</span>
    	<span class="visible">visible</span>
    </li>
    */
	
	return resultLi;
	
}
