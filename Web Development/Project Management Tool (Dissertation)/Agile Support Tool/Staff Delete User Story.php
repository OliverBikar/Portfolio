<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_GET['user_st_id'];
	
	if(mysqli_query($conn,"delete from user_story where user_st_id='".$id."'") && 
	   mysqli_query($conn,"delete from task where user_st_id='".$id."'")) {
		header("location: Staff Product Backlog Page.php");
	}
	mysqli_close($conn);
?>