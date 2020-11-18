<?php
	include('Staff Session.php');
	$conn = mysqli_connect("localhost", "root", "", "agile support tool");
	$output = '';
		
	if(isset($_POST["query"])) {
		$search = mysqli_real_escape_string($conn, $_POST["query"]);
		$query = "select user_story.user_st_id as userStoryID, user_story.user as userType, user_story.goal as userGoal,
				  user_story.reason as userReason, user_story.sprint_id as sprintID, user_story.project_id as projectID,
				  user_story.priority as priority, project.project_id as projectNum, project.project_name as projectName,
				  team.team_id as teamID, team.project_id as projectNum, 
				  team_members.team_id as teamNum, team_members.id as member
				  from user_story, project, team, team_members where
				  user_story.project_id = project.project_id and 
				  user_story.project_id = team.project_id and 
				  team.team_id = team_members.team_id and team_members.id = '".$_SESSION['login_user']."'";
	}
	
	else {
		$query = "select user_story.user_st_id as userStoryID, user_story.user as userType, user_story.goal as userGoal,
				  user_story.reason as userReason, user_story.sprint_id as sprintID, user_story.project_id as projectID,
				  user_story.priority as priority, project.project_id as projectNum, project.project_name as projectName,
				  team.team_id as teamID, team.project_id as projectNum, 
				  team_members.team_id as teamNum, team_members.id as member
				  from user_story, project, team, team_members where
				  user_story.project_id = project.project_id and 
				  user_story.project_id = team.project_id and 
				  team.team_id = team_members.team_id and team_members.id = '".$_SESSION['login_user']."'";
	}
	
	$result = mysqli_query($conn, $query);
		
	if(mysqli_num_rows($result) > 0) {
		$output .= '
			<div class="table-responsive table-hover">
				<table id="searchProductBacklogTable" class="table table-striped">
					<thead class="thead-dark">
						<th>ID</th>
						<th>User Story</th>
						<th>Project</th>
						<th>Sprint</th>
						<th>Priority</th>
						<th>Action</th>
					</thead>
					<tbody id="product_backlog">';
						
		while($row = mysqli_fetch_array($result)) {
			$colour = "";
			
			if($row["priority"] == "Low") {
				$colour = "table-success";
			}
			
			else if($row["priority"] == "Medium") {
				$colour = "table-warning";
			}
			
			else if($row["priority"] == "High") {
				$colour = "table-danger";
			}
			
			$output .= '
				<div class="row">
					<tr class='.$colour.'>
						<div class="col"><td>'.$row["userStoryID"].'</td></div>
						<div class="col">
							<td id="story">As a '.$row["userType"].' I want to '.$row["userGoal"].' so that '.$row["userReason"].'</td>
						</div>
						<div class="col"><td>'.$row["projectName"].'</td></div>
						<div class="col"><td>'.$row["sprintID"].'</td></div>
						<div class="col"><td>'.$row["priority"].'</td></div>
						<div class="col">
							<td>
								<a href="Staff Sprint Backlog Page.php?user_st_id='.$row["userStoryID"].'">
									<button class="btn btn-dark btn-sm" data-toggle="popover" 
									data-trigger="hover" data-placement="top" 
									data-content="View Sprint Backlog"><i class="fa fa-tasks"></i></button>
								</a>
								<a href="Staff Edit User Story.php?user_st_id='.$row["userStoryID"].'">
									<button class="btn btn-dark btn-sm"><i class="fa fa-edit" data-toggle="popover"
									data-trigger="hover" data-placement="top" data-content="Edit User Story"></i></button>
								</a>
								<a class="delete" href="Staff Delete User Story.php?user_st_id='.$row["userStoryID"].'">
									<button class="btn btn-dark btn-sm" data-toggle="popover" data-trigger="hover" 
									data-placement="top" data-content="Delete User Story">
									<i class="fa fa-trash"></i></button>
								</a>
							</td>
						</div>
					</tr>
				</div>';
		}
		echo '</tbody>';
		echo '</table>';
		echo '</div>';
		echo $output;
	}
?>

<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
	
	$(function () {
	  $('[data-toggle="popover"]').popover()
	})
	
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