//last loaded chat ID
//var lastChatId = -1;

//create ID (but not in DB yet)
var nowMturk = new MTurk();

//js objects
var nowChat = new Chat("crowd", nowMturk);
var nowVote = new Vote(nowMturk);
var nowMemory = new Memory(nowMturk);

$(document).ready(function () {

	nowMturk.log();
	nowChat.fetchNewChat($("#chat-area"), 'initial');
	nowVote.updateVotedChat($("#chat-area"));
	nowChat.expireChats($("#chat-area"));
	
	nowMemory.fetchNewMemory($("#highlight-list"));
	//nowMemory.sortMemory($("#highlight-list"));
	
	setInterval(function(){
		
		nowMturk.log();
		
		nowChat.fetchNewChat($("#chat-area"), 'update');
		nowChat.updateChatNotice();
		nowChat.expireChats($("#chat-area"));
		
		nowVote.updateVotedChat($("#chat-area"));
		nowVote.updateChatVoteResult($("#chat-area"));
		
		nowMemory.fetchNewMemory($("#highlight-list"));
		//nowMemory.sortMemory($("#highlight-list"));
		
	}, 500);
	
	$("#txt").keypress(function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			submitChat($("#txt").val().trim());
		}
	});
	
	$("#memoryType").keypress(function(e) {
		if (e.keyCode == 13) {
			e.preventDefault();
			submitMemory($("#memoryType").val().trim());
		}
	});
	
	$("#submit-chat").click(function(){
		submitChat($("#txt").val().trim());
	});
	
	$("#newMessages").on("click", function(){
		scrollToBottom($("#chat-area"), 1000);
		$("#newMessages").hide();
	});
	
	$("#chat-area").on("click", "li.inplay", function(){
		$(this).removeClass("inplay");
		$(this).addClass("voted");
		var nowChatId = $(this).attr("chat_id");
		nowVote.postVote(nowChatId, "chat");
		legion_reward("vote", $(this));
	});
	
	$("#highlight-list").on("click", "li.memory", function(){
		
		if(!$(this).hasClass("votedMemory")){
			$(this).addClass("votedMemory");
			$(this).attr("votes", 10);
			var nowMemoryId = $(this).attr("memory_id");
			nowVote.postVote(nowMemoryId, "memory");
			//no reward on this.
		}
	});
	
});

function submitChat(chatLine){
	nowChat.postChat(chatLine);
	$("#txt").val("");
}

function submitMemory(memoryLine){
	nowMemory.postMemory(memoryLine);
	$("#memoryType").val("");
}
