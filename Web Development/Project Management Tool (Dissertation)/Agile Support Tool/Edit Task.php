<?php
	include('Student Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_REQUEST['task_id'];
	$query = "select * from task where task_id='".$id."'"; 
	$result = mysqli_query($conn, $query);
	$row = mysqli_fetch_assoc($result);
	
	$nameQuery = "select id, forename, surname from account where id=".$row['id']."";
	$nameResult = mysqli_query($conn,$nameQuery);
	$nameRow = mysqli_fetch_assoc($nameResult);
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Edit Task</title>
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
						
						$sessionName = "select forename, surname from account where id=".$_SESSION['login_user'];
						$sessionNameResult = $conn->query($sessionName);

						if ($sessionNameResult->num_rows > 0) {
							while($sessionNameRow = $sessionNameResult->fetch_assoc()) {
								echo $sessionNameRow['forename']." ".$sessionNameRow['surname'];
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
						$id = $_GET['task_id'];
						$task = $_POST['task'];
						$member = $_POST['member'];
						$startDate = $_POST['start'];
						$deadline = $_POST['deadline'];
						$status = $_POST['status'];
						
						if(mysqli_query($conn,"update task set task_description='".$task."', id='".$member."',task_start_date='".$startDate."',task_deadline='".$deadline."',status='".$status."' where task_id = ".$id."")) {
							header("location: Sprint Backlog Page.php?user_st_id=".$row['user_st_id']."");
						}
					}else {
				?>
				<div>
					<form id="editTaskForm" action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
						<input type="hidden" name="new" value="1">
						<div class="form-group">
							<label>Task Description</label>
							<input class="form-control" name="task" value="<?php echo $row['task_description'];?>" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Team Member</label>
							<select name="member" class="form-control" required>
								<?php
									$conn = new mysqli('localhost','root','','agile support tool');
									$teamMemberQuery = "select task.task_id as taskID, task.user_st_id as userStoryID,
									                    user_story.user_st_id as userStoryNum, user_story.project_id as projectID,
														team.team_id as teamID, team.project_id as projectNum,
														team_members.team_id as teamNum, team_members.id as member,
														account.id as userID, account.forename as forename, account.surname as surname
														from task, user_story, team, team_members, account
														where task.task_id = '".$id."' and
														task.user_st_id = user_story.user_st_id and
														user_story.project_id = team.project_id and
														team.team_id = team_members.team_id and
														team_members.id = account.id";
														
									$teamMemberResult = mysqli_query($conn,$teamMemberQuery);
											
									if(mysqli_num_rows($teamMemberResult) > 0) {
										while($teamMemberRow = mysqli_fetch_assoc($teamMemberResult)) {
								?>
								<option value="<?php echo $teamMemberRow['member']; ?>" <?php if($teamMemberRow['member'] == $row['id']){echo 'selected';} ?>><?php echo $teamMemberRow['forename']." ".$teamMemberRow['surname']; ?></option>
								<?php }} ?>
							</select>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Start Date</label>
							<input type="date" name="start" class="form-control" value="<?php echo $row['task_start_date']; ?>" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Deadline</label>
							<input type="date" name="deadline" class="form-control" value="<?php echo $row['task_deadline']; ?>" required>
							<div class="valid-feedback">Valid.</div>
							<div class="invalid-feedback">Please fill out this field.</div>
						</div>
						<div class="form-group">
							<label>Status</label>
							<select id="status" name="status" class="form-control">
								<option value="To be Completed" <?php if($row["status"]=="To be Completed") echo 'selected'; ?>>To be Completed</option>
								<option value="Work in Progress" <?php if($row["status"]=="Work in Progress") echo 'selected'; ?>>Work in Progress</option>
								<option value="Finished" <?php if($row["status"]=="Finished") echo 'selected'; ?>>Finished</option>
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