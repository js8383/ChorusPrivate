//create ID (but not in DB yet)
var nowMturk = new MTurk();

//js objects
var nowChat = new Chat("requester", nowMturk);

$(document).ready(function () {
	
	$("#workerTimeoutNum").text(workerTimeoutInSec);
	$("#chatTimeoutNum").text(chatTimeoutInSec);
	$("#agreementThresh").text(consentProportion*100);
	
	//nowChat.fetchNewChat($("#chat-area"), 'initial');
	nowChat.fetchNewChatRequester($("#chat-area"), 'initial');
	nowMturk.updateActiveWorkerNum($("#activeWorkerNum"));
	//nowChat.updateChatNotice();
	
	setInterval(function(){
		nowChat.fetchNewChatRequester($("#chat-area"), 'update');
		nowMturk.updateActiveWorkerNum($("#activeWorkerNum"));
		//nowChat.updateChatNotice();
	}, 500);
	
	$("#txt").keypress(function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			submitChat($("#txt").val().trim());
			$("#txt").val("");
		}
	});
	
	$("#submit-chat").click(function(){
		submitChat($("#txt").val().trim());
		$("#txt").val("");
	});
	
	$("#newMessages").on("click", function(){
		scrollToBottom($("#chat-area"), 1000);
		$("#newMessages").hide();
	});
	
});

function submitChat(chatLine){
	nowChat.postChatRequester(chatLine);
	//alert(chatLine);
}