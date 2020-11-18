<?php
	include('Student Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Sprint Backlog</title>
		<link rel="shortcut icon" type="image/png" href="Logo.png">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" 
		integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" 
		crossorigin="anonymous"></script>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="appStyle.php">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
		integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" 
		integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" 
		crossorigin="anonymous"></script>
		<script>
			$(document).ready(function(){
				$("a.delete").click(function(e){
					if(!confirm('Are you sure?')){
						e.preventDefault();
						return false;
					}
					return true;
				});
			});
		</script>
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
						
						$query = "select forename, surname from account where id=".$_SESSION['login_user'];
						$result = $conn->query($query);

						if ($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								echo $row['forename']." ".$row['surname'];
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
			<script>
				$(document).ready(function(){
					$('#myBtn').click(function(){
						$('#task').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
				});
			</script>
			<button class="btn btn-dark" type="button" id="myBtn" data-toggle="modal" data-target="#task">Add Task</button>
			<div class="modal fade" id="task">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">New Task</h4>
							<div class="close" data-dismiss="modal">&times;</div>
						</div>
						<div class="modal-body">
							<?php
								$conn = new mysqli('localhost','root','','agile support tool');
								$id = $_GET['user_st_id'];
								$query = "select * from task where user_st_id = '".$id."'";
								
								if(isset($_POST['submit'])){
									$task = $_POST['task'];
									$member = $_POST['member'];
									$startDate = $_POST['start'];
									$deadline = $_POST['deadline'];
									$status = $_POST['status'];
									$query = "insert into task (task_description,id,task_start_date,task_deadline,status,user_st_id) values('".$task."','".$member."','".$startDate."','".$deadline."','".$status."','".$id."')";
									
									if(mysqli_query($conn,$query)) {
										header("location: Sprint Backlog Page.php?user_st_id=".$id."");
									}
								}
							?>
							<form action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
								<div class="form-group">
									<label>Task</label>
									<input name="task" class="form-control" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Team Member</label>
									<select name="member" class="form-control" required>
										<option value="" selected disabled hidden>Select Team Member</option>
										<?php
											$conn = new mysqli('localhost','root','','agile support tool');
											$id = $_GET['user_st_id'];
											$query = "select team.team_id as teamID, team.project_id as projectID,
													  team_members.team_id as teamNum, team_members.id as member,
													  account.id as userID, account.forename as forename, account.surname as surname,
													  user_story.user_st_id as userStoryID, user_story.project_id as assignProject
													  from team, team_members, account, user_story
													  where user_story.user_st_id = ".$id." and 
													  user_story.project_id = team.project_id and
													  team.team_id = team_members.team_id and
													  team_members.id = account.id";
											$result = mysqli_query($conn,$query);
											$data = array();
											
											if(mysqli_num_rows($result) > 0) {
												while($row = mysqli_fetch_assoc($result)) {
													$data[] = $row;
													echo "<option value=".$row['member'].">".$row['forename']." ".$row['surname']."</option>";
												}
											}
										?>
									</select>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Start Date</label>
									<input type="date" name="start" class="form-control" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Deadline</label>
									<input type="date" name="deadline" class="form-control" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Status</label>
									<select id="status" name="status" class="form-control" required>
										<option value="" selected disabled hidden>Select Task Status</option>
										<option value="To be Completed">To be Completed</option>
										<option value="Work in Progress">Work in Progress</option>
										<option value="Finished">Finished</option>
									</select>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="modal-footer">
									<input type="submit" name="submit" class="btn btn-primary" value="Create Task">
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
						</div>
					</div>
				</div>
			</div>
			<input type="text" class="searchBar" placeholder="Search Task" autocomplete="off">
			<div class="table-responsive table-hover">
				<table id="searchSprintBacklogTable" class="table table-striped">
					<thead class="thead-dark">
						<th>Task ID</th>
						<th>Task</th>
						<th>Assigned To</th>
						<th>Start Date</th>
						<th>Deadline</th>
						<th>Status</th>
						<th>Action</th>
					</thead>
					<tbody id="sprint_backlog">
						<?php
							$conn = mysqli_connect("localhost", "root", "", "agile support tool");
							$query = "select account.id as userID, account.forename as forename, account.surname as surname,
									  task.task_id as taskID, task.task_description as taskDescription, task.id as userNum,
									  task.task_start_date as taskStartDate, task.task_deadline as taskDeadline, 
									  task.status as taskStatus, task.user_st_id as userStoryID 
									  from account, task
									  where account.id = task.id and task.user_st_id = ".$id."";
							$result = $conn->query($query);
							
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									$colour = "";
									
									if($row["taskStatus"] == "To be Completed") {
										$colour = "table-danger";
									}
									
									else if($row["taskStatus"] == "Work in Progress") {
										$colour = "table-warning";
									}
									
									else if($row["taskStatus"] == "Finished") {
										$colour = "table-success";
									}
									
									echo "
										  <div class='row'>
											  <tr class=".$colour.">
												<div class='col'><td>".$row["taskID"]."</td></div>
												<div class='col'><td id='taskDescriptionColumn'>".$row["taskDescription"]."</td></div>
												<div class='col'><td>".$row["forename"]." ".$row["surname"]."</td></div>
												<div class='col'><td>".date("d/m/Y",strtotime($row["taskStartDate"]))."</td></div>
												<div class='col'><td>".date("d/m/Y",strtotime($row["taskDeadline"]))."</td></div>
												<div class='col'><td>".$row["taskStatus"]."</td></div>
												<div class='col'>
													<td>
														<a href='Edit Task.php?task_id=".$row['taskID']."&userStory=".$id."''>
															<button class='btn btn-dark btn-sm' data-toggle='popover' data-trigger='hover' data-placement='top' data-content='Edit Task'><i class='fa fa-edit'></i></button>
														</a>
														<a class='delete' href='Delete Task.php?task_id=".$row['taskID']."'>
															<button class='btn btn-dark btn-sm' data-toggle='popover' data-trigger='hover' data-placement='top' data-content='Delete Task'><i class='fa fa-trash'></i></button>
														</a>
													</td>
												</div>
											  </tr>
										  </div>";
								}
							}
							$conn->close();
						?>
					</tbody>
				</table>
			</div>
			<script>
				$(document).ready(function(){
				  $('[data-toggle="tooltip"]').tooltip();
				});
				
				$(function () {
				  $('[data-toggle="popover"]').popover()
				})
			
				$(document).ready(function(){
				  $(".searchBar").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#sprint_backlog tr").filter(function() {
					  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				  });
				});
			</script>
		</div>
	</body>
</html>