<?php
	$conn = mysqli_connect("localhost","root","","agile support tool");
	session_start();
	
	$user_check = $_SESSION['login_user'];
	$query = "select id from account where id = '".$user_check."'";
?>