<?php
	include('Staff Session.php');
	$conn = mysqli_connect("localhost", "root", "", "agile support tool");
	$output = '';
		
	if(isset($_POST["query"])) {
		$search = mysqli_real_escape_string($conn, $_POST["query"]);
		$query = "select team.team_id as teamID, team.team_name as teamName, team.project_id as projectID,
		          team_members.team_id as teamNum, team_members.id as member,
				  project.project_id as projectID, project.project_name as projectName
				  from team, team_members, project
				  where team.team_id = team_members.team_id and 
				  team_members.id = '".$_SESSION['login_user']."' and
				  team.project_id = project.project_id and
				  team.team_name like '%".$search."%'";
	}
	
	else {
		$query = "select team.team_id as teamID, team.team_name as teamName, team.project_id as projectID,
		          team_members.team_id as teamNum, team_members.id as member,
				  project.project_id as projectID, project.project_name as projectName
				  from team, team_members, project
				  where team.team_id = team_members.team_id and 
				  team_members.id = '".$_SESSION['login_user']."' and
				  team.project_id = project.project_id";
	}
	
	$result = mysqli_query($conn, $query);
		
	if(mysqli_num_rows($result) > 0) {
		$output .= '
			<div class="table-responsive table-hover">
				<table class="table table-striped">
					<thead class="thead-dark">
						<th>Team Name</th>
						<th>Project</th>
						<th>Action</th>
					</thead>';
						
		while($row = mysqli_fetch_array($result)) {
			$output .= '
				<div class="row">
					<tr>
						<div class="col"><td>'.$row["teamName"].'</td></div>
						<div class="col"><td>'.$row["projectName"].'</td></div>
						<div class="col">
							<td>
								<a href="Staff View Team.php?team_id='.$row["teamID"].'"><button class="btn btn-dark btn-sm" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="View Team Members"><i class="fa fa-users"></i></button></a>
								<a href="Staff Edit Team.php?team_id='.$row["teamID"].'"><button class="btn btn-dark btn-sm" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Edit Team"><i class="fa fa-edit"></i></button></a>
							</td>
						</div>
					</tr>';
		}
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