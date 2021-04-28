<?php
	include('server.php');
?>

<!doctype html>
<html>
<head>
	<title> Activity Log </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
	<h2>Activity Log</h2>
</div>
	<form method="post" action="admin_log.php">
	<input type="hidden" name="hidden_name">
	<?php include('errors.php')?>
		<?php
		ob_start();
			$last = $_SESSION['hidden_name'];
			$time = "";
			$activity = "";

			$errors = array();
			$db = mysqli_connect('localhost','root','','registration');
			$time = date("H:i:s");

			$result = mysqli_query($db,"SELECT * FROM activity_log");

			echo '<table border="2">
					<tr>
						<th>
							Log ID
						</th>
						<th>
							Username
						</th>
						<th>
							Activity Log
						</th>
						<th>
							Time
						</th>
					</tr>';

					while($row = mysqli_fetch_array($result)){
						echo '<tr>
							<td>'.$row['id'].'</td>
							<td>'.$row['username'].'</td>
							<td>'.$row['activity'].'</td>
							<td>'.$row['time_log'].'</td>
						</tr>';
					}

					echo '</table>';

						mysqli_close($db);



			if (isset($_POST['returnc'])){		
				header('location: admin_index.php');
			}
			ob_end_flush();
		?>

		<br><br>
		<button type="submit" name="returnc" class="btn">Return</button>
	</form>
</body>
</html>