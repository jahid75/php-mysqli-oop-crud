<?php 

// If the form was submitted
$user_id = isset($_REQUEST['user']) ? trim($_REQUEST['user']) : '';

if( empty($user_id) ){
	header('Location: http://localhost/test/db-crud/read.php');
	die();
}
include_once('connect.php');

$user = $db->prepare('DELETE FROM `users` WHERE `id`=?');
$user->bind_param('i', $user_id);
$user->execute();

// Redirect to main page
header('Location: http://localhost/test/db-crud/read.php');
die();
