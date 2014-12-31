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
					<select name="companyName" id="companyName" class="form-control">
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
					<select name="testName" id="testName" class="form-control">
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
					<label for="testDate"><input id="testDate" class="form-control" name="testDate" type="date"> Test Date</label>
					<label for="numTests"><input id="numTests" class="form-control" name="numTests" type="number"> # Tests</label>
					<select name="techName" id="techName" class="form-control">
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

					<div class="row">
						<input id="submit" class="form-control btn btn-primary col-md-6" name="createSubmit" type="submit" value="Submit">
						<a id="cancelBtn" class="form-control btn btn-default col-md-6" href="testRecords.php">Cancel</a>
					</div> <!-- END .row -->
				</div> <!-- #leftCol -->
				<div id="spacer" class="col-md-1"></div>
				<div id="rightCol" class="col-md-6">
					<label for="baseFee"><input id="baseFee" class="form-control" name="baseFee" type="text"> Base Fee</label>
					<label for="fuelFee"><input id="fuelFee" class="form-control" name="fuelFee" type="text"> Fuel Fee</label>
					<label for="pagerFee"><input id="pagerFee" class="form-control" name="pagerFee" type="text"> Pager Fee</label>
					<label for="waitTimeFee"><input id="waitTimeFee" class="form-control" name="waitTimeFee" type="text"> Wait Time Fee</label>
					<label for="driveTimeFee"><input id="driveTimeFee" class="form-control" name="driveTimeFee" type="text"> Drive Time Fee</label>
					<label for="adminFee"><input id="adminFee" class="form-control" name="adminFee" type="text"> Admin Fee</label>
					<label for="trainingFee"><input id="trainingFee" class="form-control" name="trainingFee" type="text"> Training Fee</label>
					<label for="holidayFee"><input id="holidayFee" class="form-control" name="holidayFee" type="text"> Holiday Fee</label>
					<label for="miscFee"><input id="miscFee" class="form-control" name="miscFee" type="text"> Miscellaneous Fee</label>
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
						<select name="companyName" id="companyName" class="form-control">
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
						<select name="testName" id="testName" class="form-control">
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
							<input id="testDate" class="form-control" name="testDate" type="date" value="<?=htmlspecialchars("$result[test_date]")?>">
						<?php
						} else {
						?>
							<input id="testDate" class="form-control" name="testDate" type="date">
						<?php
						}
						?>
						
						 Test Date</label>
					<label for="numTests">
					<?php
					if(isset($result['number_of_tests'])){
					?>
						<input id="numTests" class="form-control" name="numTests" type="number" value="<?=htmlspecialchars("$result[number_of_tests]")?>">
					<?php
					} else {
					?>
						<input id="numTests" class="form-control" name="numTests" type="number">
					<?php
					}
					?>
					 Number of Tests</label>
					<label for="techName">
						<select name="techName" id="techName" class="form-control">
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
					 <label id="lActive" for="active"><input id="active" name="active" type="checkbox" <?php if($result['active'] == "1"){ echo "checked"; } ?>> Active</label>
					<input name="testId" type="hidden" value="<?=$id?>">

					<div class="row">
						<input id="submit" class="form-control btn btn-primary col-md-6" name="editSubmit" type="submit" value="Submit">
						<a id="cancelBtn" class="form-control btn btn-default col-md-6" href="testRecords.php">Cancel</a>
					</div> <!-- END .row -->
				</div> <!-- END #leftCol -->
			</div> <!-- END .row -->
			
		</form>
	</section>
		<?php
	} elseif(isset($_POST['createSubmit'])){ // create new record ($_POST)
		$companyName = $_POST['companyName'];
		$testName = $_POST['testName'];
		$testDate = $_POST['testDate'];
		$numTests = $_POST['numTests'];
		$techName = $_POST['techName']; // This is actually the tech_id

		$sql = "INSERT INTO tests (
				test_name,
				company,
				test_date,
				number_of_tests,
				tech_id
			) VALUES (
				:testName,
				:companyName,
				:testDate,
				:numTests,
				:techName
			)";
		try{
			$q = $conn->prepare($sql);
			$q->bindParam(':testName', $testName, PDO::PARAM_STR);
			$q->bindParam(':companyName', $companyName, PDO::PARAM_STR);
			$q->bindParam(':testDate', $testDate, PDO::PARAM_STR);
			$q->bindParam(':numTests', $numTests, PDO::PARAM_STR);
			$q->bindParam(':techName', $techName, PDO::PARAM_STR);
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
					active = :active
					WHERE id=:id";

		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->bindParam(':companyName', $companyName, PDO::PARAM_STR);
		$stmt->bindParam(':testName', $testName, PDO::PARAM_STR);
		$stmt->bindParam(':testDate', $testDate, PDO::PARAM_STR);
		$stmt->bindParam(':numTests', $numTests, PDO::PARAM_STR);
		$stmt->bindParam(':techName', $techName, PDO::PARAM_STR);
		$stmt->bindParam(':active', $active, PDO::PARAM_STR);
		// run the query to update a company record
		try{
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