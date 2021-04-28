<?php include('server.php'); ?>

<!doctype html>
<html>
<head>
	<title> Admin Home Page </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
	<h2>Admin Home</h2>
</div>
	<div class="content">
	<form method="post" action="admin_index.php">
		<input type="hidden" name="hidden_name">
		<?php if(isset($_SESSION['success'])): ?>
			<div class="error success">
				<h3>
					<?php
						echo $_SESSION['success'];
						unset ($_SESSION['success']);
					?>
				</h3>
			</div>
		<?php endif ?>
		<?php if(isset($_SESSION['username'])): ?>
			<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
			
		<?php endif ?>
		<button type="submit" name="act_log_admin" class="btn">Activity Log</button>
		<button type="submit" name="logoutb" class="btn">Logout</button>
	</form>
	</div>
	
</body>
</html>