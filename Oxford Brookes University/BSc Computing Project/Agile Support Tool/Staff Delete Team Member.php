<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_GET['userID'];
	$team = $_GET['teamID'];
	$query = "delete from team_members where id=".$id." and team_id=".$team."";
	
	if(mysqli_query($conn,$query)) {
		header("location: Staff View Team.php?team_id=".$team."");
	}
	mysqli_close($conn);
?>