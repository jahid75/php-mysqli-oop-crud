<?php

include_once('connect.php');

$query = 'SELECT * FROM `users`';
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

if( !empty($search) ){
	$query = $db->prepare('SELECT * FROM `users` WHERE username=?');
	$query->bind_param('s', $search);
	$query->execute();
	$users = $query->get_result();
} else {
	$users = $db->query($query);
}

printf("Total %d users found!\n", $users->num_rows);
?>
<form action="http://localhost/test/db-crud/read.php" method="get">
	<input type="text" name="search" value="<?= @$_GET['search'] ?>" placeholder="Search...">
	<input type="submit" value="Search">
	
</form>

<a href="http://localhost/test/db-crud/create.php">Create a User</a>

<table border="1" style="border-collapse: collapse;">
	<thead>
		<tr>
			<td>ID</td>
			<td>Username</td>
			<td>Email</td>
			<td>Password</td>
			<td>Edit</td>
			<td>Delete</td>
		</tr>
	</thead>
	<tbody>
	<?php

	if( $users ){
		while ($u = $users->fetch_object()) {
			?>
			<tr>
				<td><?php echo $u->id ?></td>
				<td><?php echo $u->username ?></td>
				<td><?php echo $u->email ?></td>
				<td><?php echo $u->password ?></td>
				<td><a href="http://localhost/test/db-crud/update.php?user=<?php echo $u->id ?>">Edit</a></td>
				<td><a style="color: red; " href="http://localhost/test/db-crud/delete.php?user=<?php echo $u->id ?>">Delete</a></td>
			</tr>
			<?php
		}
	}
	?>
	</tbody>
</table>
<?php

$db->close();
