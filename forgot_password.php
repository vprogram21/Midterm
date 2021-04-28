<?php include ('server.php'); ?>

<!doctype html>
<html>
<head>
	<title> Login Form </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
	<h2>Change Password</h2>
</div>
	<form method="post" action="forgot_password.php">
	<?php include('errors.php')?>
		<div class="input-group">
			<label>Username</label>
			<input type="text" name="forgot_username">
		</div>
		<div class="input-group">
			<label>Password</label>
			<input type="text" name="forgot_password">
		</div>
		<div class="input-group">
			<label>New Password</label>
			<input type="text" name="new_password">
		</div>
		<div class="input-group">
			<button type="submit" name="changepass" class="btn">Change Password</button>
		</div>
		<p>
			<a href="login.php">Return</a><br>
		</p>
	
</form>
</body>
</html>