<?php

include_once "index.class.php";
$objScr = new INDEX();

$showLogin = "display:none";
$showHome = "display:block";
if((isset($_REQUEST['flReg']) && $_REQUEST['flReg'] == 'Y') || (isset($_REQUEST['flUser']) && $_REQUEST['flUser'] == 'N')){
	$showLogin = "display:block";
	$showHome = "display:none";
	
}

?><html>
	<head>
		<title>My Travels</title>
		<link rel="stylesheet" href="commonstyle.css">
	</head>
	<body>
		<div class="mainDiv" id="homeDiv" style="<?php print($showHome); ?>">
			<h1> Welcome to My Travels </h1>
			<div>
				<button onclick="jsShowLogin()"> Login </button>
				<button onclick="jsShowRegister()"> Register </button>
			</div>
		</div>
		<form name="frmLogin" id="frmLogin" style="<?php print($showLogin);?>" method="post">
			<div class="mainDiv"><?php
				if(isset($_REQUEST['flReg']) && $_REQUEST['flReg'] == 'Y'){
					print("You are registered successfully. You can login here once you are approved by admin");
				}
				if(isset($_REQUEST['flUser']) && $_REQUEST['flUser'] == 'N'){
					print("User Not activated. Please try after sometime");
				}
				?><h1> Sign In </h1>
				<div class="form-group">
					<label for="txtEmail">Email* :</label> <input type="email" name="txtEmail" id="txtEmail" value=""  class="input-class">
				</div>
				<div class="form-group">
					<label for="txtPassword">Password* :</label> <input type="password" name="txtPassword" id="txtPassword" value=""  class="input-class">
				</div>
				<input type="hidden" name="setAction" value="login">
				<button type="submit" >Login </button>
			</div>
		</form>
		<form name="frmRegister" id="frmRegister" style="display:none;" enctype="multipart/form-data" method="post">
			<div class="mainDiv">
				<h1> Register </h1>
				<div class="form-group">
					<label for="txtEmail">First Name* :</label> <input type="text" name="txtFName" id="txtFName" value=""  class="input-class" required>
				</div>
				<div class="form-group">
					<label for="txtEmail">Last Name* :</label> <input type="text" name="txtLName" id="txtLName" value=""  class="input-class" required>
				</div>
				<div class="form-group">
					<label for="txtEmail">Email* :</label> <input type="email" name="txtEmail" id="txtEmail" value=""  class="input-class" required>
				</div>
				<div class="form-group">
					<label for="txtPhone">Phone* :</label> <input type="text" name="txtPhone" id="txtPhone" value=""  class="input-class" required>
				</div>
				<div class="form-group">
					<label for="txtEmail">Password* :</label> <input type="password" name="txtPassword" id="txtPassword" value=""  class="input-class" required>
				</div>
				<div class="form-group">
					<label for="txtEmail">Profile Image* :</label> <input type="file" name="flImage" id="flImage"   class="input-class" required>
				</div>
				<input type="hidden" name="setAction" value="register">
				<button type="submit" >Register </button>
			</div>
		</form>
		
	</body>
	<script>
		//function to show login page
		function jsShowLogin(){
			document.getElementById('frmLogin').style.display = "block";
			document.getElementById('homeDiv').style.display = "none";
			document.getElementById('frmRegister').style.display = "none";
		}
		
		//function to show register page
		function jsShowRegister(){
			document.getElementById('frmRegister').style.display = "block";
			document.getElementById('homeDiv').style.display = "none";
			document.getElementById('frmLogin').style.display = "none";
		}
	</script>
</html>