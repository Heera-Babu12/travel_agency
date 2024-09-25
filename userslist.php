<?php
include_once "index.class.php";
$objScr = new INDEX();


if(!isset($_SESSION['ADMINUSER'])){
	header("Location: adminlogin.php");
}
$rsltUsers = $objScr->getUsers();
?>
<html>
	<head>
		<title>My Travels</title>
		<link rel="stylesheet" href="commonstyle.css">
	</head>
	<body>
		<nav>
			<a href="?setAction=logOutAdmin">Logout</a>			
		</nav>
		<div class="mainDiv">
			<h1>Users </h1>
			<table>
				<tr>
					<td> First Name</td>
					<td> Last Name</td>
					<td> Email</td>
					<td> Phone</td>
					<td> File</td>
					<td> Status</td>
					<td>Delete </td>
				<tr><?php
				while($arrUsers = mysqli_fetch_assoc($rsltUsers)){
					?><tr>
						<td><?php print($arrUsers['fName']); ?></td>
						<td><?php print($arrUsers['lName']); ?></td>
						<td><?php print($arrUsers['email']); ?></td>
						<td><?php print($arrUsers['phoneNo']); ?></td>
						<!-- Image show refernce from Chatgpt -->
						<td><a href="sysimgdocs/<?php print($arrUsers['fileName']); ?>"> <?php print($arrUsers['fileName']); ?></a></td>
						<td><?php  
							if($arrUsers['flagApproved'] == 'Y'){
								print("Activated");
							}
							else{
								?><a href="?setAction=activate&userId=<?php print($arrUsers['userId']);?>"> Activate</a><?php
							}
						?></td>
						<td>
							<a href="?setAction=deleteUser&userId=<?php print($arrUsers['userId']); ?>"> Delete</a>
						</td>
					<tr><?php
				}
			?></table>
		</div>
	</body>
</html>