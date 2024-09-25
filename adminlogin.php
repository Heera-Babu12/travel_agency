<?php

include_once "index.class.php";
$objScr = new INDEX();

?><html>
	<head>
		<title>My Travels</title>
		<link rel="stylesheet" href="commonstyle.css">
	</head>
	<body>
		<form name="frmLogin" id="frmLogin" method="post">
			<div class="mainDiv">
				<h1> Admin Login </h1>
				<div class="form-group">
					<label for="txtEmail">Username  :</label> <input type="text" name="txtName" id="txtName" value=""  class="input-class">
				</div>
				<div class="form-group">
					<label for="txtPassword">Password :</label> <input type="password" name="txtPassword" id="txtPassword" value=""  class="input-class">
				</div>
				<input type="hidden" name="setAction" value="loginAdmin">
				<button type="submit" >Login </button>
			</div>
		</form>
	</body>
	<script>
	
	</script>
</html>