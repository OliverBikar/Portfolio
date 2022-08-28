<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	
	if($_GET['token']) {
		$token = mysqli_real_escape_string($conn,$_GET['token']);
		$query = "select * from invite_member where token = '".$token."'";
		$result = mysqli_query($conn,$query);
		
		if(mysqli_num_rows($result) > 0){
			$row = mysqli_fetch_array($result);
			$token = $row['token'];
			$email = $row['email_address'];
		}
		else {
			header("location: Index.php");
		}
	}
	
	$memberSelector = "select id, forename, surname, email_address from account where email_address = '".$email."'";
	$selectorResult = mysqli_query($conn,$memberSelector);
	
	if(mysqli_num_rows($selectorResult) > 0){
		$index = mysqli_fetch_array($selectorResult);
		$userID = $index['id'];
	}
	
	$addMember = "insert into team_members (team_id,id) values('".$_GET['team_id']."','".$index['id']."')";
	mysqli_query($conn,$addMember);
	$delete = "delete from invite_member where email_address = '".$email."'";
	mysqli_query($conn,$delete);
	
	$alertQuery = "select account.id as userID, account.forename as forename, account.surname as surname,	
	               account.email_address as email, project.project_id as projectID, 
				   project.project_name as projectName, team.team_id as teamID, team.project_id as projectNum,
				   team_members.team_id as teamNum, team_members.id as member
	               from account, project, team, team_members
				   where account.email_address != '".$email."' and 
				   team.team_id = '".$_GET['team_id']."' and
				   team.project_id = project.project_id and
				   team_members.team_id = '".$_GET['team_id']."'";
				   
	$alertResult = mysqli_query($conn,$alertResult);
				   
	if(mysqli_num_rows($alertResult) > 0) {
		while($position = mysqli_fetch_array($alertResult)) {
			$name = $position['forename']." ".$position['surname'];											
			$to = $email;
			$subject = "Accepted Project: ".$position['projectName']."";
			$message = "Dear ".$position['forename']." ".$position['surname']."";
			$message .= "<p>".$index['forename']." ".$index['surname']." has joined the project: ".$position['projectName']."</p>";
			$message .= "<p>Thanks</p>";
			$message .= "<p>Agile Support Tool Team</p>";
			
			$header = "MIME-Version: 1.0"."\r\n";
			$header .= "Content-type:text/html; charset=UTF-8"."\r\n";
			$header .= "From: <olibikar@gmail.com>"."\r\n";
			
			mail($to, $subject, $message, $header);
		}
	}
	
	header("location: New Team Member Confirmation.php?id=".$index['id']."&team_id=".$_GET['team_id']."");
?>