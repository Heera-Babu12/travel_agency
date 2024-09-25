<?php
include_once "dashboard.class.php";
$objDashbaord = new DASHBOARD();

// Get all questions which aded by other users
$rsltCm = $objDashbaord->getQuestions();

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
			<h1>Questions Available </h1>
			<form name="frmAns" id="frmAns" method="post"><?php
				$count = 1;
				while($arrQuestions = mysqli_fetch_assoc($rsltCm)){
					$flagAns = $objDashbaord->checkAnsGiven($arrQuestions['questionId']);
					if($flagAns) continue;
					if(!isset($_REQUEST['taAnswer-'. $arrQuestions['questionId']])) $_REQUEST['taAnswer-'. $arrQuestions['questionId']] = "";
					?><div  class="form-group">
						<div class="questn"> Question <?php print($count); ?> :: <input type="text" disabled class="input-class" value="<?php print($arrQuestions['question']); ?>"></div>
						<div class="questn"> Question Description :: <textarea style="height: 89px;width: 287px;" disabled class="input-class"><?php print($arrQuestions['questionDesc']); ?></textarea></div>
						<div class="questn">Reward :: <input type="text" disabled class="input-class" value="<?php print($arrQuestions['reward']); ?>">	</div>
						<div class="questn">Answer : <textarea class="input-class" name="taAnswer-<?php print($arrQuestions['questionId']); ?>" id="taAnswer-<?php print($arrQuestions['questionId']); ?>"><?php print($_REQUEST['taAnswer-'. $arrQuestions['questionId']]); ?></textarea>	</div>
						<hr>
					</div><?php
					$count++;	
				}
				
				?><input type="hidden" name="setAction" id="setAction" value="">
				<button type="button" onclick="jsSubmitAnswer()">Submit Answer </button>
			</form>
		</div>
	</body>
	<script>
		function jsSubmitAnswer(){
			var objForm = document.getElementById('frmAns');
			document.getElementById('setAction').value = "addAnswer";
			objForm.submit();
		}
		
	</script>
</html>