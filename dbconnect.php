<?php
if(!mysql_connect("localhost","root","js8383"))
{
	die('oops connection problem ! --> '.mysql_error());
}
if(!mysql_select_db("dbtest"))
{
	die('oops database selection problem ! --> '.mysql_error());
}

?>