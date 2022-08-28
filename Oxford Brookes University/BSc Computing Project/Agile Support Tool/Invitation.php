<?php
	$conn = new mysqli('localhost','root','','agile support tool');
	$team_id = $_GET["team_id"];
	$invalid = "";
	$error = "";
	$status = "";
	$match = "";
	
	if(isset($_POST['submit'])) {
		$email = mysqli_real_escape_string($conn,$_POST['email']);
		$token = uniqid(md5(time()));
		
		$checkMember = "select team_members.team_id as teamID, team_members.id as member, 
		                account.id as userID, account.email_address as email
						from team_members, account
						where team_members.team_id = '".$team_id."' and
						team_members.id = account.id and
						account.email_address = '".$email."'";
						
		$checkMemberResult = mysqli_query($conn,$checkMember);
		
		if(mysqli_num_rows($checkMemberResult) > 0) {
			$match = "This user is already in your team";
		}
		
		else {
			$emailQuery = "select account.id as userID, account.forename as firstName, 
						   account.surname as lastName,
						   account.email_address as email, project.project_id as projectID, 
						   project.project_name as projectName, team.team_id as teamID, 
						   team.project_id as projectNum
						   from account, project, team 
						   where account.email_address = '".$email."' and
						   project.project_id = team.project_id and 
						   team.team_id = ".$team_id."";
						   
			$emailResult = mysqli_query($conn,$emailQuery);
			
			$senderQuery = "select id, forename, surname from account where id = ".$_SESSION['login_user']."";
			$senderResult = mysqli_query($conn,$senderQuery);
			
			if(mysqli_num_rows($senderResult) > 0) {
				$position = mysqli_fetch_assoc($senderResult);
				$sender = $position['forename']." ".$position['surname'];
			}
			
			if(filter_var($email)) {
				if(mysqli_num_rows($emailResult) > 0) {
					while($index = $emailResult->fetch_assoc()){
						$user_id = $index['userID'];
						$user_email = $index['email'];
						$addToken = "insert into invite_member(id,email_address,token) values ('".$user_id."','".$user_email."','".$token."')";
						if(mysqli_query($conn,$addToken)) {
							$name = $index['firstName']." ".$index['lastName'];
							$to = $email;
							$subject = "Project Invitation";
							$message = "Dear ".$name."";
							$message .= "<p>".$sender." has invited you to join the ".$index['projectName']." project:</p>";
							$message .= "<a href='http://localhost/Agile%20Support%20Tool/Add%20Team%20Member.php?token=".$token."&team_id=".$team_id."' target='_blank'><button>Accept</button></a>";
							$message .= "<p>Thanks</p>";
							$message .= "<p>Agile Support Tool Team</p>";
							
							$header = "MIME-Version: 1.0"."\r\n";
							$header .= "Content-type:text/html; charset=UTF-8"."\r\n";
							$header .= "From: <olibikar@gmail.com>"."\r\n";
							
							mail($to, $subject, $message, $header);
						}
						
						$status = "Invitation has been sent";
					}
				}
				
				else {
					$error = "This user does not exist";
				}
			}
			
			else {
				$invalid = "Please enter a valid email address";
			}
		}
	}
?>