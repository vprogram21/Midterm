<?php
	session_start();

	$username = "";
	$email = "";
	$errors = array();

	$db = mysqli_connect('localhost','root','','registration');
	
	if (isset($_POST['register'])){
		$username = mysqli_real_escape_string($db,$_POST['username']);
		$email = mysqli_real_escape_string($db,$_POST['email']);
		$password1 = mysqli_real_escape_string($db,$_POST['password1']);
		$password2 = mysqli_real_escape_string($db,$_POST['password2']);

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
				$password1 = md5($password2);
				$sql = "INSERT INTO users(username, email, password) VALUES('$username', '$email', '$password1')";
				mysqli_query($db, $sql);
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in!";
				header('location: index.php');
			}
		}
	}
		if(isset($db,$_POST['login'])){
			$username = mysqli_real_escape_string($db,$_POST['username']);
			$password = mysqli_real_escape_string($db,$_POST['password1']);

			if(empty($username)){
				array_push($errors, "Username required!");
			}
			if(empty($password)){
				array_push($errors, "Password required!");
			}
			if(count($errors) == 0) {
				$password = md5($password);
				$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
				$result = mysqli_query($db, $query);
				if(mysqli_num_rows($result) == 1){
					header('location: authenticator.php');
				}
				else{
					array_push($errors, "The username/password is incorrect");
				}
		}
	}

	if (isset($_POST['tokenb'])){
		$token2 = $_POST['$token'];
		if(($_POST['token'])==$token2){
			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in!";
			header('location: index.php');
		}
		else if(($_POST['token'])==""){		
			array_push($errors, "Cannot be blank!");
		}
		else{

		}
	}


	if(isset($_GET['logout'])){
		session_destroy();
		unset($_SESSION['username']);
		header('location: login.php');
	}
		
?>