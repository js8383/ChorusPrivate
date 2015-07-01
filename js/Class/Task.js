function Task() {

  this.;
  
}


//-------------------------------------------------------

Vote.prototype.postVote = function(voteTo, type){
	
	$.ajax({
        url: "php/voteProcess.php",
        type: "POST",
        async: false,
        data: {
        	voteTo: voteTo,
        	action: "post",
        	type: type,
            task: this.mturk.task,
            //stage: stage,
            workerId: this.mturk.workerId
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

//update vote result, return list of accepted chats
Vote.prototype.updateChatVoteResult = function(chatArea){
	
	//var type = "chat";
	var workerId = this.mturk.workerId;
	
	$.ajax({
        url: "php/voteProcess.php",
        type: "POST",
        //async: false,
        data: {
        	action: "updateChatVoteResult",
            task: this.mturk.task,
            consentProportion: consentProportion,
            workerTimeoutInSec: workerTimeoutInSec,
            chatTimeoutInSec: chatTimeoutInSec,
            workerId: -1
            //type: type
        },
        success: function (acceptedChatsStr) {
        	
        	//$("body").append(acceptedChatsStr);
        	
        	if(acceptedChatsStr&&acceptedChatsStr!=null&&acceptedChatsStr.length>0){
        		var acceptedChats = JSON.parse(acceptedChatsStr);
	        	for(var i=0;i<acceptedChats.length;i++){
	        		
	        		$(chatArea).find("li[chat_id="+acceptedChats[i]+"]").each(function(){
	        			
	        			//accept an unaccepted chat
	        			if(!$(this).hasClass("confirmed")){
	        				//if the worker voted for this chat, add score
	        				if($(this).hasClass("voted")){
	        					var nowChatWorker = $(this).find(".username").text().trim();
	        					if(nowChatWorker==workerId){//if proposed by the worker
	        						legion_reward("message_accepted", $(this));
	        					}else{//if voted by the worker
	        						legion_reward("voted_for_accepted", $(this));
	        					}
	        					$(this).removeClass("voted");
			        			$("#chat-accepted-container").stop().show();
			        		    setTimeout(function() {
			        				$("#chat-accepted-container").stop().hide('slow');
			        		    }, 3000);
	        				}
	        				$(this).removeClass("inplay");
		        			$(this).addClass("confirmed");
		        			$(this).find("span.visible").text("visible");
		        			
	        			}
	        			
	        		});
	        		
	        	}
        	}
        	
        }
	});
	
}

//update voted chat, skip if accepted
Vote.prototype.updateVotedChat = function(chatArea){
	
	var type = "chat";
	
	$.ajax({
        url: "php/voteProcess.php",
        type: "POST",
        data: {
        	action: "getVotedChats",
        	type: type,
            task: this.mturk.task,
            workerId: this.mturk.workerId
        },
        success: function (votedChatsStr) {
        	
        	//$("body").append(votedChatsStr);
        	
        	if(votedChatsStr&&votedChatsStr!=null&&votedChatsStr.length>0){
        		var votedChats = JSON.parse(votedChatsStr);
	        	for(var i=0;i<votedChats.length;i++){
	        		
	        		$(chatArea).find("li[chat_id="+votedChats[i]+"]").each(function(){
	        			
	        			if($(this).hasClass("inplay")){
	        				$(this).removeClass("inplay");
	        				$(this).addClass("voted");
	        				//$(chatArea).find("li[chat_id="+votedChats[i]+"]").removeClass("inplay");
	    	        		//$(chatArea).find("li[chat_id="+votedChats[i]+"]").addClass("voted");
	        			}
	        			
	        		});
	        		
	        		
	        	}
        	}
        	
        }
	});
	
	
}

//update the voted chat/parameter for each worker
Vote.prototype.updateVoteCandidate = function(candidateDiv, type){
	
	var votedLis = $(candidateDiv).children("li.voted");//.attr(type+"Id");
	//alert(votedLis.length);
	var votedArray = new Array();
	for(var i=0;i<votedLis.length;i++){
		votedArray.push($(votedLis[i]).attr(type+"Id"));
	}
	
	//alert(votedArray.toString());
	var votedArrayJson = JSON.stringify(votedArray);

	
	//var type = this.type;
	var task = this.task;
	var stage = this.stage;
	//var mturkObj = this.mturkObj;
	
	$.ajax({
	      url: "php/mturkProcess.php",
	      type: "POST",
	      async: false,
	      data: {
	      	  action: "getId",
	      	  hitId: this.mturkObj.hitId,
	      	  assignmentId: this.mturkObj.assignmentId,
	      	  workerId: this.mturkObj.workerId,
	      	  turkSubmitTo: this.mturkObj.turkSubmitTo,
	      	  task: this.mturkObj.task
	      },
	      success: function (mturkId) {
	    	  
	    	  //alert(mturkId);
	    	  
	    	  $.ajax({
	    	        url: "php/voteProcess.php",
	    	        type: "POST",
	    	        async: false,
	    	        data: {
	    	        	votedArrayStr: votedArrayJson,
	    	        	action: "update",
	    	        	type: type,
	    	            task: task,
	    	            stage: stage,
	    	            mturkId: mturkId
	    	        },
	    	        success: function (d) {
	    	        	
	    	        	//$("#debug").append(d);
	    	        	//alert(d);
	    	        	
	    	        	if(d){
	    	        		var newSelectedArray = JSON.parse(d);
		    	        	
		    	        	for(var i=0;i<newSelectedArray.length;i++){
		    	        		var nowTypeId = newSelectedArray[i];
		    	        		$(candidateDiv).children("li["+type+"Id='"+nowTypeId+"']").addClass("voted");
		    	        	}
	    	        	}
	    	        	
	    	        }
	    		});
	      
	    	
	    	  
	      }
		});
	
	
};

//chat converge -> set accepted to true, end (simple!)
//Vote.prototype.updateChatVoteResult = function(){
	
	
	
	
//};

// parameter converge
// (1) set stage done as true
// (2) set parameter value
// others leave it to task!
Vote.prototype.updateParameterVoteResult = function(){
	
	$.ajax({
        url: "php/voteProcess.php",
        type: "POST",
        async: false,
        data: {
        	//voteTo: voteTo,
        	action: "updateParameterVoteResult",
            task: task,
            stage: stage,
            mturkId: -1
        },
        success: function (d) {
        	
        	//if(d){
        		
        		//var nowChat = new Chat("crowd", task);
        		
        		//alert(d);
	        	$("#debug").append(d);
        	//}
        	
        }
	});
	
	
};

/*
Parameter.prototype.postToDB = function(chatLine, mturkId){
	
	$.ajax({
        url: "php/chatProcess.php",
        type: "POST",
        async: false,
        data: {
        	mturkId: mturkId,
        	action: "post",
            role: this.role,
            task: this.task,
            chatLine: chatLine
        },
        success: function (d) {
        	//alert(d);
        	//$("#debug").append(d);
        }
	});
	
}
*/
/*
Parameter.prototype.update = function(chatArea){
	
	//alert ("");
	var nowLineNum = $(chatArea).children("li").length;
	//alert("nowLineNum: "+nowLineNum);
	
	$.ajax({
        url: "php/parameterProcess.php",
        async: false,
        type: "POST",
        data: {
        	action: "update",
            //role: this.role,
            task: this.task,
            task: this.mturkId,
            stage: this.stage,
            nowLineNum: nowLineNum
        },
        success: function (d) {
        	//alert("success: "+d);
        	if(d){	
        		chatArea.append(d);
        		//alert(d);
            	//$("#debug").append(d);
        	}
        	
        	//if(){
        		
        	//}
        	
        	
        }
	});
	
	
};
*/


