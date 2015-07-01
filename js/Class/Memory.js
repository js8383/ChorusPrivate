function Memory(mturkObj) {

  this.mturk = mturkObj;
  
}

Memory.prototype.sortMemory = function(memoryArea){
	
	memoryArea.find('li').sort(compareMemory).appendTo(memoryArea);
	
}

//sort memory, smaller is on top
function compareMemory(a, b) {

	var dateA = getDateFromMemory(a);
	var dateB = getDateFromMemory(b);
	
	var voteNumA = $(a).attr("votes");
	var voteNumB = $(b).attr("votes");
	
	var updatedDateA = new Date(dateA.getTime()+voteNumA*secondPerMemoryVote*1000);
	var updatedDateB = new Date(dateB.getTime()+voteNumB*secondPerMemoryVote*1000);
	
	//if (a is closer to top than b) {
	if(updatedDateA>updatedDateB){
		return -1;
	}
	
	//if (b is closer to top than a) {
	if(updatedDateA<updatedDateB){
		return 1;
	}
	
	// a must be equal to b
	return 0;
	
}

function getDateFromMemory(a){
	
	var tA = $(a).attr("timestamp").split(/[- :]/);
	var dateA = new Date(tA[0], tA[1]-1, tA[2], tA[3], tA[4], tA[5]);
	
	return dateA;
	
}

//post memory
Memory.prototype.postMemory = function(memoryLine){
	
	var validateResult = validateMemory(memoryLine);
	if(validateResult!=true){
		alert(validateResult);
		return false;
	}
	
	$.ajax({
        url: "php/memoryProcess.php",
        type: "POST",
        async: false,
        data: {
        	action: "postMemory",
            task: this.mturk.task,
            workerId: this.mturk.workerId,
            memoryLine: memoryLine
        },
        success: function (d) {
        	if(d){
        		//alert(d);
	        	//$("#debug").append(d);
        	}else{
        		//alert("Don't vote the same chat twice!");
        	}
        	
        }
	});
	
};

function validateMemory(memoryLine){
	//var result = [];
	if(memoryLine.trim().length==0){
		return "Empty input!";
	}
	
	/*
	if(dupMemory(memoryLine)){
		return "Duplicate chat!";
	}
	*/
	
	/*
	if(noMoreChat()){
		return "No more chats left. Please wait.";
	}
	*/
	
	return true;
}
/*
function dupMemory(memoryLine){
	//var recentCrowdChats = $("#chat-area li.requester:last").nextAll("li");
	var formattedMemoryLine = memoryLine.trim().toUpperCase();
	
	var recentChats = $("#highlight-list li.requester:last").nextAll("li");
	for(var i=0;i<recentChats.length;i++){
		if($(recentChats[i]).children("span.message").text().trim().toUpperCase()==formattedChatLine){
			return true;
		}
	}
	
	return false;
	//alert(recentCrowdChats.length);
}
*/

/*
 * Fetch new memory based on last fetched memory_id
 * Note that memory sort by the score and time, so the memory_id is NOT incremental
 */
Memory.prototype.fetchNewMemory = function(memoryArea){
	
	var lastMemoryId = -1;
	var memoryLis = $(memoryArea).find("li");
	if(memoryLis&&memoryLis!=null&&memoryLis.length>0){
		for(var i=0;i<memoryLis.length;i++){
			var nowMemoryId = $(memoryLis[i]).attr("memory_id");
			if(nowMemoryId>lastMemoryId){
				lastMemoryId = nowMemoryId;
			}
		}
	}
	//alert(lastMemoryId);
	
	var workerId = this.mturk.workerId;
	//alert(workerId);
	
	//return false;
	
	$.ajax({
        url: "php/memoryProcess.php",
        type: "POST",
        async: false,//avoid dup chat lines display
        data: {
        	action: "fetchNewMemory",
        	//role: this.role,
            task: this.mturk.task,
            workerId: this.mturk.workerId,
            lastMemoryId: lastMemoryId
        },
        success: function (memoryArrayJsonStr) {
        	
        	//$("body").append(chatArrayJsonStr);
        	
        	//$("body").append(chatArrayJsonStr);
        	if(memoryArrayJsonStr){
            	//$("body").append(chatArrayJsonStr);
            	var newMemoryArray = JSON.parse(memoryArrayJsonStr);
            	//var nowLastId = -1;
            	if(newMemoryArray.length>0){
            		
            		//var lastWorkerId ="";
            		//var lastRole = "";
            		
            		for(var i=0;i<newMemoryArray.length;i++){
            			//lastWorkerId = newMemoryArray[i].workerId;
            			//lastRole = newChatArray[i].role;
            			//odd-chat-highlight
            			var nowLi = memoryToLi(newMemoryArray[i]);
            			/*
            			if(i%2==1){
            				$(nowLi).addClass("odd-chat-highlight");
            			}
            			*/
            			$(memoryArea).prepend(nowLi);
            		}
            		
            		memoryLis = $(memoryArea).find("li");
            		if(memoryLis&&memoryLis!=null&&memoryLis.length>0){
            			for(i=0;i<memoryLis.length;i++){
            				if(i%2==1){
            					$(memoryLis[i]).addClass("odd-chat-highlight");
            				}else{
            					$(memoryLis[i]).removeClass("odd-chat-highlight");
            				}
            				/*
            				var nowMemoryId = $(memoryLis[i]).attr("memory_id");
            				if(nowMemoryId>lastMemoryId){
            					lastMemoryId = nowMemoryId;
            				}
            				*/
            			}
            		}
            		
            		/*
            		if(callbackType=="initial"){//initial load page
            			
            			this.updateChatNotice;
            			scrollToBottom($("#chat-area"), 1000);
            			
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
            		*/
            		
            	}
            	
        	}
        	
        	
        }
	});
	
}

function memoryToLi(memoryRow){
	
	/*
	 * <li memory_id="-1" id="3_highlight" score="1" style="display: block;">
								
								
								<div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar memoryImportant"></i>
									<!-- 
									<input type="button" class="minus-button" value="-">
									<input type="button" class="plus-button" value="+">
									 -->
								</div>
								
								Allergy to sea food
							</li>
	 */
	
	var resultLi = $("<li></li>");
	
	$(resultLi).attr("title", "Click to upvote (or downvote) this fact!");
	$(resultLi).attr("memory_id", memoryRow.id);
	$(resultLi).attr("id", "memory_"+memoryRow.id);
	$(resultLi).attr("workerId", memoryRow.workerId);
	$(resultLi).attr("timestamp", memoryRow.time);
	$(resultLi).attr("votes", 0);

	//var t = (memoryRow.time).split(/[- :]/);
	// Apply each element to the Date function
	//var d = new Date(t[0], t[1]-1, t[2], t[3], t[4], t[5]);
	//alert(d);
	
	$(resultLi).addClass("memory");
	
	var starDiv = "<div class='plus-minus-buttons'><i class='fa fa-star memoryStar'></i></div>";
	
	resultLi.append(starDiv);
	resultLi.append(memoryRow.memoryLine);
	
	return resultLi;
	
}