<?php
	include("Update Password.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Reset Password Page</title>
		<link rel="stylesheet" type="text/css" href="appStyle.php">
	</head>
	<body>		
		<div id="form">
			<form name="reset" action="" autocomplete="off" method="POST" onsubmit="return validate_reset();">
				<p class="error"><?php echo $error; ?></p>
				<p>
					<label>Password</label>
					<input type="password" id="pass" name="password_one">
				</p>
				<p>
					<label>Confirm Password</label>
					<input type="password" id="pass" name="password_two">
				</p>
				<p>
					<button type="submit" align="center" id="button" name="submit" value="Submit">Submit</button>
				</p>
			</form>
		</div>
		<script>
			function validate_reset() {
				valid = true;
				
				if(document.reset.email.value == "" ||
				   document.reset.password_one == "" ||
				   document.reset.password_two == "") {
					alert("Input for all fields are required");
					return false;
				}
			}
		</script>
	</body>
</html>