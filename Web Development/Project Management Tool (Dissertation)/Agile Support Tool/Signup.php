<?php
	include('Register.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Signup Page</title>
		<link rel="shortcut icon" type="image/png" href="Logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="appStyle.php">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
		crossorigin="anonymous"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
	</head>
	<body>
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<a class="navbar-brand" href="Index.php"><img src="Logo.png" id="logo" alt="logo"></a>
			</div>
			<div class="dropdown">
				<a class="text-white" href="Signup.php">Signup</a>
				<button class="btn text-light btn" type="button" data-toggle="dropdown">
					Login
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="Student Login Page.php">Student</a></li>
					<li><a href="Staff Login Page.php">Staff</a></li>
				</ul>
			</div>
		</nav>
		
		<div id="signupform">
			<form name="signup" action="" autocomplete="off" method="POST" onsubmit="return validate_signup();">
				<p class="error"><?php echo $email_error;?></p>
				<p class="error"><?php echo $user_error;?></p>
				<p class="error"><?php echo $password_error;?></p>
				<div class="form-group">
					<label>Forename</label>
					<input class="form-control" type="text" name="forename">
				</div>
				<div class="form-group">
					<label>Surname</label>
					<input class="form-control" type="text" name="surname">
				</div>
				<div class="form-group">
					<label>Email Address</label>
					<input class="form-control" type="text" name="email">
				</div>
				<div class="form-group">
					<label>User Type</label>
					<select name="user" class="form-control">
						<option value="none" selected disabled hidden>Select User Type</option>
						<option value="staff">Staff</option>
						<option value="student">Student</option>
					</select>
				</div>
				<div class="form-group">
					<label>Password</label>
					<input class="form-control" type="password" name="password_one">
				</div>
				<div class="form-group">
					<label>Confirm Password</label>
					<input class="form-control" type="password" name="password_two">
				</div>
				<p>
					<button type="submit" id="button" name="submit" value="Login">Register</button>
				</p>
			</form>
			<script>
				function validate_signup() {
					valid = true;
					
					if(document.signup.forename.value == "" || 
					   document.signup.surname.value == "" || 
					   document.signup.email.value == "" ||
					   document.signup.password_one.value == "" ||
					   document.signup.password_two.value == "" ||
					   document.signup.user.value == "none") {
						alert("Input for all fields are required");
						return false;
					}
				}
			</script>
		</div>
		
	</body>
</html>