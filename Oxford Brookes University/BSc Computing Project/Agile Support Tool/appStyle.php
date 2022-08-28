<?php
	header("content-type: text/css;");
?>

body {
	background: #eee;
	margin: auto;
}

header{
	background-color: #333;
	position: relative;
	display: block;
	margin: auto;
	width: 100%;
}

#logo {
	height: 35px;
	width: 35px;
}

/*Signup Page Form*/
#signupform {
	border: solid gray 1px;
	width: 45%;
	border-radius: 5px;
	margin: 100px auto;
	background: white;
	padding: 50px;
}

	#signupform form p select{
		float: right;
		width: 50%;
	}

	#signupform form p input, #signupform .form-group .form-control{
		float: right;
		width: 50%;
	}
	
	#signupform form p #button{
		color: #fff;
		background: #337ab7;
		padding: 5px;
		text-align: center;
		display: block;
		margin: auto;
	}

#main{
	width: 85%;
	margin: auto;
	display: block;
}

/*Login Page Form*/
#form {
	border: solid gray 1px;
	width: 30%;
	border-radius: 5px;
	margin: 100px auto;
	background: white;
	padding: 50px;
}

	#form form p input{
		float: right;
	}
	
	#form form p #button{
		color: #fff;
		background: #337ab7;
		padding: 5px;
		text-align: center;
		display: block;
		margin: auto;
	}
	
	.error {
		text-align: center;
		color: red;
	}
	
	.status {
		text-align: center;
		color: green;
	}
	
	div.reset a{
		text-decoration: none;
		text-align: center;
		display: block;
		color: navy;
	}

.name {
	color: white;
	font-size: 20px;
	margin-top: -10px;
}
	
	#projectForm form p label input, #projectForm form p label textarea{
		display: block;
		margin-left: auto;
	}

/**Project Section**/
#myBtn{
	color: white;
	border: none;
	display: block;
	font-weight: bold;
	margin-top: 10px;
	margin-left: auto;
	margin-right: 0px;
	padding-top: 3px;
	padding-bottom: 3px;
	letter-spacing: 2px;
	text-transform: capitalize;
}

#search {
	width: 100%;
	display: block; 
	font-size: 16px;
	margin-top: 20px;
}
	
#searchProjectTable{
	display: block;
	margin-top: 20px;
}

#descriptionColumn, #projectColumn{
	width: 30%;
}

.searchBar{
	width: 100%;
	margin: auto;
	display: block;
	margin-top: 20px;
	margin-bottom: 20px;
}

#viewTeamTable{
	width: 50%;
	margin: auto;
	display: block;
	margin-top: 20px;
}

#searchProductBacklogTable{
	display: block;
	margin-top: 20px;
}

#story{
	width: 50%;
}

#taskDescriptionColumn {
	width: 40%;
}

/*Dashboard*/
ul {
	list-style-type: none;
}

.right {
	text-align: right;
}

.center {
	text-align: center;
}

.pointer {
	cursor: pointer;
}

.group:after {
	content: "";
	display: table;
	clear: both;
}

.event-list {
	list-style: none;
	font-family: 'Lato', sans-serif;
	margin: 0px;
	padding: 0px;
}

.event-list > li {
	background-color: rgb(255, 255, 255);
	box-shadow: 0px 0px 5px rgb(51, 51, 51);
	box-shadow: 0px 0px 5px rgba(51, 51, 51, 0.7);
	padding: 0px;
	margin: 0px 0px 20px;
}

.event-list > li > time {
	display: inline-block;
	width: 100%;
	color: rgb(255, 255, 255);
	background-color: rgb(197, 44, 102);
	padding: 5px;
	text-align: center;
	text-transform: uppercase;
}

.event-list > li:nth-child(even) > time {
	background-color: rgb(165, 82, 167);
}

.event-list > li > time > span {
	display: none;
}

.event-list > li > time > .day {
	display: block;
	font-size: 56pt;
	font-weight: 100;
	line-height: 1;
}

.event-list > li time > .month {
	display: block;
	font-size: 24pt;
	font-weight: 900;
	line-height: 1;
}

.event-list > li > img {
	width: 100%;
}

.event-list > li > .info {
	padding-top: 5px;
	text-align: center;
}

.event-list > li > .info > .title {
	font-size: 17pt;
	font-weight: 700;
	margin: 0px;
}

.event-list > li > .info > .desc {
	font-size: 13pt;
	font-weight: 300;
	margin: 0px;
}

.event-list > li > .info > ul, .event-list > li > ul {
	display: table;
	list-style: none;
	margin: 10px 0px 0px;
	padding: 0px;
	width: 100%;
	text-align: center;
}

.event-list > li > ul {
	margin: 0px;
}

.event-list > li > .info > ul > li, .event-list > li > ul > li {
	display: table-cell;
	cursor: pointer;
	color: rgb(30, 30, 30);
	font-size: 11pt;
	font-weight: 300;
	padding: 3px 0px;
}

.event-list > li > .info > ul > li > a {
	display: block;
	width: 100%;
	color: rgb(30, 30, 30);
	text-decoration: none;
}

.event-list > li > ul > li {    
	padding: 0px;
}

.event-list > li > ul > li > a {
	padding: 3px 0px;
}
 
.event-list > li > .info > ul > li:hover, .event-list > li > ul > li:hover {
	color: rgb(30, 30, 30);
	background-color: rgb(200, 200, 200);
}

@media (min-width: 768px) {
	.event-list > li {
		position: relative;
		display: block;
		width: 100%;
		height: 120px;
		padding: 0px;
}

.event-list > li > time, .event-list > li > img  {
	display: inline-block;
}

.event-list > li > time, .event-list > li > img {
	width: 120px;
	float: left;
}

.event-list > li > .info {
	background-color: rgb(245, 245, 245);
	overflow: hidden;
}

.event-list > li > time, .event-list > li > img {
	width: 120px;
	height: 120px;
	padding: 0px;
	margin: 0px;
}

.event-list > li > .info {
	position: relative;
	height: 120px;
	text-align: left;
	padding-right: 40px;
}
	
.event-list > li > .info > .title, .event-list > li > .info > .desc {
	padding: 0px 10px;
}

.event-list > li > .info > ul {
	position: absolute;
	left: 0px;
	bottom: 0px;
}

.event-list > li > {
	position: absolute;
	top: 0px;
	right: 0px;
	display: block;
	width: 40px;
}

.event-list > li > ul {
	border-left: 1px solid rgb(230, 230, 230);
}

.event-list > li > ul > li {			
	display: block;
	padding: 0px;
}

.event-list > li > ul > li > a {
	display: block;
	width: 40px;
	padding: 10px 0px 9px;
}

/*Edit Project Form*/
#editProjectForm {
	border: solid gray 1px;
	width: 100%;
	border-radius: 5px;
	margin: 100px auto;
	background: white;
	padding: 50px;
}

	#editProjectForm form p input{
		float: right;
	}
	
/*Edit Team Description Form*/
#editTeamDescriptionForm {
	border: solid gray 1px;
	width: 30%;
	border-radius: 5px;
	margin: 100px auto;
	background: white;
	padding: 50px;
}

	#editTeamDescriptionForm form p input{
		float: right;
	}
	
/*Edit User Story Form*/
#editUserStoryForm {
	border: solid gray 1px;
	width: 100%;
	border-radius: 5px;
	margin: 100px auto;
	background: white;
	padding: 50px;
}

	#editUserStoryForm form p input{
		float: right;
	}
	
/*Edit Task Form*/
#editTaskForm {
	border: solid gray 1px;
	width: 100%;
	border-radius: 5px;
	margin: 100px auto;
	background: white;
	padding: 50px;
}

	#editTaskForm form p input{
		float: right;
	}
	
/*User Dashboard*/
.card{
	margin-top: 35px;
	margin-bottom: 35px;
}

#dashboard-bar-chart{
	display: inline-block;
	width: 570px;
	height: 500px;
}

#dashboard-pie-chart{
	display: inline-block;
	width: 570px;
	height: 500px;
}

#user-story-pie-chart{
	padding-top: 10px;
	padding-bottom: 110px;
}

.table-responsive table-hover{
	margin-bottom: 0px;
}

.project-tab{
	margin-top: 35px;
}