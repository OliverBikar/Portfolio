<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$error = "";
	
	if($_GET['token']) {
		$token = mysqli_real_escape_string($conn,$_GET['token']);
		$query = "select * from password_reset where token = '".$token."'";
		$result = mysqli_query($conn,$query);
		
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$token = $row['token'];
			$email = $row['email_address'];
		}
		else {
			header("location: Index.php");
		}
	}
	
	if(isset($_POST['submit'])) {
		$password_one = mysqli_real_escape_string($conn,$_POST['password_one']);
		$password_two = mysqli_real_escape_string($conn,$_POST['password_two']);
		
		if($password_one == $password_two) {
			$update = "update account set account_password = '".md5($password_one)."' where email_address = '".$email."'";
			mysqli_query($conn,$update);
			$delete = "delete from password_reset where email_address = '".$email."'";
			mysqli_query($conn,$delete);
			header("location: Password Reset Confirmation.php");
		}
		
		else {
			$error = "Password has been entered incorrectly";
		}
	}
?>