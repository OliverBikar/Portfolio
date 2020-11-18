<!DOCTYPE html>
<html>
	<head>
		<title>Team Confirmation Page</title>
		<link rel="stylesheet" type="text/css" href="appStyle.php">
	</head>
	<body>		
		<div id="signupform">
			<form>
				<?php
					$conn = new mysqli('localhost','root','','agile support tool');
					$id = $_GET['id'];
					$teamNum = $_GET['team_id'];
					$query = "select account.id as userID, account.forename as forename,
					          account.surname as surname, project.project_id as projectiD,
							  project.project_name as projectName, team.team_id as teamID,
							  team.project_id as projectNum, team_members.team_id as teamNum,
							  team_members.id as member
							  from account, project, team, team_members where
							  account.id = '".$id."' and 
							  project.project_id = team.project_id and
							  team.team_id = team_members.team_id and 
							  team_members.id = '".$teamNum."'";
					
					$result = mysqli_query($conn,$query);
					
					if($result->num_rows > 0){
						while($row = $result->fetch_assoc()) {
							echo "<p>Hello"." ".$row['forename']." ".$row['surname']."";
							echo "<p>You are a team member of the project titled:</p>";
							echo "<p>".$row['projectName']."</p>";
						}
					}
				?>
				<p><input type="button" value="Proceed" onclick="document.location='Index.php'"></p>
			</form>
		</div>
		
	</body>
</html>