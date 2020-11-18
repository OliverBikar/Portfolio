<?php
	include('Student Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_REQUEST['user_st_id'];
	$query = "select * from user_story where user_st_id='".$id."'"; 
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit User Story</title>
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
						$id = $_GET['user_st_id'];
						$user = $_POST['user'];
						$goal = $_POST['goal'];
						$reason = $_POST['reason'];
						$project = $_POST['project'];
						$sprint = $_POST['sprint'];
						$priority = $_POST['priority'];
						
						if(mysqli_query($conn,"update user_story set user='".$user."',goal='".$goal."',reason='".$reason."',project_id='".$project."',sprint_id='".$sprint."',priority='".$priority."' where user_st_id='".$id."'")) {
							header("location: Product Backlog Page.php");
						}
					}else {
				?>
				<div>
					<form id="editUserStoryForm" action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
						<input type="hidden" name="new" value="1">
						<div class="form-group">
							<label>As a</label>
							<input type="text" name="user" value="<?php echo $row['user'];?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>I want to</label>
							<input type="text" name="goal" value="<?php echo $row['goal'];?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>So that</label>
							<input type="text" name="reason" value="<?php echo $row['reason'];?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Project</label>
							<select name="project" class="form-control">
								<?php 
									$conn = new mysqli('localhost','root','','agile support tool');
									$projectSelector = "select project.project_id as projectID, 
														team.team_id as teamID, team.project_id as projectNum,
														team_members.team_id as teamNum, team_members.id as member
														from project, team, team_members
														where project.project_id = team.project_id and 
														team.team_id = team_members.team_id and 
														team_members.id = ".$_SESSION['login_user']."";
													 
									$projectOutcome = $conn->query($projectSelector);
									
									if($projectOutcome->num_rows > 0) {
										while($projectTitle = $projectOutcome->fetch_assoc()) {
								?>
								<option value="<?php echo $projectTitle['projectID']; ?>" <?php if($projectTitle['projectID'] == $row['project_id']){ echo "selected"; } ?>>
									<?php
										$conn = new mysqli('localhost','root','','agile support tool');
										$projectData = "select project_id, project_name from project 
										                where project_id='".$projectTitle['projectID']."'";
										
										$dataResult = $conn->query($projectData);
										
										if($dataResult->num_rows > 0) {
											while($index = $dataResult->fetch_assoc()) {
												echo $index['project_name'];
											}
										}
									?>
								</option>
								<?php }} ?>
							</select>
						</div>
						<div class="form-group">
							<label>Sprint</label>
							<input type="text" name="sprint" value="<?php echo $row['sprint_id'];?>" class="form-control" required>
						</div>
						<div class="form-group">
							<label>Priority</label>
							<select id="priority" name="priority" class="form-control" required>
								<option value="none" selected disabled hidden>Select User Story Priority</option>
								<option value="Low" <?php if($row["priority"]=="Low") echo 'selected'; ?>>Low</option>
								<option value="Medium" <?php if($row["priority"]=="Medium") echo 'selected'; ?> >Medium</option>
								<option value="High" <?php if($row["priority"]=="High") echo 'selected'; ?>>High</option>
							</select>
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