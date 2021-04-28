<?php
	include('server.php');
?>

<!doctype html>
<html>
<head>
	<title> Registration Form </title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<div class="header">
	<h2>Authentication</h2>
</div>
	<form method="post" action="authenticator.php">
	<?php include('errors.php')?>
		<?php
			$username = "";
			$etime = "";
			$stime = "";
			$otp = "";

			$errors = array();
			$db = mysqli_connect('localhost','root','','registration');

			$seed = floor(time()/(60*5));
			srand($seed);

			$otp = rand(100000,999999);
			echo $otp;

			echo "----";
			$etime = date("H:i:s", strtotime("+5 min"));
			$stime = date("H:i:s");

			
			$sql1 = "INSERT INTO authentication(Code,Created,Expired) values('$otp','$stime','$etime')";
			mysqli_query($db, $sql1);

			if (isset($_POST['tokenb'])){
				$token = $otp;
				if(($_POST['otp'])==$token){

					$_SESSION['username'] = $username;
					$_SESSION['success'] = "You are now logged in!";
					header('location: index.php');
				}
				else{		
					array_push($errors, "Invalid!");
					header('location: login.php');
					session_destroy();
				}
			}
		?>

		<br><br>
		<label>Authenticator</label>
		<input type="text" name="otp">
		<button type="submit" name="tokenb" class="btn">Submit</button>
	</form>
</body>
</html>