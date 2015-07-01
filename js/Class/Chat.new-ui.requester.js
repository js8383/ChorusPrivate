Chat.prototype.postChatRequester = function(chatLine){
	
	if(chatLine.trim().length==0){
		alert("Empty input!");
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
        	scrollToBottom($("#chat-area"), 1000);
        	//alert(d);
        	//$("body").append(d);
        }
	});
	
};

/*
 * Order by acceptedTime, so chat_id is NOT always incremantal in <ul>
 */
Chat.prototype.fetchNewChatRequester = function(chatArea, callbackType){
	
	
	
	var workerId = this.mturk.workerId;
	
	var lastChatId = -1;
	var lastChat = $(chatArea).find("li:last-child");
	if(lastChat&&lastChat!=null&&lastChat.length>0){
		lastChatId = $(lastChat).attr("chat_id");
	}

	//alert(lastChatId);
	//$("body").append("<p>"+lastChatId+"</p>");
	
	$.ajax({
        url: "php/chatProcess.php",
        type: "POST",
        data: {
        	action: "fetchNewChatRequester",
        	role: this.role,
            task: this.mturk.task,
            workerId: workerId,
            lastChatId: lastChatId
        },
        success: function (chatArrayJsonStr) {//this part is same as crowds
        	//$("body").append(chatArrayJsonStr);
        	if(chatArrayJsonStr){
            	//$("body").append(chatArrayJsonStr);
            	var newChatArray = JSON.parse(chatArrayJsonStr);
            	//var nowLastId = -1;
            	if(newChatArray.length>0){
            		
            		var lastWorkerId = "";
            		var lastLine = "";
            		var lastRole = "";
            		
            		for(var i=0;i<newChatArray.length;i++){
            			
            			lastWorkerId = newChatArray[i].workerId;
            			//lastLine = newChatArray[i].chatLine;
            			lastRole = newChatArray[i].role;
            			
            			$(chatArea).append(chatToLiRequester(newChatArray[i]));
            			
            			//$("body").append("done: "+this.lastChatId);
            			//this.lastChatId = newChatArray[i].id;
            			
            		}
            		
            		if(callbackType=="initial"){//initial load page
            			this.updateChatNotice;
            			scrollToBottom($("#chat-area"), 1000);
            		}else if(callbackType=="update"){//regular new chat
            			//if the last chat it posted by current worker, don't show the notice
            			//becasue the bottom scroll down first!
            			
            			//input[name=myradiobutton]:radio:checked
            			var soundMode = $("#soundNoticeConf").find("input:checked").attr("value");
            			var vizMode = $("#newMessageNoticeConf").find("input:checked").attr("value");
            			//alert(vizMode);
            			
            			if(lastWorkerId==workerId&&lastRole=="requester"){
            				//alert("It's you!");
            			}else{
            				if(vizMode=="notice"){
            					$("#newMessages").show();
            				}else{
            					scrollToBottom($("#chat-area"), 1000);
            				}
            				
            			}
            			
            			//list = ['This is sentence 1', 'This is sentence 2', 'This is sentence 3', 'This is sentence 4', 'This is sentence 5', 'This is sentence 6', 'This is sentence 7', 'This is sentence 8', 'This is sentence 9'];
            			//ttsSpeakChats(list);
            			
            			if(soundMode=="none"){
            				//nothing
            			}else if(soundMode=="beep"){
            				playSound("crowd");
            			}else if(soundMode=="tts"){
            				
            				if('speechSynthesis' in window){
            					//alert("tts");
            					var nowChatsToBeSpoken =  new Array();
                				for(var i=0;i<newChatArray.length;i++){
                					if(newChatArray[i].role!="requester"){
                						nowChatsToBeSpoken.push(newChatArray[i].chatLine);
                						//ttsSpeak(newChatArray[i].chatLine);
                					}
                        		}
                				ttsSpeakChats(nowChatsToBeSpoken);
                			}
            			}
            			
            			//TTS works
            			/*
            			if('speechSynthesis' in window){
            				var nowChatsToBeSpoken =  new Array();
            				for(var i=0;i<newChatArray.length;i++){
            					if(newChatArray[i].role!="requester"){
            						nowChatsToBeSpoken.push(newChatArray[i].chatLine);
            						//ttsSpeak(newChatArray[i].chatLine);
            					}
                    		}
            				ttsSpeakChats(nowChatsToBeSpoken);
            			}else{
            				playSound("crowd");
            			}
            			*/
            			
            			
            			//playSound("crowd");
            		}	
            	} 	
        	}
        }
	});
	
}

function chatToLiRequester(chatRow){
	
	

	var resultLi = $("<li></li>");
	
	//$(resultLi).attr("votes", 0);
	$(resultLi).attr("status", 1);
	$(resultLi).attr("rejected", 0);
	$(resultLi).attr("chat_id", chatRow.id);
	$(resultLi).attr("id", "chat_"+chatRow.id);
	
	//$(resultLi).addClass("messages");
	$(resultLi).addClass("confirmed");
	
	//$(resultLi).addClass(chatRow.role);
	/*
	if(chatRow.role=="crowd"){
		$(resultLi).addClass("inplay");
	}
	*/
	/*
	var nowRoleName = "C";
	if(chatRow.role=="requester"){
		nowRoleName = "R";
	}
	var roleSpan = "<span class='role'>"+nowRoleName+"</span>";
	$(roleSpan).addClass("crowd");
	if(chatRow.role=="requester"){
		$(roleSpan).addClass("REQUEST");
	}
	*/
	
	var usernameSpan = "<span class='username'>"+chatRow.workerId+"</span>";
	//var messageSpan = "<span class='message'>"+chatRow.chatLine+"</span>";
	//resultLi.append(roleSpan);
	resultLi.append(usernameSpan);
	//resultLi.append(messageSpan);
	
	
	if(chatRow.role=="requester"){
		var nowRoleAvatar = "<span class='avatar-r role REQUEST'>R</span>";
		resultLi.append(nowRoleAvatar);
	}else{
		var nowRoleAvatar = "<span class='avatar-c role' id='crowd'>C</span>";
		resultLi.append(nowRoleAvatar);
	}
	
	var messageSpan = $("<span class='messages'>"+chatRow.chatLine+"</span>");
	if(chatRow.role=="requester"){
		$(messageSpan).addClass("requester");
	}else{
		$(messageSpan).addClass("crowd");
	}
	resultLi.append(messageSpan);
	
	/*
	 * <li status="1" rejected="0" chat_id="889" id="chat_889" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span>
                        <span class="role REQUEST">R</span>
                        <span class="messages requester">How are you?</span>
                    </li>
                                                                    
                    <li status="1" rejected="0" chat_id="890" id="chat_890" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span> 
                        <span class="role" id="crowd">C</span>
                        <span class="messages crowd">I'm fine. And you?</span>
                    </li>        

	 * 
	 * 
	 * 
	 */
	
	/*
	if(chatRow.accepted==1){
		$(resultLi).addClass("confirmed");
		var visibleSpan = "<span class='visible'>visible</span>";
		resultLi.append(visibleSpan);
	}else{
		var visibleSpan = "<span class='visible'>invisible</span>";
		resultLi.append(visibleSpan);
	}
	*/
	
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