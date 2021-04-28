<?php
	session_start();
	$username2 = "";
	$username1 = "";
	$errors = array();

	$db = mysqli_connect('localhost','root','','registration');
	
	if (isset($_POST['register'])){
		$username = mysqli_real_escape_string($db,$_POST['username']);
		$email = mysqli_real_escape_string($db,$_POST['email']);
		$password1 = mysqli_real_escape_string($db,$_POST['password1']);
		$password2 = mysqli_real_escape_string($db,$_POST['password2']);
		$time = date("H:i:s");

		if(empty($username)){
			array_push($errors, "Username is empty!");
		}
		if(empty($email)){
			array_push($errors, "Email is empty!");
		}
		if(empty($password1)){
			array_push($errors, "Password is empty!");
		}
		if($password1 != $password2){
			array_push($errors, "Password doesn't match!");
		}
		if(count($errors) == 0){
			if(strlen($_POST['password1']) < 8){
			array_push($errors, "Password must be 8 character or above.");
			}
			if(!preg_match("#[0-9]+#",$password1)){
				array_push($errors, "Password must contain atleast 1 number.");
			}
			if(!preg_match("#[A-Z]+#",$password1)){
				array_push($errors, "Password must contain atleast 1 uppercase letter.");
			}
			if(!preg_match("#[a-z]+#",$password1)){
				array_push($errors, "Password must contain atleast 1 lowercase letter.");
			}
			if(!preg_match("#[\W]+#",$password1)){
				array_push($errors, "Password must contain atleast 1 special character.");
			}
			else{
				$sql = "INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password1')";
				mysqli_query($db, $sql);
				mysqli_query($db,"INSERT INTO activity_log (activity,username,time_log) VALUES('Created an account','$username','$time')");
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in!";
				header('location: index.php');
			}
		}
	}
		if(isset($db,$_POST['login'])){

			$username2 = mysqli_real_escape_string($db,$_POST['username']);
			$password = mysqli_real_escape_string($db,$_POST['password1']);
			$time = date("H:i:s");

			if(empty($username2)){
				array_push($errors, "Username required!");
			}
			if(empty($password)){
				array_push($errors, "Password required!");
			}
			if(count($errors) == 0) {
				$query = "SELECT * FROM users WHERE username='$username2' AND password='$password'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) == 1){
					mysqli_query($db,"INSERT INTO activity_log (activity,username,time_log) VALUES('Logged in','$username2','$time')");
					$_SESSION['hidden_name'] = $username2;
					$_SESSION['success'] = "You are now logged in!";
					header('location: authenticator.php');
				}
				if($username2=="ADMIN" &&  $password=="ADMIN"){
					mysqli_query($db,"INSERT INTO activity_log (activity,username,time_log) VALUES('Logged in','$username2','$time')");
					$_SESSION['hidden_name'] = $username2;
					$_SESSION['success'] = "Logged in as ADMIN";
					header('location: admin_authenticator.php');
				}
				else{
					array_push($errors, "The username/password is incorrect");
				}
		}
	}

	if (isset($_POST['act_log'])){		
		$username = $_SESSION['hidden_name'];
		header('location: activity_log.php');	
	}
	if (isset($_POST['act_log_admin'])){		
		$username = $_SESSION['hidden_name'];
		header('location: admin_log.php');	
	}

	if (isset($_POST['logout'])){
		$username = $_SESSION['hidden_name'];
		echo $username;
		$time = date("H:i:s");
		mysqli_query($db,"INSERT INTO activity_log (activity,username,time_log) VALUES('Logged out','$username','$time')");
		header('location: login.php');
		
	}
	
	if (isset($_POST['logoutb'])){
		$username = $_SESSION['hidden_name'];
		echo $username;
		$time = date("H:i:s");
		mysqli_query($db,"INSERT INTO activity_log (activity,username,time_log) VALUES('Logged out','$username','$time')");
		header('location: login.php');
		
	}

	if(isset($_POST['changepass'])){
		$username1 = mysqli_real_escape_string($db,$_POST['forgot_username']);
		$forgot_pass = mysqli_real_escape_string($db,$_POST['forgot_password']);
		$new_pass = mysqli_real_escape_string($db,$_POST['new_password']);
		if(count($errors) == 0){
			if(strlen($_POST['new_password']) < 8){
			array_push($errors, "Password must be 8 character or above.");
			}
			if(!preg_match("#[0-9]+#",$new_pass)){
				array_push($errors, "Password must contain atleast 1 number.");
			}
			if(!preg_match("#[A-Z]+#",$new_pass)){
				array_push($errors, "Password must contain atleast 1 uppercase letter.");
			}
			if(!preg_match("#[a-z]+#",$new_pass)){
				array_push($errors, "Password must contain atleast 1 lowercase letter.");
			}
			if(!preg_match("#[\W]+#",$new_pass)){
				array_push($errors, "Password must contain atleast 1 special character.");
			}
			else{
				$result = mysqli_query($db,"SELECT * FROM users WHERE username='".$username1."'");
				$row = mysqli_fetch_array($result);
				$time = date("H:i:s");
				echo $time;
				if($forgot_pass == $row["password"]){
					mysqli_query($db,"UPDATE users set password='$new_pass' WHERE username='$username1'");
					mysqli_query($db,"INSERT INTO activity_log (activity,username,time_log) VALUES('Changed Password','$username1','$time')");
					header('location: login.php');
				}
				else{
					array_push($errors, "The password is incorrect");
				}
			}
		}
	}
		
?>