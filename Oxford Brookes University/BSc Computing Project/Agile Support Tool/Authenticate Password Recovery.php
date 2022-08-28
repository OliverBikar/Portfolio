<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$error = "";
	$mismatch = "";
	$status = "";

	if(isset($_POST['submit'])) {
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$query = "select * from account where email_address = '".$email."'";
		$result = mysqli_query($conn,$query);
		
		if(filter_var($email)) {
			if(mysqli_num_rows($result) > 0) {
				$row = mysqli_fetch_array($result);
				$user_id = $row['id'];
				$forename = $row['forename'];
				$surname = $row['surname'];
				$user_email = $row['email_address'];
				$token = uniqid(md5(time()));
				$query = "insert into password_reset(id,email_address,token) values ('".$user_id."','".$user_email."','".$token."')";
				
				if(mysqli_query($conn,$query)) {
					$to = $email;
					$subject = "Reset Password";
					$message = "Dear ".$forename." ".$surname."";
					$message .= "<p>We received a request to reset your password. To proceed, click the button below:</p>";
					$message .= "<a href='http://localhost/Agile%20Support%20Tool/Reset%20Password%20Page.php?token=".$token."' target='_blank'><button>Reset Password</button></a>";
					$message .= "<p>If you did not make this request, please ignore this email</p>";
					$message .= "<p>Thanks</p>";
					$message .= "<p>Agile Support Tool Team</p>";
					
					$header = "MIME-Version: 1.0"."\r\n";
					$header .= "Content-type:text/html; charset=UTF-8"."\r\n";
					$header .= "From: <olibikar@gmail.com>"."\r\n";
					
					mail($to, $subject, $message, $header);
					
					$status = "Check your email";
				}
			}
			
			else {
				$mismatch = "This user does not exist";
			}
		}
		
		else if(!filter_var($email)) {
			$error = "Please enter a valid email address";
		}
	}
?>