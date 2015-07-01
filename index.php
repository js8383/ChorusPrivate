<?php session_start();?>

<html>

<head>

	<!-- for fonts~ -->
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<meta name="viewport" content="user-scalable=no" />
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<title>Chorus | Welcome</title>
	
	<!-- Icon -->
	<link rel="shortcut icon" href="image/favicon.ico">
	
	<!-- PHP Javascript Print -->
	<script type="text/javascript">
		var sessionId = "<?php echo session_id(); ?>";
	</script>

	    <!-- variables config -->
    <script src="js/_config.js" type="text/javascript"></script>
    
    <!-- External Lib -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
	
	
	<!-- Internal Lib -->
	<script src="js/lib/gup.js" type="text/javascript"></script>
	<script type="text/javascript" src="sm2/soundmanager2.js"></script>
    
    <!-- legion lib -->
    <script src="legion/legion.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="legion/legion.css">
    
    <!-- Chorus JS Class -->
    <script src="js/Class/MTurk.js" type="text/javascript"></script>
    <script src="js/Class/Chat.js" type="text/javascript"></script>
    <script src="js/Class/Chat.new-ui.requester.js" type="text/javascript"></script>
    
	<!-- Page JS -->    
	<script src="js/requester.js" type="text/javascript"></script>
	

    <link rel="stylesheet" type="text/css" href="new-ui/css/chat.css">
    <link rel="stylesheet" type="text/css" href="new-ui/css/requester.css">
    
    <link rel="stylesheet" type="text/css" href="new-ui/css/kenneth-hack.css">
    


</head>

<body>

    <ul class = "navBar">
        <!-- referenced to http://www.sitepoint.com/pure-css-off-screen-navigation-menu/-->
        <li id = "welcome"><p>LEGION<br> <span id = "chorus">Chorus</span></p></li>
        <li class = "nav-item"><a href = "#">//Home</a></li>
        <li class = "nav-item"><a href = "#">//About Us</a></li>
        <li class = "nav-item"><a href = "#">//Misc</a></li>
        <li class = "nav-item"><a href = "#">//Other</a></li>

<!--===========================================================================================================
    SIDEBAR
============================================================================================================-->
         
            <div id="sidebar">
                
                <div id="statusPanel">
                    <h3>Active Workers: <span id="activeWorkerNum">2</span></h3>
                    Worker Timeout: <span id="workerTimeoutNum">5</span> sec<br>
                    Chat Timeout: <span id="chatTimeoutNum">300</span> sec<br>
                    Agreement Threshold: <span id="agreementThresh">40</span>%
                </div>
                
                <div id="soundNoticeConf">
                    <h3>Sound Notification</h3>
                    <input type="radio" name="sound" value="none">Silent<br>
                    <input id="beep" type="radio" name="sound" value="beep">Beep<br>
                    <span id="tts"><input type="radio" name="sound" value="tts" checked="checked">TTS<br></span>
                </div>
                
                <div id="newMessageNoticeConf">
                    <h3>Visual Notification</h3>
                    <input type="radio" name="newChat" value="scroll" checked="checked">Always Scroll to the Bottom<br>
                    <input type="radio" name="newChat" value="notice">Notice Message<br>
                </div>
            
                

        
            </div>
    </ul>

    <input type="checkbox" id="nav-trigger" class="nav-trigger" />
    <label for="nav-trigger"></label>
  <div class = "site-wrap">

    <div id="main-interface">

        <div id="chat-done"></div>

        <div id="chat-accepted-container">
            <div id="chat-accepted">
                Chat Accepted!
            </div>
        </div>

<!--===========================================================================================================
    CHAT BOX
============================================================================================================-->
  
        <div id="outer-container">
            
            <div id="container">

                <div id="header">
                    <h1>
					<!--<img width="197" height="58" src="image/chorus.png" alt="Legion Buddy">
					<span style="position: absolute; left: -10000px;">LegionBuddy</span>-->
				</h1>
                    <div id="newMessages">
                        <span class="number"></span>New Message(s). Please click to check.
                    </div>
                </div>


                <div id="chat-container">
                    <h3 id = "mobile-title">LEGION: <span id = "chorus">Chorus</span>
                    </h3>
                    
                    <ul id="chat-area">

                        <!--
					messages: layout
					requester/crowd: role
					voted: clicked button
					confirmed/inplay: accepted (not button) / button 
					-->
					
					<!--  
                   <li status="1" rejected="0" chat_id="889" id="chat_889" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span>
                        <span class="role REQUEST">R</span>
                        <span class="messages requester">How are you?</span>
                    </li>
                                                                    
                    <li status="1" rejected="0" chat_id="890" id="chat_890" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span> 
                        <span class="role" id="crowd">C</span>
                        <span class="messages crowd">I'm fine. And you?</span>
                    </li>        



                    <li status="1" rejected="0" chat_id="891" id="chat_891" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span> 
                        <span class="role REQUEST">R</span>

                        <span class="messages requester">I'm ok.</span>


                    </li>

                    <li status="1" rejected="0" chat_id="892" id="chat_892" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span>
                        <span class="role REQUEST">R</span>

                         <span class="messages requester">What's the meaning of life?</span>
                     </li>



                    <li status="1" rejected="0" chat_id="893" id="chat_893" class=" confirmed">
                        <span class="role" id = "crowd">C</span>
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span>
                        <span class="messages crowd">Life is a gift that we wake up everyday.</span></li>


                    <li status="1" rejected="0" chat_id="894" id="chat_894" class="confirmed">
                        <span class="username">prr4v6sq687kpsk3rrvp80te02</span>
                        <span class="role REQUEST">R</span>

                        <span class="messages requester">Hi</span></li>


                    <li status="1" rejected="0" chat_id="895" id="chat_895" class="confirmed">
                        <span class="role" id = "crowd">C</span>
                        <span class="username">1</span>
                        <span class="messages crowd">Hello</span></li>

                    <li status="1" rejected="0" chat_id="896" id="chat_896" class="confirmed">
                        <span class="role" id = "crowd">C</span>
                        <span class="username">3</span>
                        <span class="messages crowd">Hi!!!</span></li>

                    <li status="1" rejected="0" chat_id="897" id="chat_897" class="confirmed">                        <span class="role" id = "crowd">C</span>
<span class="username">2</span>
<span class="messages crowd">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</span></li>

                    <li status="1" rejected="0" chat_id="898" id="chat_898" class="confirmed">                        <span class="role" id = "crowd">C</span>
<span class="username">1</span><span class="messages crowd">What?</span></li>

                    <li status="1" rejected="0" chat_id="900" id="chat_900" class="confirmed">
                    	<span class="role" id = "crowd">C</span>
						<span class="username">2c3vmd0ts000mumlpiesfcrjp1</span>
						<span class="messages crowd">oooooooooo</span>
					</li>
				-->
                                      
                    </ul>

<!--===========================================================================================================
USER INPUT
============================================================================================================-->

                    <div id="typing"></div>
                    
                    <div id="entry_wrapper">
                        <form>
                            <textarea id="txt" cols="30" rows="3" class="chat-box defaultText defaultTextActive" title="(read the chat history above before contributing - you are participating as the 'crowd' user)"></textarea>
                            <input type="button" class="submit-button" id="submit-chat" value="Send">
                        </form>

                    </div>
                    <div class = "mobileBar">
                        <div class = "mobileButton">Home</div>
                        <div class = "mobileButton">About Us</div>
                        <div class = "mobileButton">Misc</div>
                        <div class = "mobileButton">Other</div>

                    </div>


                </div>
            </div>


            
        </div>


		

        
    </div>

    </div>
</div>


<!-- Sound Manager Div -->
    <div id="sm2-container" class="movieContainer" style="z-index: 10000; position: absolute; width: 6px; height: 6px; top: -9999px; left: -9999px;">
        <embed name="sm2movie" id="sm2movie" src="sm2/soundmanager2.swf" quality="high" allowscriptaccess="always" bgcolor="#ffffff" pluginspage="www.macromedia.com/go/getflashplayer" title="JS/Flash audio component (SoundManager 2)" type="application/x-shockwave-flash" haspriority="true">
    </div>

    <!-- TTS Plugin -->
    <!--  
    <script type="text/javascript" src="https://rawgithub.com/hiddentao/google-tts/master/google-tts.min.js"></script>
	-->
	<script src="tts/requesterTTS.js" type="text/javascript"></script>

</body></html>