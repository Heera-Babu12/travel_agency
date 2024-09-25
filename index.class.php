<?php
class INDEX{

	function __construct(){
		// connection to check whether DB already exist - Idea refernce from chatgpt
		$connDB = new mysqli("localhost", "root", "");

		if ($connDB->connect_error) {
			die("Connection failed due to error : " . $connDB->connect_error);
		}

		$checkDBExist = $connDB->query("SHOW DATABASES LIKE 'travel_agency'")->num_rows > 0;

		if (!$checkDBExist) {
			$sqlContents = file_get_contents("queries.sql");

			if ($connDB->multi_query($sqlContents)) {
				do {
					if ($result = $connDB->store_result()) {
						$result->free();
					}
				}while ($connDB->next_result());
				print("Database and tables created.");
			} 
			else {
				print("Error on SQL file: " . $connDB->error);
			}
		} 
		else {
			echo "Database already exists.";
		}
		$connDB->close();
		
		// Connection for Project
		$this->conn = mysqli_connect("localhost", "root", "", "travel_agency");
		
		if(mysqli_connect_error()){
			print("connection failed");
		}
		
		session_start();
		if(isset($_REQUEST['setAction'])){
			switch($_REQUEST['setAction']){
				case "register": 
						if($this->addUser()){
							header("Location:index.php?flReg=Y");
						}
						break;
				
				case "login": $this->checkUser();
								break;
				
				case "loginAdmin": $this->checkAdmin();
								break;
				
				case "activate": $this->activateUser();
								break;
				
				case "deleteUser": $this->deleteUser();
								break;
				
				case "logOutAdmin": unset($_SESSION['ADMINUSER']);
									header("Location:adminlogin.php");
								break;
				
				
			}
		}
	}
	
	function addUser(){

		$qryIns = "INSERT INTO users(firstname, lastname, email, phoneno, filename, password, datetimex)
					VALUES(
						'" . $_REQUEST['txtFName'] . "',
						'" . $_REQUEST['txtLName'] . "',
						'" . $_REQUEST['txtEmail'] . "',
						'" . $_REQUEST['txtPhone'] . "',
						'" . basename($_FILES['flImage']['name']) . "',
						SHA1('" . $_REQUEST['txtPassword'] . "'),
						NOW()
					)";
		
		$objResult = mysqli_query($this->conn, $qryIns);
		
		if(!$objResult){
			print("Insertion failed");
			return false;
		}
		else{
			// Directory to save uploaded files
			$target_dir = "sysimgdocs/"; // Ensure this directory exists and is writable
			$target_file = $target_dir . basename($_FILES["flImage"]["name"]);
			$file_name = basename($_FILES["flImage"]["name"]);

			// Check if file is a valid upload
			if (move_uploaded_file($_FILES["flImage"]["tmp_name"], $target_file)) {
				return true;
			}
		}
		
		
	}
	
	function checkUser(){
		$qrySel = "SELECT recid FROM users WHERE email = '" . $_REQUEST['txtEmail'] . "' AND password = SHA1('" . $_REQUEST['txtPassword'] . "') AND flapproved = 'Y'";
		
		$objResult = mysqli_query($this->conn, $qrySel);
		
		$arrResult = mysqli_fetch_assoc($objResult);
		if(isset($arrResult['recid']) && $arrResult['recid'] > 0){
			session_start();
			$_SESSION['USERID'] = $arrResult['recid'];
			header("Location: dashboard.php");
		}
		else{
			print("User Not activated. Please try after sometime");
			header("Location: index.php?flUser=N");
			return false;
		}
	}
	
	// validate admin user 
	function checkAdmin(){
		if(!isset($_REQUEST['txtPassword']) && !isset($_REQUEST['txtName'])){
			print("PLease specify Username and Password");
			return false;
		}
		
		if($_REQUEST['txtName'] == 'admin' && $_REQUEST['txtPassword'] == "password"){
			session_start();
			$_SESSION['ADMINUSER'] = 1;
			header("Location: userslist.php");
		}
		else{
			print("Incorrect Username and Password");
			return false;
		}
	}
	
	// get all users for admin
	function getUsers(){
		$qrySel = "SELECT s.recid userId, s.firstname fName, s.lastname lName, s.email email, s.phoneno phoneNo, s.flapproved flagApproved, s.earnedrewards earnedRewards, s.filename fileName
					FROM users s
					WHERE (s.endeffdt IS NULL OR s.endeffdt > NOW() ) ";
		
		$objResult = mysqli_query($this->conn, $qrySel);			
		
		return $objResult;
	}
	
	//approve users 
	function activateUser(){
		
		if(!isset( $_REQUEST['userId'])) return false;
		
		$qryUpd = "UPDATE users 
					SET flapproved = 'Y'
					WHERE recid = '". $_REQUEST['userId'] ."'";
		
		$objResult = mysqli_query($this->conn, $qryUpd);			
		
		return true;
	}
	
	//delete users 
	function deleteUser(){
		
		if(!isset( $_REQUEST['userId'])) return false;
		
		$qryUpd = "UPDATE users 
					SET endeffdt = NOW()
					WHERE recid = '". $_REQUEST['userId'] ."'";
		
		$objResult = mysqli_query($this->conn, $qryUpd);			
		
		return true;
	}
}

?>