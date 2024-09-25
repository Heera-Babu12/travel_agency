<?php

class DASHBOARD{
	
	function __construct(){
		$this->conn = mysqli_connect("localhost", "root", "", "travel_agency");
		
		if(mysqli_connect_error()){
			print("connection failed");
		}
		
		session_start();
		
		if(isset($_REQUEST['setAction'])){
			switch($_REQUEST['setAction']){
				case "addQuestion": 
								if($this->addQuestion()){
									header("Location: dashboard.php?flagMsg=Y");
									exit;
								}
								break;
				
				case "addAnswer" : $this->addAnswers();
								break;
								
				case "logOut" : session_destroy();
								header("Location: index.php");
								exit;
								break;
			
				case "approveAns" : 
								$this->approveAns();
								break;
								
				
			}
		}
	}
	
	function addQuestion(){
		
		$qryIns = "INSERT INTO question(addedby, question, description, reward, datetimex)
					VALUES(
						'" . $_SESSION['USERID'] . "',
						'" . $_REQUEST['taQuestionTitle'] . "',
						'" . $_REQUEST['taQuestion'] . "',
						'" . $_REQUEST['txtReward'] . "',
						NOW()
					)";
		
		$objResult = mysqli_query($this->conn, $qryIns);
		
		if(!$objResult){
			print("Insertion failed");
			return false;
		}
		
		return true;
	}
	
	function getQuestions($userId = 0){
		
		$where = "AND q.addedby != '" . $_SESSION['USERID'] . "'";
		if($userId > 0){
			$where = " AND q.addedby = '" . $userId . "' ";
		}
		
		$qrySel = "SELECT q.recid questionId, q.question question, q.description questionDesc,  q.reward reward  
					FROM question q 
					WHERE (q.endeffdt IS NULL OR q.endeffdt > NOW() OR q.endeffdt = '0000-00-00')
					{$where}";
		
		$objResult = mysqli_query($this->conn, $qrySel);
		
		if(!$objResult){
			print("Get result failed");
			return false;
		}
		
		return $objResult;
	}
	
	function addAnswers(){

		$arrAnswers = array();
		foreach($_REQUEST as $key => $value){
			if($value != ""){
				if(preg_match('/^taAnswer-(\d+)$/', $key, $matchNumbers)){
					$questionId = $matchNumbers[1];	
					$arrAnswers[$questionId] = $value;
				}
			}			
		}

		if(!empty($arrAnswers)){
			$qryIns = "INSERT INTO answers(questionid, answeredby, answer, datetimex)
						VALUES";
			
			foreach($arrAnswers as $questionId => $answer){
				$qryIns .= "( 
							'" . $questionId . "',
							'" . $_SESSION['USERID'] . "',
							'" . $answer . "',
							NOW()
							),";
			}
			
			$qryIns = rtrim($qryIns, ",");

			$objResult = mysqli_query($this->conn, $qryIns);
			
			if(!$objResult){
				print("Insertion failed");
				return false;
			}
		
			return true;
		}
		else{
			print("No answers provided");
			return false;
		}
		
	}
	
	// Get answers of Specified questions
	function getAnswers($questionId){
		
		$qrySel = "SELECT a.recid answerId, a.answeredby answeredBy, a.answer answer, a.flapproved flagApproved, DATE_FORMAT(a.datetimex, '%d/%m/%Y') dateAdded
					FROM answers a
					WHERE a.questionid = '" . $questionId . "' 
					AND (a.endeffdt IS NULL OR a.endeffdt > NOW() OR a.endeffdt = '0000-00-00')";
		
		$objResult = mysqli_query($this->conn, $qrySel);
		
		if(!$objResult){
			print("Get result failed");
			return false;
		}
		
		return $objResult;
	}
	
	// fetch user's all answered questions and answers
	function getQandA(){
		$qrySel = "SELECT q.recid questionId, q.question question, q.description questionDesc, q.reward reward, a.recid answerId, a.answer answer, a.flapproved flagApproved
					FROM question q, answers a
					WHERE a.answeredby = '" . $_SESSION['USERID'] . "' 
					AND q.recid = a.questionid
					AND (a.endeffdt IS NULL OR a.endeffdt > NOW() OR a.endeffdt = '0000-00-00')
					AND (q.endeffdt IS NULL OR q.endeffdt > NOW() OR q.endeffdt = '0000-00-00')";
		
		$objResult = mysqli_query($this->conn, $qrySel);
		
		if(!$objResult){
			print("Get result failed");
			return false;
		}
		
		return $objResult;
	}
	
	//Approve a answer
	function approveAns(){
		
		$qryUpd = "UPDATE answers a
					SET a.flapproved = 'Y'
					WHERE a.recid = '" . $_REQUEST['answerId'] . "'
					AND a.questionid = '" . $_REQUEST['questionId'] . "' ";
		
		$objResult = mysqli_query($this->conn, $qryUpd);
		
		if(!$objResult){
			print("Get result failed");
			return false;
		}
		else{
			$qrySel = "SELECT answeredby FROM answers WHERE recid = '" .  $_REQUEST['answerId'] . "' ";
			$objResult1 = mysqli_query($this->conn, $qrySel);			
			$arrAnswerBy = mysqli_fetch_assoc($objResult1);
			
			$qrySel2 = "SELECT reward FROM question WHERE recid = '" .  $_REQUEST['questionId'] . "' ";
			$objResult2 = mysqli_query($this->conn, $qrySel2);		
			$arrQuestionReward = mysqli_fetch_assoc($objResult2);
			
			$qryUpd = "UPDATE users SET earnedrewards = earnedrewards + '" . $arrQuestionReward['reward'] . "' WHERE recid = '" . $arrAnswerBy['answeredby'] .  "' ";
			
			$objRest = mysqli_query($this->conn, $qryUpd);
		}
		
		return true;
	}
	
	function getUserDetails(){
		$qrySel = "SELECT s.firstname fName, s.lastname lName, s.email email, s.phoneno phoneNo, s.earnedrewards earnedRewards
					FROM users s
					WHERE s.recid = '" . $_SESSION['USERID'] ."' ";
		
		$objResult = mysqli_query($this->conn, $qrySel);			
		$arrUsers = mysqli_fetch_assoc($objResult);
		
		return $arrUsers;
	}
	
	function checkAnsGiven($questionId){
		$qrySel = "SELECT count(*) alreadyAns 
					FROM answers 
					WHERE questionid = '" . $questionId . "' 
					AND answeredby = '" . $_SESSION['USERID'] . "' 
					GROUP BY questionid";
		
		$objResult = mysqli_query($this->conn, $qrySel);			
		$arrAlreadyAns = mysqli_fetch_assoc($objResult);
		
		if(isset($arrAlreadyAns['alreadyAns']) && $arrAlreadyAns['alreadyAns'] > 0){
			return true;
		}
		else{
			return false;
		}
	}
}
?>