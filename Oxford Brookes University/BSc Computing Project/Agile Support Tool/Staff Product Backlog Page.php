<?php
	include('Staff Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Staff Login Page.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Product Backlog</title>
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
	</head>
	<body>
		<nav class="navbar navbar-expand-md bg-dark navbar-dark">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
				<span class="navbar-toggler-icon"></span>
			</button>
			
			<div class="collapse navbar-collapse" id="collapsibleNavbar">
				<ul class="navbar-nav">
					<li class="nav-item">
						<a class="nav-link" href="Staff Dashboard.php">Dashboard</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Staff Project Page.php">Project</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Staff Team Page.php">Team</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="Staff Product Backlog Page.php">Product Backlog</a>
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
					<li><a href="Staff Logout.php">Logout</a></li>
				</ul>
			</div>
		</nav>
		
		<div id="main">
			<script>
				$(document).ready(function(){
					$('#myBtn').click(function(){
						$('#user_story').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
				});
			</script>
			<button class="btn btn-dark" type="button" id="myBtn" data-toggle="modal" data-target="#user_story">Add User Story</button>
			<div class="modal fade" id="user_story">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">New User Story</h4>
							<div class="close" data-dismiss="modal">&times;</div>
						</div>
						<div class="modal-body">
							<?php
								$conn = new mysqli('localhost','root','','agile support tool');
								
								if(isset($_POST['submit'])) {
									$user = $_POST['user'];
									$goal = $_POST['goal'];
									$reason = $_POST['reason'];
									$project = $_POST['project'];
									$sprint = $_POST['sprint'];
									$priority = $_POST['priority'];
									
									$query = "insert into user_story (user,goal,reason,project_id,sprint_id,priority) values ('".$user."','".$goal."','".$reason."','".$project."','".$sprint."','".$priority."')";
									
									if(mysqli_query($conn,$query)) {
										header("location: Staff Product Backlog Page.php");
									}
								}
							?>
							<form action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
								<div class="form-group">
									<label>As a</label>
									<input type="text" name="user" class="form-control" placeholder="Specify a type of user" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>I want to</label>
									<input type="text" name="goal" class="form-control" placeholder="Specify a goal" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>So that</label>
									<input type="text" name="reason" class="form-control" placeholder="Specify a reason" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Project</label>
									<select name="project" class="form-control custom-select" required>
										<option value="" selected disabled hidden>Select a Project</option>
										<?php
											$conn = new mysqli('localhost','root','','agile support tool');
											$projectQuery = "select team.team_id as teamID, team.project_id as projectNum,
															 team_members.team_id as teamNum, team_members.id as member
															 from team, team_members
															 where team.team_id = team_members.team_id and 
															 team_members.id = '".$_SESSION['login_user']."'";
													  
											$projectResult = $conn->query($projectQuery);
											
											if($projectResult->num_rows > 0) {
												while($projectIndex = $projectResult->fetch_assoc()) {
										?>
										<option value="<?php echo $projectIndex['projectNum']; ?>">
											<?php
												$conn = new mysqli('localhost','root','','agile support tool');
												$projectName = "select project_id, project_name from project 
												                where project_id = ".$projectIndex['projectNum']."";
																
												$nameResult = $conn->query($projectName);
												
												if($nameResult->num_rows > 0) {
													while($nameRow = $nameResult->fetch_assoc()) {
														echo $nameRow['project_name'];
													}
												}
											?>
										</option>
										<?php }} ?>
									</select>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Sprint</label>
									<input type="text" name="sprint" class="form-control" placeholder="Specify sprint number" required>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>
								<div class="form-group">
									<label>Priority</label>
									<select name="priority" class="form-control custom-select" required>
										<option value="" selected disabled hidden>Select User Story Priority</option>
										<option value="Low">Low</option>
										<option value="Medium">Medium</option>
										<option value="High">High</option>
									</select>
									<div class="valid-feedback">Valid.</div>
									<div class="invalid-feedback">Please fill out this field.</div>
								</div>	
								<div class="modal-footer">
									<input type="submit" name="submit" class="btn btn-primary" value="Create User Story">
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
			<input type="text" name="search" id="search" placeholder="Search User Story" autocomplete="off">
			<div id="result"></div>
			<script>
				$(document).ready(function(){
					load_data();
					function load_data(query)
					{
						$.ajax({
							url:"Staff Search Product Backlog.php",
							method:"POST",
							data:{query:query},
							success:function(data)
							{
								$('#result').html(data);
							}
						});
					}
				});
				
				$(document).ready(function(){
				  $("#search").on("keyup", function() {
					var value = $(this).val().toLowerCase();
					$("#product_backlog tr").filter(function() {
					  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				  });
				});
			</script>
		</div>
	</body>
</html>