<?php
	include('Student Session.php');
	if(!isset($_SESSION['login_user'])) {
		header("location: Student Login Page.php");
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Student Dashboard</title>
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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
				<button class="btn text-light btn" type="button" data-toggle="dropdown">
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
			<div class="card" id="dashboard-bar-chart">
				<div class="card-header"><h6>Overall Task Completion Rate</h6></div>
				<div class="card-body">
					<canvas id="task-bar-chart"></canvas>
					<?php
						$conn = new mysqli('localhost','root','','agile support tool');
						$query = "select team_members.team_id as teamID, team_members.id as member,
								  team.team_id as teamNum, team.project_id as projectID,
								  user_story.user_st_id as userStoryID, user_story.project_id as projectNum,
								  task.status as status, task.user_st_id as userStoryNum
								  from team_members, team, user_story, task
								  where team_members.team_id = team.team_id and
								  team_members.id = '".$_SESSION['login_user']."' and
								  team.project_id = user_story.project_id and
								  user_story.user_st_id = task.user_st_id";
						
						$result = mysqli_query($conn,$query);
						$unattemptedCount = 0;
						$pendingCount = 0;
						$finishedCount = 0;
						
						if($result->num_rows > 0) {
							while($row = $result->fetch_assoc()) {
								if($row['status'] == "To be Completed") {
									$unattemptedCount++;
								}
								else if($row['status'] == "Work in Progress"){
									$pendingCount++;
								}
								else if($row['status'] == "Finished") {
									$finishedCount++;
								}
							}
						}
					?>
					<script>
						new Chart(document.getElementById("task-bar-chart"), {
							type: 'bar',
							data: {
							  labels: ["To be Completed", "Work in Progress", "Finished"],
							  datasets: [
								{
								  backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f"],
								  data: [<?php echo $unattemptedCount; ?>,<?php echo $pendingCount; ?>,<?php echo $finishedCount; ?>]
								}
							  ]
							},
							options: {
							  legend: { display: false },
							  title: {
								display: false
							  }
							}
						});
					</script>
				</div>
			</div>
			<div class="card" id="dashboard-pie-chart">
				<div class="card-header"><h6>User Story Proportion</h6></div>
				<div class="card-body">
					<canvas id="user-story-pie-chart"></canvas>
					<?php
						$conn = new mysqli('localhost','root','','agile support tool');
						$priorityQuery = "select user_story.user_st_id as userStoryID, user_story.user as userType, 
						                  user_story.goal as userGoal, user_story.reason as userReason, 
										  user_story.sprint_id as sprintID, user_story.project_id as projectID,
										  user_story.priority as priority, project.project_id as projectNum, 
										  project.project_name as projectName,
										  team.team_id as teamID, team.project_id as projectNum, 
										  team_members.team_id as teamNum, team_members.id as member
										  from user_story, project, team, team_members where
										  user_story.project_id = project.project_id and 
										  user_story.project_id = team.project_id and 
										  team.team_id = team_members.team_id and 
										  team_members.id = '".$_SESSION['login_user']."'";
						
						$priorityResult = mysqli_query($conn,$priorityQuery);
						$total = 0;
						$lowCount = 0;
						$mediumCount = 0;
						$highCount = 0;
						$lowFormula;
						$mediumFormula;
						$highFormula;
						
						if($priorityResult->num_rows > 0) {
							while($position = $priorityResult->fetch_assoc()) {
								$total++;
								if($position['priority'] == "Low") {
									$lowCount++;
								}
								else if($position['priority'] == "Medium"){
									$mediumCount++;
								}
								else if($position['priority'] == "High") {
									$highCount++;
								}
							}
							$total = $lowCount + $mediumCount + $highCount;
							$lowFormula = ($lowCount / $total) * 360;
							$mediumFormula = ($mediumCount / $total) * 360;
							$highFormula = ($highCount / $total) * 360;
						}
					?>
					<script>				
						new Chart(document.getElementById("user-story-pie-chart"), {
							type: 'pie',
							data: {
							  labels: ["Low", "Medium", "High"],
							  datasets: [{
								backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f"],
								data: [<?php echo $lowFormula; ?>,<?php echo $mediumFormula; ?>,<?php echo $highFormula; ?>]
							  }]
							},
							options: {
							  title: {
								display: false
							  }
							}
						});
					</script>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h6>Project Completion</h6></div>
				<div class="card-body">
					<div class="table-responsive table-hover">
						<table class="table table-striped">
							<thead class="thead-dark">
								<th>Project</th>
								<th>Team</th>
								<th>Progress</th>
							</thead>
							<?php
								$conn = new mysqli('localhost','root','','agile support tool');
								$progressQuery = "select task.status as status, task.user_st_id as userStoryID,
												  user_story.user_st_id as userStoryNum, user_story.project_id as projectID,
												  team.team_id as teamID, team.team_name as teamName, team.project_id as projectNum,
												  team_members.team_id as teamNum, team_members.id as member,
												  project.project_id as projectCode, project.project_name as projectName
												  from task, user_story, team, team_members, project
												  where task.user_st_id = user_story.user_st_id and
												  user_story.project_id = team.project_id and
												  user_story.project_id = project.project_id and
												  team.team_id = team_members.team_id and
												  team_members.id = '".$_SESSION['login_user']."'";
												  
								$progressResult = mysqli_query($conn,$progressQuery);
								$incompleteCounter = 0;
								$completeCounter = 0;
								$colour = "";
								$projectName = "";
								$teamName = "";
								$progressFormula = "";
								
								if($progressResult->num_rows > 0) {
									while ($progressRow = $progressResult->fetch_assoc()) {
										$projectName = $progressRow["projectName"];
										$teamName = $progressRow["teamName"];
										
										if($progressRow["status"] == "To be Completed" || $progressRow["status"] == "Work in Progress") {
											$incompleteCounter++;
										}
										
										else if($progressRow["status"] == "Finished") {
											$completeCounter++;
										}
									}
									$incompleteTotal = $incompleteCounter + $completeCounter;
									$progressFormula .= (round((($completeCounter / $incompleteTotal) * 100),0));
									
									if($progressFormula == 0) {
										$colour = "";
									}
									
									else if($progressFormula > 0 && $progressFormula < 25) {
										$colour = "progress-bar bg-danger";
									}
									
									else if($progressFormula == 25) {
										$colour = "progress-bar bg-danger";
									}
									
									else if($progressFormula > 25 && $progressFormula < 50) {
										$colour = "progress-bar bg-danger";
									}
									
									else if($progressFormula == 50) {
										$colour = "progress-bar bg-warning";
									}
									
									else if($progressFormula > 50 && $progressFormula < 75) {
										$colour = "progress-bar bg-warning";
									}
									
									else if($progressFormula == 75) {
										$colour = "progress-bar bg-warning";
									}
									
									else if($progressFormula > 75 && $progressFormula < 100) {
										$colour = "progress-bar bg-info";
									}
									
									else if($progressFormula == 100) {
										$colour = "progress-bar bg-success";
									}
								}
							?>
							<tr>
								<div class="col"><td><?php echo $projectName; ?></td></div>
								<div class="col"><td><?php echo $teamName; ?></td></div>
								<div class="col">
									<td>
										<div class="progress"><div class="<?php echo $colour; ?>" style="width:<?php echo $progressFormula."%" ?>"><?php echo $progressFormula."%"; ?></div>
									</td>
								</div>
							</tr>
						</table>
					</div>
				</div>
			</div>
			<div class="card">
				<div class="card-header"><h6>Upcoming Deadlines</h6></div>
				<div class="card-body">
					<section id="tabs" class="project-tab">
						<div class="row">
							<div class="col-md-12">
								<nav>
									<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
										<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" 
											href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">
											Task 
												<span class="badge badge-danger">
													<?php
														$conn = new mysqli('localhost','root','','agile support tool');
														$taskCounterQuery = "select task_description, id, task_deadline from task where 
													                         id = '".$_SESSION['login_user']."'";
																			 
														$taskCounterResult = mysqli_query($conn,$taskCounterQuery);
														$taskCounter = 0;
														
														if($taskCounterResult->num_rows > 0) {
															$taskCounter++;
														}
														
														echo $taskCounter;
													?>
												</span>
										</a>
										<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" 
											href="#nav-profile" role="tab" aria-controls="nav-profile" 
											aria-selected="false">
											Project
											<span class="badge badge-danger">
												<?php
													$conn = new mysqli('localhost','root','','agile support tool');
													$projectCounterQuery = "select project.project_id as projectID, project.project_name as projectName,
																	        project.project_description as description, project.project_deadline as projectDeadline,
																	        team.team_id as teamID, team.project_id as projectNum,
																	        team_members.team_id as teamNum, team_members.id as member
																	        from project, team, team_members where
																	        project.project_id = team.project_id and
																	        team.team_id = team_members.team_id and
																	        team_members.id = '".$_SESSION['login_user']."'";
																		 
													$projectCounterResult = mysqli_query($conn,$taskCounterQuery);
													$projectCounter = 0;
													
													if($projectCounterResult->num_rows > 0) {
														$projectCounter++;
													}
													
													echo $projectCounter;
												?>
											</span>
										</a>
									</div>
								</nav>
								<div class="tab-content" id="nav-tabContent">
									<div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
										<div class="border">
											<ul class="event-list">
												<?php
													$conn = new mysqli('localhost','root','','agile support tool');

													$taskQuery = "select task_description, id, task_deadline from task where 
													              id = '".$_SESSION['login_user']."' order by task_deadline ASC";
													
													$taskResult = mysqli_query($conn,$taskQuery);
													
													if($taskResult->num_rows > 0) {
														while($taskDeadlineRow = $taskResult->fetch_assoc()) {
												?>
												<li>
													<time datetime="<?php echo date("d/m/Y",strtotime($taskDeadlineRow["task_deadline"])); ?>">
														<span class="day"><?php echo date("j",strtotime($taskDeadlineRow["task_deadline"])); ?></span>
														<span class="month"><?php echo date("M",strtotime($taskDeadlineRow["task_deadline"])); ?></span>
													</time>
													<div class="info">
														<h6 class="title">Task</h6>
														<p class="desc"><?php echo $taskDeadlineRow['task_description']; ?></p>
													</div>
												</li>
												<?php }} ?>
											</ul>
										</div>
									</div>
									<div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
										<div class="border">
											<ul class="event-list">
												<?php
													$conn = new mysqli('localhost','root','','agile support tool');
													$projectQuery = "select project.project_id as projectID, project.project_name as projectName,
																	 project.project_description as description, project.project_deadline as projectDeadline,
																	 team.team_id as teamID, team.project_id as projectNum,
																	 team_members.team_id as teamNum, team_members.id as member
																	 from project, team, team_members where
																	 project.project_id = team.project_id and
																	 team.team_id = team_members.team_id and
																	 team_members.id = '".$_SESSION['login_user']."'
																	 order by project.project_deadline ASC";
																	 
													$projectResult = mysqli_query($conn,$projectQuery);
													
													if($projectResult->num_rows > 0) {
														while($projectDeadlineRow = $projectResult->fetch_assoc()) {
												?>
												<li>
													<time datetime="<?php echo date("d/m/Y",strtotime($projectDeadlineRow["projectDeadline"])); ?>">
														<span class="day"><?php echo date("j",strtotime($projectDeadlineRow["projectDeadline"])); ?></span>
														<span class="month"><?php echo date("M",strtotime($projectDeadlineRow["projectDeadline"])); ?></span>
													</time>
													<div class="info">
														<h6 class="title"><?php echo $projectDeadlineRow["projectName"]; ?></h6>
														<p class="desc"><?php echo $projectDeadlineRow["description"]; ?></p>
													</div>
												</li>
												<?php }} ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
		</div>
	</body>
</html>