<?php
include_once "dashboard.class.php";
$objDashbaord = new DASHBOARD();

if(!isset($_SESSION['USERID']) || $_SESSION['USERID'] == ""){
	header("Location: index.php");
}
?><html>
	<head>
		<title>My Travels</title>
		<link rel="stylesheet" href="commonstyle.css">
	</head>
	<body>
		<nav>
			<a href="showquestions.php">Available Questions</a>		
			<a href="answeredquestions.php">Answered Questions</a>		
			<a href="myprofile.php">My Profile</a>	
			<a href="?setAction=logOut">Logout</a>			
		</nav>
		<div class="mainDiv"><?php
			if(isset($_REQUEST['flagMsg']) && $_REQUEST['flagMsg'] == 'Y'){
				print("Your Question Added successfully");
			}
			?><h1>Ask your Questions </h1>
			<form name="frmQuestion" id="frmQuestion" method="post">
				<div>
					<div class="form-group">
						<label for="taQuestionTitle">Question Title :</label> <input name="taQuestionTitle" id="taQuestionTitle" class="input-class" value="" required>
					</div>
					<div class="form-group">
						<label for="taQuestion">Question Description :</label> <textarea name="taQuestion" id="taQuestion" class="input-class" required> </textarea>
					</div>
					<div class="form-group">
						<label for="txtReward">Reward :</label> <input type="text" name="txtReward" id="txtReward" value="" class="input-class" required>
					</div>
					<input type="hidden" id="setAction" name="setAction" value="addQuestion">
					<button type="submit">Submit Question </button>
				</div>
			</form>
		</div>
	</body>	
</html>