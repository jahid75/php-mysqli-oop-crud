<?php 

// If the form was submitted
$is_creating = isset($_POST['create_user']);
$has_error = false;

if($is_creating){
	$username = isset($_POST['username']) ? trim($_POST['username']) : '';
	$email = isset($_POST['email']) ? trim($_POST['email']) : '';
	$password = isset($_POST['password']) ? trim($_POST['password']) : '';

	if( !empty($username) && !empty($email) && !empty($password)){
		include_once('connect.php');

		$stmt = $db->prepare('INSERT INTO `users` (`username`, `email`, `password`) VALUES (?, ?, ?)');
		$stmt->bind_param('sss', $username, $email, $password);
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
	<title>Create a User</title>
</head>
<body>

	<h3>Create a new user</h3>
	<?php if($has_error) { ?>
		<p style="color: red;">Please check your inputs!</p>
	<?php } ?>
	<form action="http://localhost/test/db-crud/create.php" method="post">
		<input type="text" name="username" placeholder="username" required> 
		<input type="email" name="email" placeholder="email" required>
		<input type="password" name="password" placeholder="password" required>
		<input type="submit" value="Create user" name="create_user">
	</form>

</body>
</html>