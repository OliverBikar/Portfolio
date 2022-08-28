<?php
	include('Student Session.php');
	include('Invitation.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Team Members</title>
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
			$(window).on('load',function(){
				$('#member').modal('show');
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
						$('#member').modal({
							backdrop: 'static',
							keyboard: false
						});
					});
				});
			</script>
			<button class="btn btn-dark" type="button" id="myBtn" data-toggle="modal" data-target="#member" data-dismiss="modal">Add Team Member</button>
			<div class="modal fade" id="member">
				<div class="modal-dialog modal-x1">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">New Team Member</h4>
							<div class="close" data-dismiss="modal">&times;</div>
						</div>
						<div class="modal-body">
							<div id="projectForm">
								<form action="" autocomplete="off" method="POST" class="needs-validation" novalidate>
									<div class="form-group">
										<p class="error"><?php echo $invalid; ?></p>
										<p class="error"><?php echo $error; ?></p>
										<p class="error"><?php echo $match; ?></p>
										<p class="status"><?php echo $status; ?></p>
										<label>Invite</label>
										<input type="text" name="email" placeholder="Specify Email Address" class="form-control" required>
										<div class="valid-feedback">Valid.</div>
										<div class="invalid-feedback">Please fill out this field.</div>
									</div>
									<div class="modal-footer">
										<button type="submit" name="submit" class="btn btn-primary">Confirm</button>
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
			<input type="text" class="searchBar" placeholder="Search Team Member" autocomplete="off">
			<div class="table-responsive table-hover">
				<table class="table table-striped">
					<thead class="thead-dark">
						<th>ID</th>
						<th>Name</th>
						<th>User Type</th>
						<th>Email Address</th>
						<th>Action</th>
					</thead>
					<tbody id="team_table">
						<?php
							$conn = mysqli_connect("localhost", "root", "", "agile support tool");
							$team_id = $_GET["team_id"];
							$query = "select team_members.team_id as teamNum, team_members.id as userID, 
									  account.id as userNum, account.forename as forename, 
									  account.surname as surname, account.email_address as email,
									  account.user_type as userType from team_members, account 
									  where team_members.team_id = ".$team_id." and team_members.id = account.id";
							$result = $conn->query($query);
							
							if ($result->num_rows > 0) {
								while($row = $result->fetch_assoc()) {
									if($row["userNum"] != $_SESSION['login_user']) {
										echo "
											<div class='row'>
											  <tr>
												<div class='col'><td>".$row["userNum"]."</td></div>
												<div class='col'><td>".$row["forename"]." ".$row["surname"]."</td></div>
												<div class='col'><td>".$row["userType"]."</td></div>
												<div class='col'><td>".$row["email"]."</td></div>
												<div class='col'>
													<td>
														<a class='delete' href='Delete Team Member.php?userID=".$row["userID"]."&teamID=".$row["teamNum"]."'>
															<button class='btn btn-dark btn-sm' data-toggle='popover' data-trigger='hover' data-placement='top' data-content='Delete Team Member'>
																<i class='fa fa-trash'></i>
															</button>
														</a>
													</td>
												</div>
											  </tr>
											</div>";
									}
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
					$("#team_table tr").filter(function() {
					  $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
					});
				  });
				});
			</script>
		</div>
	</body>
</html>