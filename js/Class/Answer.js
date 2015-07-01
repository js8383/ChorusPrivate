function Answer(mturkObj) {

  this.mturk = mturkObj;
  //alert(this.mturk);
  
}



//nowAnswer.postAnswer(nowText, nowTime, (+sentCounter)-1, nowSentId, timeInSec);
Answer.prototype.postAnswer = function(answer, timeSpend, inputOrder, sentId, timeInSec){
	
	$.ajax({
        url: "php/answerProcess.php",
        type: "POST",
        async: false,
        data: {
        	action: "postAnswer",
            workerId: this.mturk.workerId,
            hitId: this.mturk.hitId,
	      	assignmentId: this.mturk.assignmentId,
	      	turkSubmitTo: this.mturk.turkSubmitTo,
	      	answer: answer,
	      	timeSpend: timeSpend,
	      	inputOrder: inputOrder,
	      	sentId: sentId,
	      	timeInSec: timeInSec
	      	/*
	      	 * workerId: this.mturk.workerId,
            hitId: this.mturk.hitId,
	      	assignmentId: this.mturk.assignmentId,
	      	turkSubmitTo: this.mturk.turkSubmitTo,
	      	 */
        },
        success: function (d) {
        	
        	$("body").append(d);
        	//$("#newMessages").hide();
        	//scrollToBottom($("#chat-area"), 1000);
        	//if(role=='crowd'){
        	//post chat get some point
        	//legion_reward("message", $("#txt"));
        	//}
        	
        	//alert(d);
        	//$("body").append(d);
        }
	});
	
}
