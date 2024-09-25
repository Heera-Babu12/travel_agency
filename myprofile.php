<?php
include_once "dashboard.class.php";
$objDashbaord = new DASHBOARD();

$rsltQuestions = $objDashbaord->getQuestions($_SESSION['USERID']);
$arrUsers = $objDashbaord->getUserDetails();
?><html>
	<head>
		<title>My Travels</title>
		<link rel="stylesheet" href="commonstyle.css">
	</head>
	<body>
		<nav>
			<a href="dashboard.php">Back</a>
		</nav>
		<div class="mainDiv">
			<h1>My Profile </h1>
			<div class="form-group">
				<div> Available Rewards : <?php print(number_format($arrUsers['earnedRewards'],2)); ?></div>
			</div>
			
			<div class="">
				<h2>My Questions and Its answers</h2>
				<form name="frmQstn" id="frmQstn" method="post"><?php
					while($arrQuestions= mysqli_fetch_assoc($rsltQuestions)){
						?><div  class="form-group">
							<div class="questn"> <span class="lables" >Question Title :: </span> <?php print($arrQuestions['question']); ?></div>
							<div class="questn">  <span class="lables" >Question Description :: </span><?php print($arrQuestions['questionDesc']); ?></div>
							<div class="questn"> <span class="lables" > Answers given :: </span><?php
								$rsltAns = $objDashbaord->getAnswers($arrQuestions['questionId']);
								$count = 1;
								while($arrAns = mysqli_fetch_assoc($rsltAns)){
									?><div class=""> Answer<?php print($count); ?> :: <?php print($arrAns['answer']); ?></div><?php
									$checked = "";
									if($arrAns['flagApproved'] == 'Y'){
										$checked = "checked";
									}
									?><input type="checkbox" <?php print($checked); ?> id="chkApprove-<?php print($arrAns['answerId']); ?>" onclick="jsApproveAns(<?php print($arrAns['answerId']); ?>, <?php print($arrQuestions['questionId']);?>)"> Helpful<?php
								}
							?></div>
						</div><?php
					}
					?><input type="hidden" name="questionId" id="questionId" value=""> 
					<input type="hidden" name="setAction" id="setAction" value=""> 
					<input type="hidden" name="answerId" id="answerId" value=""> 
				</form>
			</div>
		</body>
	</body>	
	<script>
		function jsApproveAns(answerId, questionId){
			document.getElementById("questionId").value = questionId;
			document.getElementById("answerId").value = answerId;
			document.getElementById("setAction").value = "approveAns";
			
			document.getElementById("frmQstn").submit();
		}
		
	</script>
</html>