<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_GET['id'];
	
	$deleteTask = "delete from task where task.user_st_id = user_story.user_st_id and user_story.project_id = '".$id."'";
	mysqli_query($conn,$deleteTask);
	$deleteUserStory = "delete from user_story where project_id = '".$id."'";
	mysqli_query($conn,$deleteUserStory);
	$deleteTeamMembers = "delete from team_members where team_members.team_id = team.team_id and team.project_id = '".$id."'";
	mysqli_query($conn,$deleteTeamMembers);
	$deleteTeam = "delete from team where project_id = '".$id."'";
	mysqli_query($conn,$deleteTeam);
	$deleteProject = "delete from project where project_id = '".$id."'";
	mysqli_query($conn,$deleteProject);
	
	header("location: Staff Project Page.php");
?>