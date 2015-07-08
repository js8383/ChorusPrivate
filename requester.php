<?php 
session_start();
if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}

// if($_GET['task'] != '') {
//     header("Location: home.php");
// }

?>

<!DOCTYPE html>

<!-- 
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
-->

<html>

<head>

	<meta http-equiv="content-type" content="text/html; charset=UTF-8">

	<title>Chorus</title>
	
	<!-- Icon -->
	<link rel="shortcut icon" href="image/favicon.ico">
	
	<!-- PHP Javascript Print -->
	<script type="text/javascript">
		var sessionId = "<?php echo session_id(); ?>";
        var taskId = "<?php echo $_SESSION['user']; ?>";
        var workerId = 0;
	</script>
    
    <!-- variables config -->
    <script src="js/_config.js" type="text/javascript"></script>
    
    <!-- External Lib -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
	
	<!-- Internal Lib -->
	<script src="js/lib/gup.js" type="text/javascript"></script>
    <script type="text/javascript" src="sm2/soundmanager2.js"></script>
    
    
    <!-- Chorus JS Class -->
    <script src="js/Class/MTurk.js" type="text/javascript"></script>
    <script src="js/Class/Chat.js" type="text/javascript"></script>
    <script src="js/Class/Chat.requester.js" type="text/javascript"></script>
    
	<!-- Page JS -->    
	<script src="js/requester.js" type="text/javascript"></script>

    
    
    <!--  
<script type="text/javascript">var sess_id = "c0rl1hmovalb738e05c0j5g8j6";
	var embed_video=true;
</script>
-->

    <!-- Libraries -->
    <!-- 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script><style type="text/css"></style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js"></script>
<script type="text/javascript" src="scripts/embed_fms.js"></script><style type="text/css" media="screen">#audioSWF {visibility:hidden}</style>
<script src="sm2/soundmanager2.js" type="text/javascript"></script>
<script src="scripts/gup.js" type="text/javascript"></script>
<script src="partP.js" type="text/javascript"></script>
<script src="partV.js" type="text/javascript"></script>
-->

    <!-- 
<script type="text/javascript">
var task = gup("task");
var part = gup("part"); // Current: should be 'm' for memory or 'c' for chat  #//should be 'p' for poster or 'v' for voter
var role = gup('role') ? gup('role') : '';
</script>
-->

    <!--
<script src="../retainer/scripts/getMoneyOwed.js" type="text/javascript"></script>
<script src="../../LegionTools/Retainer/scripts/getMoneyOwed.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="css/checkProgressBar.css">
-->

    <link rel="stylesheet" type="text/css" href="legion/legion.css">

    <!--
<script src="legion/legion.js" type="text/javascript"></script>
-->

    <!--
///Chorus/chorus/legion/legion.js 
<script src="../../LegionTools/Retainer/scripts/vars.js" type="text/javascript"></script>
<script src="../../LegionTools/Retainer/scripts/legion.js" type="text/javascript"></script>
-->

    <!-- 
/LegionTools/Retainer/scripts/legion.js
 -->
    <!-- For tooltips and instructions; If possible, insert before "chat.js"  -->
    <!--
<script type="text/javascript" src="scripts/jquery.balloon.min.js"></script>
<script type="text/javascript" src="scripts/instructionHelper.js"></script>
-->

    <!-- Chat Scripts -->
    <!--
<script src="scripts/chat2.js" type="text/javascript"></script>
-->

    <!-- Style 
/Chorus/chorus/tutorials/bigRetainer/css/bigRetainer.css
-->
    <link rel="stylesheet" type="text/css" href="css/chat.css">
    <link rel="stylesheet" type="text/css" href="css/requester.css">
    


</head>

<body>

    <div id="main-interface">

        <div id="chat-done"></div>

        <div id="chat-accepted-container">
            <div id="chat-accepted">
                Chat Accepted!
            </div>
        </div>

        <div id="outer-container">

            <div id="container">

                <div id="header">
                    <h1>
					<img width="197" height="58" src="image/chorus.png" alt="Legion Buddy">
					<span style="position: absolute; left: -10000px;">LegionBuddy</span>
				</h1>
                    <div id="newMessages">
                        <span class="number"></span>New Message(s). Please click to check.
                    </div>
                </div>


                <div id="chat-container">

                    <ul id="chat-area">

                        <!--
					messages: layout
					requester/crowd: role
					voted: clicked button
					confirmed/inplay: accepted (not button) / button 
					-->
					<!--  
                        <li votes="0" class="messages requester confirmed" chat_id="14073" id="chat_14073" status="1" rejected="0">
                            <span class="role">requester</span> 
                            <span class="username">ni7dkoc4o9j1ssce090j2ssc12</span>:
                            <span class="message">Hello</span>
                            <span class="visible">visible</span>
                            
                        </li>
                        <li votes="0" class="messages crowd inplay" chat_id="14073" id="chat_14073" status="0" rejected="0">
                            <span class="role">crowd</span>
                            <span class="username">ni7dkoc4o9j1ssce090j2ssc12</span>:
                            <span class="message">Hello</span>
                            <span class="visible">visible</span>
                           
                        </li>
                    
                    -->
                    
                    </ul>

                    <div id="typing"></div>

                    <div id="entry_wrapper">

                        <form>
                            <textarea id="txt" cols="30" rows="3" class="chat-box defaultText defaultTextActive" title="(read the chat history above before contributing - you are participating as the 'crowd' user)"></textarea>
                            <input type="button" class="submit-button" id="submit-chat" value="submit">
                        </form>

                    </div>

                </div>
            </div>

            <div id="sidebar">
				
				<div id='statusPanel'>
					<h3>Active Workers: <span id="activeWorkerNum">0</span></h3>
					Worker Timeout: <span id="workerTimeoutNum"></span> sec<br>
					Chat Timeout: <span id="chatTimeoutNum"></span> sec<br>
					Agreement Threshold: <span id="agreementThresh"></span>%
				</div>
				
            	<div id='soundNoticeConf'>
            		<h3>Sound Notification</h3>
            		<input type="radio" name="sound" value="none">Silent<br>
					<input id="beep" type="radio" name="sound" value="beep">Beep<br>
					<span id="tts"><input type="radio" name="sound" value="tts" checked="checked">TTS<br></span>
            	</div>
            	
            	<div id='newMessageNoticeConf'>
            		<h3>Visual Notification</h3>
            		<input type="radio" name="newChat" value="scroll" checked="checked">Always Scroll to the Bottom<br>
					<input type="radio" name="newChat" value="notice">Notice Message<br>
            	</div>

                <!-- add home button -->
                <div id='newMessageNoticeConf'>
                    <a class="Home" href="home.php">Home</a>
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
    
</body>

</html>
