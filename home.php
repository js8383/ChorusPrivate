<?php
session_start();

include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
    header("Location: index.php");
}
$res=mysql_query("SELECT * FROM users WHERE user_id=".$_SESSION['user']);
$userRow=mysql_fetch_array($res);
?>

<!DOCTYPE html >
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
    <!-- <link rel="stylesheet" href="style.css" type="text/css" /> -->

    <link rel="stylesheet" href="css/home.css">

    <link href='http://fonts.googleapis.com/css?family=Quicksand:400,700' rel='stylesheet' type='text/css' />

    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome.min.css" rel="stylesheet" />

    <script type="text/javascript" src="http://code.jquery.com/jquery-2.0.0.min.js" /></script>
    <!--[if IE 7]>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/3.1.1/css/font-awesome-ie7.min.css" rel="stylesheet" />
    <![endif]-->

</head>

<body>

    <h1>Welcome- <?php echo $userRow['email']; ?></h1>        

    <ul class="form">
        <li><a class="ask" href="requester.php"><i class="icon-question"></i>Ask Question</a></li>
        <li><a class="answer" href="chat.php"><i class="icon-user"></i>Answer Question <!-- <em>5</em> --></a></li>
        <li><a class="settings" href="#"><i class="icon-cog"></i>Settings</a></li>
        <li><a class="logout" href="logout.php?logout"><i class="icon-signout"></i>Logout</a></li>
    </ul>


</body>
</html>