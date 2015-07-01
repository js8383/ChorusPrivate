<?php session_start();?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">

<html>

<head>
	
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	
	<title>Chorus</title>
	
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
    <script src="js/Class/Vote.js" type="text/javascript"></script>
    <script src="js/Class/Chat.js" type="text/javascript"></script>
    <script src="js/Class/Chat.crowd.js" type="text/javascript"></script>
    <script src="js/Class/Memory.js" type="text/javascript"></script>
    
	<!-- Page JS -->    
	<script src="js/chatCrowd.js" type="text/javascript"></script>
    
    
    
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

                    <div id="participation">
                        <strong>Messages Left:</strong>
                        <span id="votes-allowed">0</span>
                        <!-- 
                        <img class="icons msgNotice" src="image/icon.gif" title="message" style="display: inline;">
                        <img class="icons msgNotice" src="image/icon.gif" title="message" style="display: inline;">
                        <img class="icons msgNotice" src="image/icon.gif" title="message" style="display: inline;">
                         -->
                    </div>

                    <div id="chat-alert" style="display: none;">
                        Wait for your current posts to expire or the requester to post, before you can participate again.
                    </div>

                </div>
            </div>

            <div id="sidebar">

                <div id="legion-score">
                    <span id="legion-instructions-top" class="legion-instructions">
					You have earned ~$
					<span id="legion-money">0.00</span>
                    </span>
                    <br />
                    <span class="legion-points" id="legion-points">
					--
				</span>
                    <br />
                    <span id="legion-instructions-bottom" class="legion-instructions">
					(depending on quality check)
				</span>
                </div>

                <div id="chat-highlights">

                    <h2>Important Facts</h2>

                     
				<span id="highlight-instructions">
					Click the facts
					that are important to remember,
					or contribute your own.
				</span>
				

                    <div class="container">
						
						
						
                        <ul id="highlight-list">
                        
                        	<!-- 
                            <li memory_id="1" id="4_highlight" score="1" class="odd-chat-highlight" style="display: block;">
                                
                                <div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar memoryImportant"></i>
									
								</div>
                                It's located in Pittsburgh, PA
                            </li>
                            
                            <li memory_id="-1" id="3_highlight" score="1" style="display: block;">
								
								
								<div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar memoryImportant"></i>
									
								</div>
								
								Allergy to sea food
							</li>
							
							<li memory_id="6" id="4_highlight" score="1" class="odd-chat-highlight" style="display: block;">
                                <div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar"></i>
									
								</div>
                                Oops
                            </li>
                            
                            <li memory_id="2" id="3_highlight" score="1" style="display: block;">
								
								<div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar"></i>
									
								</div>
								ok
							</li>
							
							<li memory_id="0" id="4_highlight" score="1" class="odd-chat-highlight" style="display: block;">
                                <div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar"></i>
									
								</div>
                                Test test test
                            </li>
                            
                            <li memory_id="5" id="3_highlight" score="1" style="display: block;">
								<div class="plus-minus-buttons">
									<i class="fa fa-star memoryStar"></i>
									
								</div>
								I'm happy working with you!
							</li>
							
							-->
							
							
                        </ul>

                        <textarea id="memoryType" class="defaultText defaultTextActive" title="(e.g., located in austin, texas)" cols="10" rows="2"></textarea>
                        <!-- 
                        <div id="tbox-alert" style="display: none;">
                            You can now contribute your own "important facts" when appropriate!
                        </div>
                        -->
                        
                    </div>
                </div>
            </div>

            <div id="legion-submit-div">
                <div id="legion-submit-instructions">
                    <p>
                        The requester doesn't type anything for more than 15 minutes, so this HIT is considered as finished now.
                        <br> Please hit the submit button below.
                    </p>
                    <p>If you encounter problems submitting, please contact the requester.</p>
                </div>
                <div>
                </div>

                <form id="legion-submit-form">
                    <input type="hidden" name="money" value="0" id="legion-money-field">
                    <input type="hidden" name="assignmentId" id="legion-assignmentId">
                    <input id="legion-submit" type="button" value="Submit HIT" disabled="disabled">
                </form>

            </div>

        </div>



        <div id="instructions" style="display: none;">
            <h3>Instructions:</h3>
            <ol>
                <li><strong>You will receive rewards for all activities only if they help the requester.</strong> The biggest rewards are given when other workers agree with your helpful input!</li>
                <li>Please <strong>do not vote for messages that do not help the requester</strong>; you will be penalized for doing so.</li>
                <li><span style="background-color:yellow"><strong>Messages in 'Important Facts' and those highlighted in pink CANNOT be seen by the requester!</strong></span>
                </li>
                <li><span style="background-color:yellow"><strong>Vote on messages that should be seen by the requester by clicking them.</strong></span>
                </li>
                <li>If you agree with an 'Important Fact', vote for it by pressing the "+" button, otherwise press the "-" button.</li>
                <li>Your current pre-quality check reward amount will appear in the score box above 'Important Facts' and will be paid to you via bonus within one hour of completing the chat (subject to a quality check). </li>
            </ol>
            <p>Thank You!</p>
        </div>
    </div>

    <!-- Sound Manager Div -->
    <div id="sm2-container" class="movieContainer " style="z-index: 10000; position: absolute; width: 6px; height: 6px; top: -9999px; left: -9999px;">
        <embed name="sm2movie" id="sm2movie" src="sm2/soundmanager2.swf" quality="high" allowscriptaccess="always" bgcolor="#ffffff" pluginspage="www.macromedia.com/go/getflashplayer" title="JS/Flash audio component (SoundManager 2)" type="application/x-shockwave-flash" haspriority="true">
    </div>

</body>

</html>
