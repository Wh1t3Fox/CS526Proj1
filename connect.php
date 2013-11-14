<?php
if($_SERVER["HTTPS"] != "on")
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}
	ini_set('session.cookie_secure',1);
	ini_set('session.cookie_httponly',1);
	ini_set('session.use_only_cookies',1);
	session_start();
	// Connects to the Database 
	$mysqli = new mysqli("localhost", "cs526f13", "Th1sN*T9asS", "cs526p1", 65536);
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
?>