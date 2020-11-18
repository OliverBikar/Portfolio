<?php
	include('Student Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_REQUEST['project_id'];
	$query = "select * from project where project_id='".$id."'"; 
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit Project</title>
		<link rel="shortcut icon" type="image/png" href="Logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="appStyle.php">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
		crossorigin="anonymous"></script>
	</head>
	<body>
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="Student Dashboard.php">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Project Page.php">Project</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Team Page.php">Team</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Product Backlog Page.php">Product Backlog</a>
					</li>
				</ul>
			</div>
			
			<div class="dropdown">
				<button class="btn text-light" type="button" data-toggle="dropdown">
					<i class="fa fa-user-circle-o"></i>
					<?php
						$conn = new mysqli('localhost','root','','agile support tool');
						
						$nameQuery = "select forename, surname from account where id=".$_SESSION['login_user'];
						$nameResult = $conn->query($nameQuery);

						if ($nameResult->num_rows > 0) {
							while($nameRow = $nameResult->fetch_assoc()) {
								echo $nameRow['forename']." ".$nameRow['surname'];
							}
						}
						$conn->close();
					?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<li><a href="Student Logout.php">Logout</a></li>
				</ul>
			</div>
		</nav>

		<div id="main">
			<div>
				<?php
					$conn = new mysqli('localhost','root','','agile support tool');
					if(isset($_POST['new']) && $_POST['new']==1) {
						$id = $_GET['project_id'];
						$project = $_POST['project'];
						$description = $_POST['description'];
						$start = $_POST['start'];
						$deadline = $_POST['deadline'];
						
						if(mysqli_query($conn,"update project set project_name='".$project."',project_description='".$description."',project_start_date='".$start."',project_deadline='".$deadline."' where project_id='".$id."'")) {
							header("location: Project Page.php");
						}
					}else {
				?>
				<div>
					<form id="editProjectForm" action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
						<input type="hidden" name="new" value="1">
						<div class="form-group">
							<label>Project Title</label>
							<input class="form-control" type="text" name="project" value="<?php echo $row['project_name'];?>" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Description</label>
							<input class="form-control" type="text" name="description" value="<?php echo $row['project_description'];?>" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Start Date</label>
							<input type="date" name="start" value="<?php echo $row['project_start_date'];?>" class="form-control" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Deadline</label>
							<input type="date" name="deadline" value="<?php echo $row['project_deadline'];?>" class="form-control" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit" name="update" value="append">Update</button>
						</div>
					</form>
					<script>
						(function() {
							'use strict';
							window.addEventListener('load', function() {
								var forms = document.getElementsByClassName('needs-validation');
								var validation = Array.prototype.filter.call(forms, function(form) {
									form.addEventListener('submit', function(event) {
										if (form.checkValidity() === false) {
											event.preventDefault();
											event.stopPropagation();
										}
										form.classList.add('was-validated');
									}, false);
								});
							}, false);
						})();
					</script>
					<?php }?>
				</div>
			</div>
		</div>
	</body>
</html>