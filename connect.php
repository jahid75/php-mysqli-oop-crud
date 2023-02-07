<?php

$host = 'localhost';
$dbuser = 'root';
$dbpass = 'root';
$dbname = 'testdb';

$db = new mysqli($host, $dbuser, $dbpass, $dbname);


if($db->connect_error){
	die("Connection failed: " . $db->connect_error);
}