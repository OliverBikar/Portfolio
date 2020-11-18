<?php
	session_start();
	$error = '';
	
	if(isset($_POST['submit'])) {
		if(empty($_POST['username']) || empty($_POST['password'])) {
			$error = "Invalid login credentials";
		}
		else {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			
			$conn = mysqli_connect("localhost","root","","agile support tool");
			$query = "select id, account_password from account where id = ? and account_password = ? and user_type='Staff'";
			
			$stmt = $conn->prepare($query);
			$stmt->bind_param("ss",$username,$password);
			$stmt->execute();
			$stmt->bind_result($username,$password);
			$stmt->store_result();
			if($stmt->fetch()) {
				$_SESSION['login_user'] = $username;
				header("location: Staff Dashboard.php");
			}
			else {
				$error = "Invalid login credentials";
			}
			mysqli_close($conn);
		}
	}
?>