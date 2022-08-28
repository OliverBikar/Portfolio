<?php
	include('Staff Session.php');
	$conn = mysqli_connect("localhost", "root", "", "agile support tool");
	$output = '';
		
	if(isset($_POST["query"])) {
		$search = mysqli_real_escape_string($conn, $_POST["query"]);
		$query = "select project.project_id as projectID, project.project_name as projectName,
		          project.project_description as description, project.project_start_date as startDate,
				  project.project_deadline as deadline,
				  team.team_id as teamID, team.project_id as projectNum,
				  team_members.team_id as teamNum, team_members.id as member
				  from project, team, team_members
				  where project.project_id = team.project_id and 
				  team.team_id = team_members.team_id and 
				  team_members.id = '".$_SESSION['login_user']."' and 
				  project.project_name like '%".$search."%'";
	}
	
	else {
		$query = "select project.project_id as projectID, project.project_name as projectName,
		          project.project_description as description, project.project_start_date as startDate,
				  project.project_deadline as deadline,
				  team.team_id as teamID, team.project_id as projectNum,
				  team_members.team_id as teamNum, team_members.id as member
				  from project, team, team_members
				  where project.project_id = team.project_id and 
				  team.team_id = team_members.team_id and 
				  team_members.id = '".$_SESSION['login_user']."'";
	}
	
	$result = mysqli_query($conn, $query);
		
	if(mysqli_num_rows($result) > 0) {
		$output .= '
			<div class="table-responsive table-hover">
				<table id="searchProjectTable" class="table table-striped">
					<thead class="thead-dark">
						<th>Project Title</th>
						<th>Description</th>
						<th>Start Date</th>
						<th>Deadline</th>
						<th>Action</th>
					</thead>';
						
		while($row = mysqli_fetch_array($result)) {
			$row["startDate"] = date("d/m/Y",strtotime($row["startDate"]));
			$row["deadline"] = date("d/m/Y",strtotime($row["deadline"]));
			$output .= '
				<div class="row">
					<tr>
						<div class="col"><td>'.$row["projectName"].'</td></div>
						<div class="col"><td id="descriptionColumn">'.$row["description"].'</td></div>
						<div class="col"><td>'.$row["startDate"].'</td></div>
						<div class="col"><td>'.$row["deadline"].'</td></div>
						<div class="col">
							<td>
								<a href="Staff Edit Project.php?project_id='.$row['projectID'].'"><button class="btn btn-dark btn-sm" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Edit Project"><i class="fa fa-edit"></i></button></a>
								<a class="delete" href="Staff Delete Project.php?project_id='.$row['projectID'].'"><button class="btn btn-dark btn-sm" data-toggle="popover" data-trigger="hover" data-placement="top" data-content="Delete Project"><i class="fa fa-trash"></i></button></a>
							</td>
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