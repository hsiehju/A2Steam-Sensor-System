<?php
$username = "windeng";
$password = "W1nD3N60315!";
$hostname = "localhost";

$dbh = mysql_connect($hostname, $username, $password);

if(!$dbh) {
	echo "Connection Failed";
}
else {
	mysql_select_db("windeng", $dbh);
}
?>
