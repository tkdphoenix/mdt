<?php
	include_once('inc/header.inc.php');
	require_once('inc/conn.inc.php');
	// create new record ($_GET)
	if(isset($_GET['create'])){
	?>
	<section id="testRecords" class="testRecords container-fluid">
		<h1 class="text-center">Create a New Test Record</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
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
					<label for="numTests"><input id="numTests" class="form-control" name="numTests" type="number"> Number of Tests</label>
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
					<input id="createSubmit" class="form-control btn btn-primary" name="createSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				<div id="rightCol" class="col-md-6"></div>
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
					<input name="testId" type="hidden" value="<?=$id?>">
					<input id="editSubmit" class="btn btn-primary" name="editSubmit" type="submit" value="Submit">
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

		$sql = "UPDATE tests SET 
					company=:companyName,
					test_name=:testName,
					test_date=:testDate,
					number_of_tests=:numTests,
					tech_id=:techName
					WHERE id=:id";


		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		$stmt->bindParam(':companyName', $companyName, PDO::PARAM_STR);
		$stmt->bindParam(':testName', $testName, PDO::PARAM_STR);
		$stmt->bindParam(':testDate', $testDate, PDO::PARAM_STR);
		$stmt->bindParam(':numTests', $numTests, PDO::PARAM_STR);
		$stmt->bindParam(':techName', $techName, PDO::PARAM_STR);
		// run the query to update a company record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
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
				$stmt->bindParam(':id', $id, PDO::PARAM_STR);
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
		$sql = "SELECT * FROM tests ORDER BY company";
		// run the query to get all company records
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
		$companies = $q->fetchAll(PDO::FETCH_ASSOC);
	?>
		<section id="allCompanies" class="container-fluid">
			<div class="row">
				<div class="col-md-2">
					<a href="companies.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
				</div>
				<div class="col-md-8">
					<h1 class="text-center">All Companies</h1>
				</div>
				<div class="col-md-2">
					<a id="topNew" class="btn btn-primary addNew" href="companies.php?create=true">Add New</a>
					<form id="inactivateForm" action="?" method="post">
						<input id="iList" name="iList" type="hidden" value="">
						<input id="topInactive" name="inactivateSubmit" type="submit" class="btn btn-danger inactivate" value="Inactivate">
					</form>
				</div>
			</div> <!-- .row -->
			<table id="companiesTable" class="table table-hover table-responsive">
				<thead>
					<tr>
						<th><label for="checkAll"><input id="checkAll" name="checkAll" type="checkbox"><small>Check All</small></label></th>
						<th>Name</th>
						<th>Address</th>
						<!-- may need to add Address 2 here  -->
						<th>City</th>
						<th>State</th>
						<th>Zip Code</th>
						<th>Phone</th>
						<th>Additional Phone</th>
						<th>DER</th>
						<th>Email</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
					<?php
					// iterate over the $companies results and display them in the table
					foreach($companies as $c){
						if($c['active'] == "0"){
							echo "<tr class='warning'>";
						} else {
							echo "<tr>";
						} ?>
						<td><input id="<?=htmlspecialchars("$c[id]")?>" class="toRemove" name="toRemove" type="checkbox"></td>
						<td><?=htmlspecialchars("$c[company_name]")?></td>
						<td><?=htmlspecialchars("$c[addr1]")?>
						<?php if(isset($c['addr2'])){ ?>
						<br><?=htmlspecialchars("$c[addr2]")?>
						<?php } ?></td>
						<td><?=htmlspecialchars("$c[city]")?></td>
						<td><?=htmlspecialchars("$c[state]")?></td>
						<td><?=htmlspecialchars("$c[zip]")?></td>
						<td><a href="tel:<?=htmlspecialchars("$c[company_phone]")?>" class="phoneLink"><?=htmlspecialchars("$c[company_phone]")?></a></td>
						<?php if(isset($c['additional_phone'])){ ?>
						<td><a href="tel:<?=htmlspecialchars("$c[additional_phone]")?>" class="phoneLink"><?=htmlspecialchars("$c[additional_phone]")?></a></td>
						<?php } else { ?> &nbsp; <?php } ?>
						<td><?=htmlspecialchars("$c[company_der]")?></td>
						<td><a href="mailto:<?=htmlspecialchars("$c[email]")?>" class="emailLink"><?=htmlspecialchars("$c[email]")?></a></td>
						<td><a title="Edit" href="companies.php?edit=true&id=<?=$c['id'];?>" class="btn btn-success">Edit</a></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
			<div class="row">
				<div class="col-md-10"></div>
				<div class="col-md-2">
					<a id="bottomNew" class="btn btn-primary addNew" href="companies.php?create=true">Add New</a>
					<input id="bottomInactive" type="button" class="btn btn-danger inactivate" value="Inactivate">	
				</div>
			</div> <!-- .row -->
		</section>
<?php
/* END show inactive tests page section *********************/
	} elseif(isset($_GET['inactive'])) { // show inactive records

	} else { //list all records
		$sql = "SELECT tests.*, 
				concat(e.first, ' ', e.last) AS tech_name 
				FROM tests, employees 
				AS e 
				WHERE tests.tech_id = e.id
				ORDER BY company";
		// run the query to get all tests 
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$tests = $q->fetchAll(PDO::FETCH_ASSOC);
?>
	<section id="allTests" class="container-fluid">
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