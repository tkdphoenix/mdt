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
						$sql = "SELECT company_name FROM companies WHERE active=true";
						// run the query to get all companies for the dropdown 
						try{
							$q = $conn->query($sql);
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
						$sql = "SELECT name FROM test_types WHERE active=true";
						// run the query to get all test_types for the dropdown 
						try{
							$q = $conn->query($sql);
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
						$sql = "SELECT first, last, id FROM employees WHERE active=true";
						// run the query to get all test_types for the dropdown 
						try{
							$q = $conn->query($sql);
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
		$id = htmlspecialchars($_GET['id']);
		// get the record with the current ID on it
		$sql = "SELECT * FROM tests WHERE id=$id";
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$result = $q->fetchAll(PDO::FETCH_ASSOC);


		// several queries need to be run. Let's run them all at once for clarity later on
		// run the query to get all companies for the dropdown 
		$sql = "SELECT company_name FROM companies WHERE active=true";
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$companies = $q->fetchAll(PDO::FETCH_ASSOC);

		// run the query to get all test_types for the dropdown 
		$sql = "SELECT name FROM test_types WHERE active=true";
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$testTypes = $q->fetchAll(PDO::FETCH_ASSOC);


		// get all technician's names
		$sql = "SELECT first, last, id FROM employees WHERE active=true";
		try{
			$q = $conn->query($sql);
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND || LOCK_EX);
		}
		$techs = $q->fetchAll(PDO::FETCH_ASSOC);
		?>
		<select name="companyName" id="companyName" class="form-control">
			<option value="">Company Name</option>
		<?php
			foreach($companies as $c){
				if(isset($c['company_name']) && isset($result['company'])){
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
		<select name="testName" id="testName" class="form-control">
			<option value="">Test Name</option>
			<?php
			foreach($testTypes as $t){
				if(isset($t['name']) && isset($result['test_name'])){
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
		<label for="testDate">
			<?php
			if(isset($result['test_date'])){
			?>
				<input id="testDate" class="form-control" name="testDate" type="date" value="<?=htmlspecialchars($result[test_date])?>">
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
			<input id="numTests" class="form-control" name="numTests" type="number" value="<?=htmlspecialchars($results[number_of_tests])?>">
		<?php
		} else {
		?>
			<input id="numTests" class="form-control" name="numTests" type="number">
		<?php
		}
		?>
		 Number of Tests</label>
		<select name="techName" id="techName" class="form-control">
			<option value="">Technician Name</option>
			<?php
			$sql = "SELECT first, last, id FROM employees WHERE active=true";
			// run the query to get all test_types for the dropdown 
			try{
				$q = $conn->query($sql);
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




		<?php
	} elseif(isset($_POST['createSubmit'])){ // create new record ($_POST)

	} elseif(isset($_POST['editSubmit'])){ // edit records ($_POST)

	} elseif(isset($_POST['inactivateSubmit'])){ // inactivate record ($_POST)

	} elseif(isset($_GET['inactive'])) { // show inactive records

	} else { //list all records
		$sql = "SELECT * FROM tests WHERE active = true";
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
				<td><?=htmlspecialchars("$t[technician_name]")?></td>
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