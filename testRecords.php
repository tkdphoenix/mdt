<?php
	include_once('inc/common.inc.php');
	require_once('inc/conn.inc.php');
	// create new record ($_GET)
	if(isset($_GET['create'])){
		showHeader('Create Test Record');
	?>
	<section id="testRecords" class="testRecords container-fluid">
		<h1 class="text-center">Create a New Test Record</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-5">
					<label for="companyName">
						<select name="companyName" id="companyName" class="form-control" tabindex="10" required>
							<option value="" selected>Company Name</option>
							<?php
							$sql = "SELECT company_name FROM companies WHERE active=:active";
							$active = true;
							// run the query to get all companies for the dropdown 
							try{
								$q = $conn->prepare($sql);
								$q->bindParam(':active', $active, PDO::PARAM_STR);
								$q->execute();
							} catch(PDOException $e){
								file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
							}
							$companies = $q->fetchAll(PDO::FETCH_ASSOC);
							foreach($companies as $c){
							?>
							<option value="<?=htmlspecialchars("$c[company_name]")?>"><?=htmlspecialchars("$c[company_name]")?></option>
							<?php
							}
							?>
						</select> <!-- #companyName -->
					 Company Name</label>
					<label for="testName">
						<select name="testName" id="testName" class="form-control" tabindex="20" required>
							<option value="" selected>Test Name</option>
							<?php
							$active = true;
							$sql = "SELECT name FROM test_types WHERE active=:active";
							// run the query to get all test_types for the dropdown 
							try{
								$q = $conn->prepare($sql);
								$q->bindParam(':active', $active, PDO::PARAM_STR);
								$q->execute();
							} catch(PDOException $e){
								file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
							}
							$testTypes = $q->fetchAll(PDO::FETCH_ASSOC);
							foreach($testTypes as $t){
							?>
							<option value="<?=htmlspecialchars("$t[name]")?>"><?=htmlspecialchars("$t[name]")?></option>
							<?php
							}
							?>
						</select>
					 Test Name</label>
					<label for="testDate"><input id="testDate" class="form-control" name="testDate" type="date" tabindex="30" required> Test Date</label>
					<label for="numTests"><input id="numTests" class="form-control totalVals" name="numTests" type="number" step="any" tabindex="40" required> # Tests</label>
					<label for="techName">
						<select name="techName" id="techName" class="form-control" tabindex="50" required>
							<option value="" selected>Technician Name</option>
							<?php
							$active = true;
							$sql = "SELECT first, last, id FROM employees WHERE active=:active";
							// run the query to get all test_types for the dropdown 
							try{
								$q = $conn->prepare($sql);
								$q->bindParam(':active', $active, PDO::PARAM_STR);
								$q->execute();
							} catch(PDOException $e){
								file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
							}
							$employees = $q->fetchAll(PDO::FETCH_ASSOC);
							foreach($employees as $e){
							?>
							<option value="<?=htmlspecialchars("$e[id]")?>"><?=htmlspecialchars("$e[first]")?> <?=htmlspecialchars("$e[last]")?></option>
							<?php
							}
							?>
						</select>
					 Technician's Name</label>
					<textarea name="comments" class="form-control" placeholder="Comments"></textarea>

					<div class="row">
						<input id="submit" class="form-control btn btn-primary col-md-6" name="createSubmit" type="submit" value="Submit" tabindex="180">
						<a id="cancelBtn" class="form-control btn btn-default col-md-6" href="testRecords.php" tabindex="190">Cancel</a>
					</div> <!-- END .row -->
					<div class="row">
						<p id="totalAmt" class="col-md-12">Total Fees: $<span id="totalAmtSpan">0.00</span></p>
					</div>
				</div> <!-- #leftCol -->
				<div id="spacer" class="col-md-1"></div>
				<div id="rightCol" class="col-md-6">
					<label id="lRateType" for="rateType"><select name="rateType" id="rateType" class="form-control" tabindex="60" required>
						<option value="">Select rate type</option>
						<option value="perTest">Per Test</option>
						<option value="hourly">Hourly</option>
					</select> Rate Type</label>
					<label id="lNumHours" for="numHours"><input id="numHours" name="numHours" type="number" step="any" class="form-control totalVals" tabindex="70"> Number of Hours</label>
					<label for="baseFee"><input id="baseFee" class="form-control totalVals" name="baseFee" type="number" step="any" tabindex="80" required> First Test Fee</label>
					<label for="additionalFees"><input id="additionalFees" class="form-control totalVals" name="additionalFees" type="number" step="any" tabindex="90"> Additional Test Fees</label>
					<label for="fuelFee"><input id="fuelFee" class="form-control totalVals" name="fuelFee" type="number" step="any" tabindex="100"> Fuel Fee</label>
					<label for="pagerFee"><input id="pagerFee" class="form-control totalVals" name="pagerFee" type="number" step="any" tabindex="110"> Pager Fee</label>
					<label for="waitTimeFee"><input id="waitTimeFee" class="form-control totalVals" name="waitTimeFee" type="number" step="any" tabindex="120"> Wait Time Fee</label>
					<label for="driveTimeFee"><input id="driveTimeFee" class="form-control totalVals" name="driveTimeFee" type="number" step="any" tabindex="130"> Drive Time Fee</label>
					<label for="adminFee"><input id="adminFee" class="form-control totalVals" name="adminFee" type="number" step="any" tabindex="140"> Admin Fee</label>
					<label for="trainingFee"><input id="trainingFee" class="form-control totalVals" name="trainingFee" type="number" step="any" tabindex="150"> Training Fee</label>
					<label for="holidayFee"><input id="holidayFee" class="form-control totalVals" name="holidayFee" type="number" step="any" tabindex="160"> Holiday Fee</label>
					<label for="miscFee"><input id="miscFee" class="form-control totalVals" name="miscFee" type="number" step="any" tabindex="170"> Miscellaneous Fee</label>
				</div>
			</div> <!-- .row -->
		</form>
	</section>
	<?php
	} elseif(isset($_GET['edit'])){ // edit records ($_GET)
		$id = $_GET['id'];
		// get the record with the current ID on it
		$sql = "SELECT * FROM tests WHERE id=:id";
		try{
			$q = $conn->prepare($sql);
			$q->bindParam(':id', $id, PDO::PARAM_STR);
			$q->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$result = $q->fetch(PDO::FETCH_ASSOC);

		// several queries need to be run. Let's run them all at once for clarity later on
		// run the query to get all companies for the dropdown 
		$active = true;
		$sql = "SELECT company_name FROM companies WHERE active=:active";
		try{
			$q = $conn->prepare($sql);
			$q->bindParam(':active', $active, PDO::PARAM_STR);
			$q->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$companies = $q->fetchAll(PDO::FETCH_ASSOC);

		// run the query to get all test_types for the dropdown 
		$active = true;
		$sql = "SELECT name FROM test_types WHERE active=:active";
		try{
			$q = $conn->prepare($sql);
			$q->bindParam(':active', $active, PDO::PARAM_STR);
			$q->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$testTypes = $q->fetchAll(PDO::FETCH_ASSOC);

		// get all technician's names
		$active = true;
		$sql = "SELECT first, last, id FROM employees WHERE active=:active";
		try{
			$q = $conn->prepare($sql);
			$q->bindParam(':active', $active, PDO::PARAM_STR);
			$q->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$techs = $q->fetchAll(PDO::FETCH_ASSOC);
		showHeader('Edit a Test Record');
		?>
	<section id="testRecords" class="testRecords container-fluid">
		<h1 class="text-center">Edit a Test Record</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<label for="companyName">
						<select name="companyName" id="companyName" class="form-control" tabindex="10" required>
							<option value="">Company Name</option>
						<?php

							foreach($companies as $c){
								if(isset($c['company_name'])){
									if($c['company_name'] === $result['company']){
									?>
									<option selected value="<?=htmlspecialchars("$c[company_name]")?>"><?=htmlspecialchars("$c[company_name]")?></option>
									<?php			
									} else {
									?>
									<option value="<?=htmlspecialchars("$c[company_name]")?>"><?=htmlspecialchars("$c[company_name]")?></option>
									<?php
									} // END if($c['company_name'] === $result['company_name'])
								} // END if(isset($c['company_name']))
							} // END foreach($companies as $c)
						?>
						</select> <!-- #companyName -->
					 Company Name</label>
					<label for="testName">
						<select name="testName" id="testName" class="form-control" tabindex="20" required>
							<option value="">Test Name</option>
							<?php
							foreach($testTypes as $t){
								if(isset($t['name'])){
									if($t['name'] === $result['test_name']){
									?>
							<option selected value="<?=htmlspecialchars("$t[name]")?>"><?=htmlspecialchars("$t[name]")?></option>
									<?php
									} else { // END if($t['name'] === $result['test_name'])
									?>
							<option value="<?=htmlspecialchars("$t[name]")?>"><?=htmlspecialchars("$t[name]")?></option>
									<?php
									}
								} // END if(isset($t['name']) && isset($result['test_name']))
							} // END foreach($testTypes as $t)
							?>
						</select>
					 Test Name</label>
					<label for="testDate">
						<?php
						if(isset($result['test_date'])){
						?>
							<input id="testDate" class="form-control" name="testDate" type="date" value="<?=htmlspecialchars("$result[test_date]")?>" tabindex="30" required>
						<?php
						} else {
						?>
							<input id="testDate" class="form-control" name="testDate" type="date" tabindex="30" required>
						<?php
						}
						?>
						
						 Test Date</label>
					<label for="numTests">
					<?php
					if(isset($result['number_of_tests'])){
					?>
						<input id="numTests" class="form-control" name="numTests" type="number" step="any" value="<?=htmlspecialchars("$result[number_of_tests]")?>" tabindex="40" required>
					<?php
					} else {
					?>
						<input id="numTests" class="form-control" name="numTests" type="number" step="any" tabindex="40" required>
					<?php
					}
					?>
					 Number of Tests</label>
					<label for="techName">
						<select name="techName" id="techName" class="form-control" tabindex="50" required>
							<option value="">Technician Name</option>
							<?php
							foreach($techs as $t){
								if(isset($t['id'])){
									if($t['id'] === $result['tech_id']){
							?>
							<option selected value="<?=htmlspecialchars("$t[id]")?>"><?=htmlspecialchars("$t[first]")?> <?=htmlspecialchars("$t[last]")?></option>
							<?php
									} else {
							?>
							<option value="<?=htmlspecialchars("$t[id]")?>"><?=htmlspecialchars("$t[first]")?> <?=htmlspecialchars("$t[last]")?></option>
							<?php
									} // END if($t['name'] === $result['test_name'])
								} // END if(isset($t['id']))
							} // END foreach($techs as $t)
							?>
						</select>
					 Technician's Name</label>
					<textarea name="comments" class="form-control" placeholder="Comments" tabindex="60"></textarea>
					<label id="lActive" for="active"><input id="active" name="active" type="checkbox" <?php if($result['active'] == "1"){ echo "checked"; } ?> tabindex="70"> Active</label>
					<input name="testId" type="hidden" value="<?=$id?>">

					<div class="row">
						<input id="submit" class="form-control btn btn-primary col-md-6" name="editSubmit" type="submit" value="Submit" tabindex="200">
						<a id="cancelBtn" class="form-control btn btn-default col-md-6" href="testRecords.php" tabindex="210">Cancel</a>
					</div> <!-- END .row -->
					<div class="row">
						<p id="totalAmt" class="col-md-12">Total Fees: $<span id="totalAmtSpan">0.00</span></p>
					</div>
				</div> <!-- END #leftCol -->
				<div id="rightCol" class="col-md-6">
					<label id="lRateType" for="rateType"><select name="rateType" id="rateType" class="form-control" tabindex="80" required>
						<option value=''<?php if(@$result['rate_type'] === ""){ echo " selected"; } ?>>Select rate type</option>
						<option value='perTest' <?php if(@$result['rate_type'] === "perTest"){ echo "selected"; } ?>>Per Test</option>
						<option value='hourly' <?php if(@$result['rate_type'] === "hourly"){ echo "selected"; } ?>>Hourly</option>
					</select> Rate Type</label>
					<label id='lNumHours' for='numHours'><input id='numHours' name='numHours' type='number' step='any' class='form-control totalVals' tabindex='90' <?php if(isset($result['num_hours'])){ echo "value='" . $result['num_hours'] . "'"; } ?> > Number of Hours</label>
					<label for='baseFee'><input id='baseFee' class='form-control totalVals' name='baseFee' type='number' step='any' tabindex='100' <?php if(isset($result['base_fee'])){ echo "value='". $result['base_fee'] ."'";} ?> required> First Test Fee</label>
					<label for='additionalFees'><input id='additionalFees' class='form-control totalVals' name='additionalFees' type='number' step='any' tabindex='110' <?php if(isset($result['additional_test_fee'])){ echo "value='". $result['additional_test_fee'] ."'";} ?>> Additional Test Fees</label>
					<label for='fuelFee'><input id='fuelFee' class='form-control totalVals' name='fuelFee' type='number' step='any' tabindex='120' <?php if(isset($result['fuel_fee'])){ echo "value='". $result['fuel_fee'] ."'";} ?>> Fuel Fee</label>
					<label for='pagerFee'><input id='pagerFee' class='form-control totalVals' name='pagerFee' type='number' step='any' tabindex='130' <?php if(isset($result['pager_fee'])){ echo "value='". $result['pager_fee'] ."'";} ?>> Pager Fee</label>
					<label for='waitTimeFee'><input id='waitTimeFee' class='form-control totalVals' name='waitTimeFee' type='number' step='any' tabindex='140' <?php if(isset($result['wait_fee'])){ echo "value='". $result['wait_fee'] ."'";} ?>> Wait Time Fee</label>
					<label for='driveTimeFee'><input id='driveTimeFee' class='form-control totalVals' name='driveTimeFee' type='number' step='any' tabindex='150' <?php if(isset($result['drive_time_fee'])){ echo "value='". $result['drive_time_fee'] ."'";} ?>> Drive Time Fee</label>
					<label for='adminFee'><input id='adminFee' class='form-control totalVals' name='adminFee' type='number' step='any' tabindex='160' <?php if(isset($result['admin_fee'])){ echo "value='". $result['admin_fee'] ."'";} ?>> Admin Fee</label>
					<label for='trainingFee'><input id='trainingFee' class='form-control totalVals' name='trainingFee' type='number' step='any' tabindex='170' <?php if(isset($result['training_fee'])){ echo "value='". $result['training_fee'] ."'";} ?>> Training Fee</label>
					<label for='holidayFee'><input id='holidayFee' class='form-control totalVals' name='holidayFee' type='number' step='any' tabindex='180' <?php if(isset($result['holiday_fee'])){ echo "value='". $result['holiday_fee'] ."'";} ?>> Holiday Fee</label>
					<label for='miscFee'><input id='miscFee' class='form-control totalVals' name='miscFee' type='number' step='any' tabindex='190' <?php if(isset($result['misc_fee'])){ echo "value='". $result['misc_fee'] ."'";} ?>> Miscellaneous Fee</label>
				</div>
			</div> <!-- END .row -->
		</form>
	</section>
	<script>
		$(function(){
			var total = calcTotal();
			$('#totalAmtSpan').html(total);
		});
	</script>
		<?php
	} elseif(isset($_POST['createSubmit'])){ // create new record ($_POST)
		$companyName = $_POST['companyName'];
		$testName = $_POST['testName'];
		$testDate = $_POST['testDate'];
		$numTests = $_POST['numTests'];
		$techName = $_POST['techName']; // This is actually the tech_id
		$comments = $_POST['comments'];
		$rateType = $_POST['rateType'];
		$numHours = $_POST['numHours'];
		$baseFee = $_POST['baseFee'];
		$additionalFees = $_POST['additionalFees'];
		$fuelFee = $_POST['fuelFee'];
		$pagerFee = $_POST['pagerFee'];
		$waitTimeFee = $_POST['waitTimeFee'];
		$driveTimeFee = $_POST['driveTimeFee'];
		$adminFee = $_POST['adminFee'];
		$trainingFee = $_POST['trainingFee'];
		$holidayFee = $_POST['holidayFee'];
		$miscFee = $_POST['miscFee'];

		echo "company: $companyName<br>test: $testName<br>numtests: $numTests<br>techID: $techName<br>comments: $comments<br>rateType: $rateType<br>NumHours: $numHours<br>Base fee: $baseFee<br>Additional: $additionalFees<br>Fuel: $fuelFee<br>";

		$sql = "INSERT INTO tests (
				company,
				test_name,
				test_date,
				number_of_tests,
				tech_id,
				comments,
				rate_type,";
		if(isset($numHours) && $numHours != ""){
			$sql .= "num_hours,";
		}
		$sql .= "base_fee,
				additional_test_fee,
				fuel_fee,
				pager_fee,
				wait_fee,
				drive_time_fee,
				admin_fee,
				training_fee,
				holiday_fee,
				misc_fee
			) VALUES (
				:companyName,
				:testName,
				:testDate,
				:numTests,
				:techName,
				:comments,
				:rateType,
			";
		if(isset($numHours) && $numHours != ""){
			$sql .= ":numHours,";
		}
		$sql .=":baseFee,
				:additionalFees,
				:fuelFee,
				:pagerFee,
				:waitTimeFee,
				:driveTimeFee,
				:adminFee,
				:trainingFee,
				:holidayFee,
				:miscFee
			)";
		try{
			$q = $conn->prepare($sql);
			$q->bindParam(':companyName', $companyName, PDO::PARAM_STR);
			$q->bindParam(':testName', $testName, PDO::PARAM_STR);
			$q->bindParam(':testDate', $testDate, PDO::PARAM_STR);
			$q->bindParam(':numTests', $numTests, PDO::PARAM_STR);
			$q->bindParam(':techName', $techName, PDO::PARAM_STR);
			$q->bindParam(':comments', $comments, PDO::PARAM_STR);
			$q->bindParam(':rateType', $rateType, PDO::PARAM_STR);
			if(isset($numHours) && $numHours != ""){ $q->bindParam(':numHours', $numHours, PDO::PARAM_STR); }
			$q->bindParam(':baseFee', $baseFee, PDO::PARAM_STR);
			$q->bindParam(':additionalFees', $additionalFees, PDO::PARAM_STR);
			$q->bindParam(':fuelFee', $fuelFee, PDO::PARAM_STR);
			$q->bindParam(':pagerFee', $pagerFee, PDO::PARAM_STR);
			$q->bindParam(':waitTimeFee', $waitTimeFee, PDO::PARAM_STR);
			$q->bindParam(':driveTimeFee', $driveTimeFee, PDO::PARAM_STR);
			$q->bindParam(':adminFee', $adminFee, PDO::PARAM_STR);
			$q->bindParam(':trainingFee', $trainingFee, PDO::PARAM_STR);
			$q->bindParam(':holidayFee', $holidayFee, PDO::PARAM_STR);
			$q->bindParam(':miscFee', $miscFee, PDO::PARAM_STR);
			$q->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		showHeader('Create a Test Record');
?>
	<section id="newTestInfo" class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h1 class="center">New Test Added!</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<p>Company Name: <?=$companyName?></p>
				<p>Test Name: <?=$testName?></p>
				<p>Test Date: <?=$testDate?></p>
				<p>Number of Tests: <?=$numTests?></p>
<?php
				$sql = "SELECT first, last FROM employees WHERE id=:id";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':id', $techName, PDO::PARAM_STR);
				// run the query to update a company record
				try{
					$stmt->execute();
				} catch(PDOException $e){
					file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
				}
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
				<p>Technician's name: <?=$result['first'] . " " . $result['last']?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a class="btn btn-primary" href="testRecords.php">Return to Test Record List</a>
			</div>
		</div>
		<div id="createAnother" class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a href="testRecords.php?create=true" class="btn btn-default">Create New Test Record</a>
			</div>
		</div>
	</section>
<?php
	// END elseif(isset($_POST['createSubmit'])) *****************************
	} elseif(isset($_POST['editSubmit'])){ // edit records ($_POST)
		$id = $_POST['testId'];
		$companyName = $_POST['companyName'];
		$testName = $_POST['testName'];
		$testDate = $_POST['testDate'];
		$numTests = $_POST['numTests'];
		$techName = $_POST['techName'];
		$comments = $_POST['comments'];
		$rateType = $_POST['rateType'];
		$numHours = $_POST['numHours'];
		$baseFee = $_POST['baseFee'];
		$additionalFees = $_POST['additionalFees'];
		$fuelFee = $_POST['fuelFee'];
		$pagerFee = $_POST['pagerFee'];
		$waitTimeFee = $_POST['waitTimeFee'];
		$driveTimeFee = $_POST['driveTimeFee'];
		$adminFee = $_POST['adminFee'];
		$trainingFee = $_POST['trainingFee'];
		$holidayFee = $_POST['holidayFee'];
		$miscFee = $_POST['miscFee'];
		if(isset($_POST['active']) && $_POST['active'] == 'on'){
			$active = 1;
		} else {
			$active = 0;
		}

		$sql = "UPDATE tests SET 
					company=:companyName,
					test_name=:testName,
					test_date=:testDate,
					number_of_tests=:numTests,
					tech_id=:techName,
					comments=:comments,
					rate_type=:rateType,
					active = :active,
					num_hours = :numHours,
					base_fee=:baseFee,
					additional_test_fee=:additionalFees,
					fuel_fee=:fuelFee,
					pager_fee=:pagerFee,
					wait_fee=:waitTimeFee,
					drive_time_fee=:driveTimeFee,
					admin_fee=:adminFee,
					training_fee=:trainingFee,
					holiday_fee=:holidayFee,
					misc_fee=:miscFee
				WHERE id=:id";
		try{
			$stmt = $conn->prepare($sql);
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			$stmt->bindParam(':companyName', $companyName, PDO::PARAM_STR);
			$stmt->bindParam(':testName', $testName, PDO::PARAM_STR);
			$stmt->bindParam(':testDate', $testDate, PDO::PARAM_STR);
			$stmt->bindParam(':numTests', $numTests, PDO::PARAM_STR);
			$stmt->bindParam(':techName', $techName, PDO::PARAM_STR);
			$stmt->bindParam(':comments', $comments, PDO::PARAM_STR);
			$stmt->bindParam(':active', $active, PDO::PARAM_STR);
			$stmt->bindParam(':rateType', $rateType, PDO::PARAM_STR);
			$stmt->bindParam(':numHours', $numHours, PDO::PARAM_STR);
			$stmt->bindParam(':baseFee', $baseFee, PDO::PARAM_STR);
			$stmt->bindParam(':additionalFees', $additionalFees, PDO::PARAM_STR);
			$stmt->bindParam(':fuelFee', $fuelFee, PDO::PARAM_STR);
			$stmt->bindParam(':pagerFee', $pagerFee, PDO::PARAM_STR);
			$stmt->bindParam(':waitTimeFee', $waitTimeFee, PDO::PARAM_STR);
			$stmt->bindParam(':driveTimeFee', $driveTimeFee, PDO::PARAM_STR);
			$stmt->bindParam(':adminFee', $adminFee, PDO::PARAM_STR);
			$stmt->bindParam(':trainingFee', $trainingFee, PDO::PARAM_STR);
			$stmt->bindParam(':holidayFee', $holidayFee, PDO::PARAM_STR);
			$stmt->bindParam(':miscFee', $miscFee, PDO::PARAM_STR);

			// run the query to update a company record
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
		showHeader('Edit a Test Record');
?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h1>Test Updated</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<p>Company Name: <?=$companyName?></p>
				<p>Test Name: <?=$testName?></p>
				<p>Test Date: <?=$testDate?></p>
				<p>Number of Tests: <?=$numTests?></p>
<?php
				$sql = "SELECT first, last FROM employees WHERE id=:id";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':id', $techName, PDO::PARAM_STR);
				// run the query to update a company record
				try{
					$stmt->execute();
				} catch(PDOException $e){
					file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
				}
				$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
				<p>Technician's name: <?=$result['first'] . " " . $result['last']?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a class="btn btn-primary" href="testRecords.php">Return to Test Record List</a>
			</div>
		</div>
		<div id="createAnother" class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a href="testRecords.php?create=true" class="btn btn-default">Create New Test Record</a>
			</div>
		</div>
	</section>
<?php
	} elseif(isset($_POST['inactivateSubmit'])){ // inactivate record ($_POST)
		/* show inactive test records page section *********************/
		$sql = "UPDATE tests SET active = false WHERE id=:id";
		$stmt = $conn->prepare($sql);

		$list = $_POST['iList'];
		$listArray = explode(",", $list);

		foreach($listArray as $id){
			$stmt->bindParam(':id', $id, PDO::PARAM_STR);
			// run the query to make a company inactive
			try{
				$stmt->execute();
			} catch(PDOException $e){
				file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
			}
		} // END foreach()
		showHeader('Inactivate Test Records');
?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<p>The following tests were inactivated:</p>	
			</div>
		</div>
		<table id="inactivatedTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>Company</th>
					<th>Test Name</th>
					<th>Test Date</th>
					<th>Technician Name</th>
					<th>Number of Tests</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql = "SELECT tests.*, 
			concat(e.first, ' ', e.last) AS tech_name 
			FROM tests 
			LEFT JOIN employees AS e 
			ON tests.tech_id = e.id 
			WHERE tests.id IN ( $list ) 
			ORDER BY company";

	$stmt = $conn->prepare($sql);
	// $stmt->bindParam(':list', $list, PDO::PARAM_INT); 
	// run the query to list all tests that just became inactive
	try{
		$stmt->execute();
		$tests = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}

	foreach($tests as $t){
?>
				<tr>
					<td><?=htmlspecialchars("$t[company]")?></td>
					<td><?=htmlspecialchars("$t[test_name]")?></td>
					<td><?=htmlspecialchars("$t[test_date]")?></td>
					<td><?=htmlspecialchars("$t[tech_name]")?></td>
					<td><?=htmlspecialchars("$t[number_of_tests]")?></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
	</section>
	<div class="row">
		<div class="col-md-2 col-md-offset-1">
			<a class="btn btn-primary" href="testRecords.php">Return to Test Record List</a>
		</div>
		<div class="col-md-9">
			<a href="testRecords.php?create=true" class="btn btn-default">Create New Test Record</a>	
		</div>
	</div>
<?php
/* END show inactive tests page section *********************/
	} elseif(isset($_GET['inactive'])) { // show inactive records
		$sql = "SELECT tests.*, 
				concat(e.first, ' ', e.last)
				AS tech_name
				FROM tests
				LEFT JOIN employees 
				AS e ON tests.tech_id = e.id 
				ORDER BY company";
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$tests = $q->fetchAll(PDO::FETCH_ASSOC);
		showHeader('All Test Records');
?>
	<section id="allTests" class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				<a href="testRecords.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
			</div>
			<div class="col-md-8">
				<h1 class="text-center">All Test Records</h1>
			</div>
			<div class="col-md-2">
				<a href="testRecords.php?create=true" id="topNew" class="btn btn-primary addNew">Add New</a>
				<form id="inactivateForm" action="?" method="post">
					<input id="iList" name="iList" type="hidden" value="">
					<input id="topInactive" name="inactivateSubmit" type="submit" class="btn btn-danger inactivate" value="Inactivate">
				</form>
			</div>
		</div> <!-- .row -->
		<table id="testsTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th><label for="checkAll"><input type="checkbox" id="checkAll" name="checkAll"><small>Check All</small></label></th>
					<th>Company</th>
					<th>Test Name</th>
					<th>Test Date</th>
					<th>Technician Name</th>
					<th>Number of Tests</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($tests as $t){
				if($t['active'] == 0){
					echo "<tr class='warning'>";
				} else {
					echo "<tr>";
				}
			?>
				<td><input id="<?=htmlspecialchars("$t[id]")?>" type="checkbox" class="toRemove" name="toRemove"></td>
				<td><?=htmlspecialchars("$t[company]")?></td>
				<td><?=htmlspecialchars("$t[test_name]")?></td>
				<td><?=htmlspecialchars("$t[test_date]")?></td>
				<td><?=htmlspecialchars("$t[tech_name]")?></td>
				<td><?=htmlspecialchars("$t[number_of_tests]")?></td>
				<td><a href="testRecords.php?edit=true&id=<?=$t['id']?>" class="form-control btn btn-success">Edit</a></td>
			</tr>
			<?php	
			}
			?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<a href="testRecords.php?create=true" id="bottomNew" class="btn btn-primary addNew">Add New</a>
				<input type="button" id="bottomInactive" class="btn btn-danger inactivate" value="Inactivate">
			</div>
		</div> <!-- .row -->
	</section>
<?php
	} else { //list all records
		$sql = "SELECT tests.*, 
				concat(e.first, ' ', e.last)
				AS tech_name
				FROM tests
				LEFT JOIN employees 
				AS e ON tests.tech_id = e.id 
				WHERE tests.active='1'
				ORDER BY company";
		// run the query to get all tests 
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$tests = $q->fetchAll(PDO::FETCH_ASSOC);
		showHeader('All Test Records');
?>
	<section id="activeTests" class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				<a href="testRecords.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
			</div>
			<div class="col-md-8">
				<h1 class="text-center">All Tests</h1>
			</div>
			<div class="col-md-2">
				<a href="testRecords.php?create=true" id="topNew" class="btn btn-primary addNew">Add New</a>
				<form id="inactivateForm" action="?" method="post">
					<input id="iList" name="iList" type="hidden" value="">
					<input id="topInactive" name="inactivateSubmit" type="submit" class="btn btn-danger inactivate" value="Inactivate">
				</form>
			</div>
		</div> <!-- .row -->
		<table id="testsTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th><label for="checkAll"><input type="checkbox" id="checkAll" name="checkAll"><small>Check All</small></label></th>
					<th>Company</th>
					<th>Test Name</th>
					<th>Test Date</th>
					<th>Technician Name</th>
					<th>Number of Tests</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
			<?php
			foreach($tests as $t){
			?>
			<tr>
				<td><input id="<?=htmlspecialchars("$t[id]")?>" type="checkbox" class="toRemove" name="toRemove"></td>
				<td><?=htmlspecialchars("$t[company]")?></td>
				<td><?=htmlspecialchars("$t[test_name]")?></td>
				<td><?=htmlspecialchars("$t[test_date]")?></td>
				<td><?=htmlspecialchars("$t[tech_name]")?></td>
				<td><?=htmlspecialchars("$t[number_of_tests]")?></td>
				<td><a href="testRecords.php?edit=true&id=<?=$t['id']?>" class="form-control btn btn-success">Edit</a></td>
			</tr>
			<?php	
			}
			?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<a href="testRecords.php?create=true" id="bottomNew" class="btn btn-primary addNew">Add New</a>
				<input type="button" id="bottomInactive" class="btn btn-danger inactivate" value="Inactivate">
			</div>
		</div> <!-- .row -->
	</section>
<?php
	} // END else (show all active records)
	include_once('inc/footer.inc.php');
?>