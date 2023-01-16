<?php
$host="localhost";
$port=3305;
$socket="";
$user="root";
$password="";
$dbname="sicontrar";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();
?>