<!DOCTYPE html>
<html>
	<head>
		<title>Homepage</title>
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
	</body>
</html>