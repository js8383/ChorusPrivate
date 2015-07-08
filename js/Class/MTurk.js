function MTurk() {
	
  this.hitId = gup('hitId');
  this.assignmentId = gup('assignmentId');
  this.workerId = gup('workerId') ? gup('workerId') : workerId;
  this.turkSubmitTo = gup('turkSubmitTo');
  //alert(this.workerId);
  
  this.task = gup('task') ? gup('task') : taskId;
  // this.task = sessionId;
}

MTurk.prototype.updateActiveWorkerNum = function(spanActiveWorkerNum){
	
	$.ajax({
	      url: "php/mturkProcess.php",
	      type: "POST",
	      data: {
	    	  //score: _score,
	      	  action: "updateActiveWorkerNum",
	      	  hitId: this.hitId,
	      	  assignmentId: this.assignmentId,
	      	  workerId: this.workerId,
	      	  turkSubmitTo: this.turkSubmitTo,
	      	  task: this.task,
	      	  workerTimeoutInSec: workerTimeoutInSec
	      },
	      success: function (workerNum) {
	    	  //$("body").append(workerNum);
	    	  $(spanActiveWorkerNum).text(workerNum);
	      }
		});
	
}

// New Function
MTurk.prototype.logRequester = function() {

	$.ajax({
	      url: "php/mturkProcess.php",
	      type: "POST",
	      data: {
	      	  action: "logRequester",
	      	  hitId: this.hitId,
	      	  assignmentId: "requester",
	      	  workerId: this.workerId,
	      	  turkSubmitTo: this.turkSubmitTo,
	      	  task: this.task,
	      },
	      success: function (d) { 
	      	// alert(d);
	      }
	  });
}

MTurk.prototype.log = function(){
	
	/*
	var url = "php/mturkProcess.php";
	if(this.task=="waitPage"){
		url = "../php/mturkProcess.php";
	}
	*/
	var cachedScore = _score;
	
	$.ajax({
	      url: "php/mturkProcess.php",
	      type: "POST",
	      data: {
	    	  score: _score,
	      	  action: "logWorker",
	      	  hitId: this.hitId,
	      	  assignmentId: this.assignmentId,
	      	  workerId: this.workerId,
	      	  turkSubmitTo: this.turkSubmitTo,
	      	  task: this.task
	      },
	      success: function (d) {
	    	  
	    	  //$("body").append(d);
	    	  
	    	  /*
	    	  alert("_score: "+_score);
	    	  alert("updatedScore: "+updatedScore);
	    	  
	    	  if(cachedScore==_score){
	    		  _score = parseInt(updatedScore);
	    	  }else if(_score>cachedScore){
	    		  var addedScore = cachedScore-_score;
	    		  _score = parseInt(updatedScore)+parseInt(addedScore);
	    	  }else{
	    		  alert("Score decreased. Why?");
	    	  }
	    	  */
	    	  //alert(d);
	    	  //$("body").append(d);
	    	  //this.id = d;
	    	  //alert("sccess!");
	    	  //$("#debug").append(d);
	    	  //alert(typeof (this.id));
	      }
		});
	
}

/*
 * Append MTurk parameters to an url
 * (Yeah, I know. But this happens pretty much every day.)
 */
MTurk.prototype.turkifyUrl = function(url){
	
	url = insertParam(url, 'hitId', this.hitId);
	url = insertParam(url, 'assignmentId', this.assignmentId);
	url = insertParam(url, 'workerId', this.workerId);
	url = insertParam(url, 'turkSubmitTo', this.turkSubmitTo);
	
	return url;
	
};

/*
 * Inset a parameter to an url
 * http://stackoverflow.com/questions/486896/adding-a-parameter-to-the-url-with-javascript
 */
function insertParam(url, key, value){
	
    key = encodeURI(key);
    value = encodeURI(value);

    //var s = document.location.search;
    var kvp = key+"="+value;

    var r = new RegExp("(&|\\?)"+key+"=[^\&]*");

    url = url.replace(r,"$1"+kvp);

    if(!RegExp.$1) {url += (url.length>0 ? '&' : '?') + kvp;};

    return url;
    
};
