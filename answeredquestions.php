<?php
include_once "dashboard.class.php";
$objDashbaord = new DASHBOARD();

// Get all questions which aded by other users
$rsltCm = $objDashbaord->getQandA();

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
			<h1>Questions Answered </h1>
			<form name="frmAns" id="frmAns" method="post"><?php
				$count = 1;
				while($arrQuestions = mysqli_fetch_assoc($rsltCm)){
					?><div  class="form-group">
						<div class="questn"> Question <?php print($count); ?> :: <input type="text" disabled class="input-class" value="<?php print($arrQuestions['question']); ?>"></div>
						<div class="questn"> Question Description :: <textarea style="height: 89px;width: 287px;" disabled class="input-class"><?php print($arrQuestions['questionDesc']); ?></textarea></div><?php
						
						$reward = 0;
						if($arrQuestions['flagApproved'] == 'Y'){
							$reward = $arrQuestions['reward'];
						}
						?><div class="questn">Reward Earned :: <input type="text" disabled class="input-class" value="<?php print($reward); ?>">	</div>
						<div class="questn">Answer : <textarea class="input-class" name="taAnswer" disabled><?php print($arrQuestions['answer']); ?></textarea>	</div>
						<hr>
					</div><?php
					$count++;	
				}
				
				?><input type="hidden" name="setAction" id="setAction" value="">
			</form>
		</div>
	</body>

</html>