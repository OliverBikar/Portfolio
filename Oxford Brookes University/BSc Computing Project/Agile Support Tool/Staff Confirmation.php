<!DOCTYPE html>
<html>
	<head>
		<title>Staff Confirmation Page</title>
		<link rel="stylesheet" type="text/css" href="appStyle.php">
	</head>
	<body>		
		<div id="signupform">
			<form>
				<?php
					$conn = new mysqli('localhost','root','','agile support tool');
					$id = $_GET['id'];
					$query = "select * from account where id = '".$id."'";
					$result = mysqli_query($conn,$query);
					if($result->num_rows > 0){
						while($row = $result->fetch_assoc()) {
							echo "<p>Welcome"." ".$row['forename']." ".$row['surname']."."." "."Your account is created</p>";
							echo "<p>Your ID is:"." ".$row['id']."</p>";
							echo "<p>You will need this to sign into your account</p>";
						}
					}
				?>
				<p>
					<input type="button" value="Proceed" onclick="document.location='Staff Login Page.php'">
				</p>
			</form>
		</div>
		
	</body>
</html>