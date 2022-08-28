<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$id = $_GET['task_id'];
	$query = "delete from task where task_id=".$id."";
	
	if(mysqli_query($conn,$query)) {
		header("location: Staff Product Backlog Page.php");
	}
	mysqli_close($conn);
?>