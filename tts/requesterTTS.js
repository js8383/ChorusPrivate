var speech;
var chatsToBeSpoken = new Array();

var speechInPlay = false;

$(document).ready(function() {
	
	//var msg = new SpeechSynthesisUtterance('Hello World');
    //window.speechSynthesis.speak(msg);
	
	if('speechSynthesis' in window){
		
		speech = new SpeechSynthesisUtterance();
		//doing nothing
	}else{
		//checked="checked"
		$("#tts").hide();
		$("#beep").prop("checked", true);
		//$("#tts").hide();
	}
	
	 //var voices = window.speechSynthesis.getVoices();
	 //speech.voice = voices[2];
	 //alert(voices.length);
	 // SoundManager(smURL, smID) 
	 //var tssSoundManager = new SoundManager("sm2/soundmanager2.js", "GoogleTts");
	 //var googleTTS = new window.GoogleTTS();
	 //googleTTS.play("Hi");
	 //if ('speechSynthesis' in window) {
		 // Synthesis support. Make your web apps talk!
		 //alert("Ha!");
	 //}
});


function ttsSpeakChats(chatArray){
	
	/*
	while(chatArray.length>0){
		chatsToBeSpoken.push(chatArray.shift());
	}
	*/
	//speech = new SpeechSynthesisUtterance();
	//if(speechInPlay){
	//if(speech.pending||pending.speaking){
		//alert("wait");
		//setTimeout(function(){
		//	ttsSpeakChats(chatArray);
		//}, speechTimeoutInMiniSec);
	//}else{
		//alert("play");
		
	    //alert(chatsToBeSpoken.length);
		if(speech!=undefined){
			chatsToBeSpoken = chatArray;
			//speechInPlay = true;
			if(chatsToBeSpoken.length>0){
				//alert("Ha");
				speakChat(0);
	    	}
	    }
	//}
	
	
}

function speakChat(i){
    if(i<chatsToBeSpoken.length){
        var msg = chatsToBeSpoken[i];
        speech.text = msg;
        speech.rate = 0.8;
        speech.onend = function(e) { 
        	setTimeout("speakChat("+i+"+1);", speechTimeoutInMiniSec); 
        };
        window.speechSynthesis.speak(speech);
    }else{
    	//speechInPlay = false;
    }
}
 
function ttsSpeak(text){
	var msg = new SpeechSynthesisUtterance(text.trim());
	msg.rate = 1;
	window.speechSynthesis.speak(msg);
}
