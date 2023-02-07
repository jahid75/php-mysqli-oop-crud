<?php 

// If the form was submitted
$is_creating = isset($_POST['create_user']);
$has_error = false;
$user_id = isset($_REQUEST['user']) ? trim($_REQUEST['user']) : '';

if( empty($user_id) ){
	header('Location: http://localhost/test/db-crud/read.php');
	die();
}
include_once('connect.php');

$user = $db->prepare('SELECT * FROM `users` WHERE `id`=?');
$user->bind_param('i', $user_id);
$user->execute();
$result = $user->get_result();

if(!$result->num_rows){
	// Redirect to main page
	header('Location: http://localhost/test/db-crud/read.php');
	die();
}
$u = $result->fetch_object();

if($is_creating){
	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$password = isset($_POST['password']) ? trim($_POST['password']) : '';

	if( !empty($user_id) && !empty($username) && !empty($email) && !empty($password)){
	
		$stmt = $db->prepare('UPDATE `users` SET `username` = ?, `email` = ?, `password` = ? WHERE `id` = ?');
		$stmt->bind_param('sssi', $username, $email, $password, $user_id);
		$stmt->execute();
		
		header('Location: http://localhost/test/db-crud/read.php');
		die();
	} else {
		$has_error = true;
	}

}



?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Update a User</title>
</head>
<body>

	<h3>Update user</h3>
	<?php if($has_error) { ?>
		<p style="color: red;">Please check your inputs!</p>
	<?php } ?>
	<form action="http://localhost/test/db-crud/update.php" method="post">
		<input type="hidden" name="user" value="<?= $u->id ?>">
		<input type="text" name="username" placeholder="username" required value="<?= $u->username ?>"> 
		<input type="email" name="email" placeholder="email" required value="<?= $u->email ?>">
		<input type="password" name="password" placeholder="password" required value="<?= $u->password ?>">
		<input type="submit" value="Update user" name="create_user">
	</form>

</body>
</html>