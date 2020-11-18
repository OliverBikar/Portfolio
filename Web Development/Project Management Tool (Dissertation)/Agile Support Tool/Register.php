<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$email_error = "";
	$password_error = "";
	$user_error = "";
	if(isset($_POST['submit'])) {
		$forename = mysqli_real_escape_string($conn,$_POST['forename']);
		$surname = mysqli_real_escape_string($conn,$_POST['surname']);
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$user = mysqli_real_escape_string($conn,$_POST['user']);
		$password = mysqli_real_escape_string($conn,$_POST['password_one']);
		$confirmPassword = mysqli_real_escape_string($conn,$_POST['password_two']);
		
		$email_query = "select * from account where email_address = '".$email."'";
		$email_result = mysqli_query($conn,$email_query);
		
		if(mysqli_num_rows($email_result) > 0) {
			$email_error = "Email address is already used";
		}
		
		else {
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
				if($password == $confirmPassword) {
					$insert = "insert into account(forename,surname,email_address,account_password,user_type) 
							   values('".str_replace(' ', '',ucwords(strtolower($forename)))."',
							   '".str_replace(' ', '', ucwords(strtolower($surname)))."',
							   '".$email."','".md5($password)."','".ucwords(strtolower($user))."')";
							   
					if($user == "staff") {
						if(mysqli_query($conn,$insert)) {
							$staff_id = mysqli_insert_id($conn);
							header("location: Staff Confirmation.php?id=".$staff_id."");
						}
					}
					
					else if($user == "student") {
						if(mysqli_query($conn,$insert)) {
							$student_id = mysqli_insert_id($conn);
							header("location: Student Confirmation.php?id=".$student_id."");
						}
					}
				}
				
				else {
					$password_error = "Password has been entered incorrectly";
				}
			}
			
			else {
				$email_error = "Please enter a valid email address";
			}
		}
		
		$conn->close();
	}
?>