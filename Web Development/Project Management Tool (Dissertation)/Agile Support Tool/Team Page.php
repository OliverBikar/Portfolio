<?php
	include('Student Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Team</title>
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
			$(window).on('load',function(){
				$('#team').modal('show');
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
						$('#team').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
				});
			</script>
			<button class="btn btn-dark" type="button" id="myBtn" data-toggle="modal" data-target="#team">Add Team</button>
			<div class="modal fade" id="team">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">New Team</h4>
							<div class="close" data-dismiss="modal">&times;</div>
						</div>
						<div class="modal-body">
							<?php
								$conn = new mysqli('localhost','root','','agile support tool');
								$error = "";
								
								if(isset($_POST['submit'])) {
									$team = $_POST['team'];
									$project = $_POST['project'];
									
									$teamSelector = "select * from team where project_id = '".$project."'";
									$teamSelectorResult = mysqli_query($conn,$teamSelector);
									
									if($teamSelectorResult->num_rows > 0) {
										$error = "This project is already allocated to a team";
									}
									
									else {
										$query = "insert into team (team_name,project_id) values('".$team."','".$project."')";
																		
										if(mysqli_query($conn,$query)) {
											$team_id = mysqli_insert_id($conn);
											$teamMemberQuery = "insert into team_members (team_id,id) values('".$team_id."','".$_SESSION['login_user']."')";
											if(mysqli_query($conn,$teamMemberQuery)) {
												header("location: Team Page.php");
											}
										}
									}
								}
							?>
							<div id="projectForm">
								<form action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
									<p class="error"><?php echo $error; ?></p>
									<div class="form-group">
										<label>Team Name</label>
										<input type="text" name="team" class="form-control" required>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="form-group">
										<label>Project</label>
										<select name="project" class="form-control custom-select" required>
											<option value="" selected disabled hidden>Please Select a Project</option>
											<?php
												$conn = new mysqli('localhost','root','','agile support tool');
					
												$projectQuery = "select project_id, project_name, project_owner from project
																 where project_owner = '".$_SESSION['login_user']."'";
												
												$projectResult = $conn->query($projectQuery);
												$data = array();
												
												if($projectResult->num_rows > 0) {
													while($projectIndex = $projectResult->fetch_assoc()) {
														$data[] = array_unique($projectIndex);
														echo "<option value=".$projectIndex['project_id'].">".$projectIndex['project_name']."</option>";
													}
												}
											?>
										</select>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="modal-footer">
										<input type="submit" name="submit" class="btn btn-primary" value="Create Team">
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
			</div>
			<input type="text" name="search" class="searchBar" placeholder="Search Team" autocomplete="off">
			<div id="result"></div>
			<script>
				$(document).ready(function(){
					load_data();
					function load_data(query)
					{
						$.ajax({
							url:"Search Team.php",
							method:"POST",
							data:{query:query},
							success:function(data)
							{
								$('#result').html(data);
							}
						});
					}
					$('.searchBar').keyup(function(){
						var search = $(this).val();
						if(search != '')
						{
							load_data(search);
						}
						else
						{
							load_data();
						}
					});
				});
			</script>
		</div>
	</body>
</html>