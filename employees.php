<?php
	require_once('inc/startsession.php');
	include_once('inc/common.inc.php');
	require_once('inc/conn.inc.php');
	if(!isset($_SESSION['user'])){
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
		header('Location: ' . $home_url);
	}

	if(isset($_POST['createSubmit'])){
		/* create employees $_POST section *********************/
		// set post variables
		$firstName = $_POST['first'];
		$lastName = $_POST['last'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'] || '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$batId = $_POST['batId'];
		$ssn = $_POST['ssn'];
		$dob = $_POST['dob'];

		// SQL statement - use PDO::prepare() when possible
		$sql = "INSERT INTO employees(first,
			last,
			addr1,
			addr2,
			city,
			state,
			zip,
			phone,
			email,
			bat_id,
			ssn,
			dob) VALUES (
			:first,
			:last,
			:addr1,
			:addr2,
			:city,
			:state,
			:zip,
			:phone,
			:email,
			:batId,
			:ssn,
			:dob)";
		
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':first', $firstName, PDO::PARAM_STR);
		$stmt->bindParam(':last', $lastName, PDO::PARAM_STR);
		$stmt->bindParam(':addr1', $addr1, PDO::PARAM_STR);
		$stmt->bindParam(':addr2', $addr2, PDO::PARAM_STR);
		$stmt->bindParam(':city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':state', $state, PDO::PARAM_STR);
		$stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':batId', $batId, PDO::PARAM_STR);
		$stmt->bindParam(':ssn', $ssn, PDO::PARAM_STR);
		$stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
		// run the query to insert a new employee record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
		/* END create employees $_POST section *********************/
		showHeader("Create an Employee Record");
?>
	<section id="newEmployeeInfo" class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h1 class="center">New Employee Added!</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<p>Employee Name: <?=$firstName?> <?=$lastName?></p>
				<p>Address 1: <?=$addr1?></p>
				<p>Address 2: <?php if(isset($addr2)){ echo $addr2; }?></p>
				<p>City: <?=$city?></p>
				<p>State: <?=$state?></p>
				<p>Zip: <?=$zip?></p>
				<p>Employee Phone: <?=$phone?></p>
				<p>Email: <?=$email?></p>
				<p>Bat ID: <?=$batId?></p>
				<p>Active: Yes</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a class="btn btn-primary" href="employees.php">Return to Employees List</a>
			</div>
		</div>
		<div id="createAnother" class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a href="employees.php?create=true" class="btn btn-default">Create New Employee</a>
			</div>
		</div>
	</section>
<?php
	} elseif(isset($_POST['editSubmit'])){
		/* edit employees $_POST section *********************/
		// set post variables
		$id = $_POST['id'];
		$firstName = $_POST['firstName'];
		$lastName = $_POST['lastName'];
		$addr1 = $_POST['addr1'];
		$addr2 = ($_POST['addr2']) ? $_POST['addr2'] : '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$phone = $_POST['phone'];
		$email = $_POST['email'];
		$ssn = $_POST['ssn'];
		$batId = $_POST['batId'];
		$dob = $_POST['dob'];
		if(isset($_POST['active']) && $_POST['active'] == 'on'){
			$active = 1;
		} else {
			$active = 0;
		}

		// SQL statement - use PDO::prepare() when possible
		$sql = "UPDATE employees SET first=:first,
					last=:last,
					addr1=:addr1,
					addr2=:addr2,
					city=:city,
					state=:state,
					zip=:zip,
					phone=:phone,
					email=:email,
					ssn=:ssn,
					bat_id=:batId,
					dob=:dob,
					active=:active
					WHERE id=:id";
		
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':first', $firstName, PDO::PARAM_STR);
		$stmt->bindParam(':last', $lastName, PDO::PARAM_STR);
		$stmt->bindParam(':addr1', $addr1, PDO::PARAM_STR);
		$stmt->bindParam(':addr2', $addr2, PDO::PARAM_STR);
		$stmt->bindParam(':city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':state', $state, PDO::PARAM_STR);
		$stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
		$stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':ssn', $ssn, PDO::PARAM_STR);
		$stmt->bindParam(':batId', $batId, PDO::PARAM_STR);
		$stmt->bindParam(':dob', $dob, PDO::PARAM_STR);
		$stmt->bindParam(':active', $active, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		// run the query to update a employee record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
		showHeader("Edit an Employee Record");
?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h1>Employee Record Updated</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<p>First Name: <?=$firstName?></p>
				<p>Last Name: <?=$lastName?></p>
				<p>Address 1: <?=$addr1?></p>
				<p>Address 2: <?php if(isset($addr2)){ echo $addr2; }?></p>
				<p>City: <?=$city?></p>
				<p>State: <?=$state?></p>
				<p>Zip: <?=$zip?></p>
				<p>Employee Phone: <?=$phone?></p>
				<p>Email: <?=$email?></p>
				<p>SSN: <?=$ssn?></p>
				<p>Bat ID: <?=$batId?></p>
				<p>DOB: <?=$dob?></p>
				<p>Active: Yes</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10"><a class="btn btn-primary" href="employees.php">Return to Employees List</a></div>
		</div>
		<div id="createAnother" class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a href="employees.php?create=true" class="btn btn-default">Create New Employee</a>
			</div>
		</div>
	</section>
<?php
	/* END edit employees $_POST section *********************/
	} elseif(isset($_GET['create'])){
	/* create employees page section *********************/
		showHeader("Create an Employee Record");
?>
	<section id="employees" class="employees container-fluid">
		<h1 class="text-center">Create a New Employee Record</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="first" class="form-control" type="text" placeholder="First Name" required>
					<input id="" name="last" class="form-control" type="text" placeholder="Last Name" required>
					<input id="" name="addr1" class="form-control" type="text" placeholder="Address 1" required>
					<input id="" name="addr2" class="form-control" type="text" placeholder="Address 2">
					<input id="city" name="city" class="form-control" type="text" placeholder="City" required>
					<?php include_once('inc/states.inc.php'); //#state ?>
					<input id="zip" name="zip" class="form-control" type="number" placeholder="Zip" required>
					<input id="phone" name="phone" class="form-control" type="tel" placeholder="Employee Phone" required>
					<input id="email" name="email" class="form-control" type="email" placeholder="Email" required>
					<input id="batId" name="batId" class="form-control" type="number" placeholder="Bat ID" required>
					<input id="ssn" name="ssn" class="form-control" type="text" placeholder="SSN" required>
					<input id="dob" name="dob" class="form-control" type="date" placeholder="DOB" required>

					<div class="row">
						<input id="submit" class="form-control btn btn-primary col-md-6" name="createSubmit" type="submit" value="Submit">
						<a id="cancelBtn" class="form-control btn btn-default col-md-6" href="employees.php">Cancel</a>
					</div> <!-- END .row -->				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
/* END create employees page section *********************/
} elseif(isset($_GET['edit'])){
/* edit employees page section *********************/
$id = htmlspecialchars($_GET['id']);
$sql = "SELECT * FROM employees WHERE id=$id";
$q = $conn->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);
$r = $q->fetch();
showHeader("Edit an Employee Record");
?>
	<section id="editEmployee" class="employees container-fluid">
		<h1 class="text-center">Edit an Employee Record</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="firstName" name="firstName" class="form-control" type="text" placeholder="First Name" value="<?php if(isset($r['first'])){ echo $r['first'];}?>" required>
					<input id="lastName" name="lastName" class="form-control" type="text" placeholder="Last Name" value="<?php if(isset($r['last'])){ echo $r['last'];}?>" required>
					<input id="addr1" name="addr1" class="form-control" type="text" placeholder="Address 1" value="<?php if(isset($r['addr1'])){ echo $r['addr1'];}?>" required>
					<input id="addr2" name="addr2" class="form-control" type="text" placeholder="Address 2" value="<?php if(isset($r['addr2'])){ echo $r['addr2'];}?>">
					<input id="city" name="city" class="form-control" type="text" placeholder="City" value="<?php if(isset($r['city'])){ echo $r['city'];}?>" required>
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" class="form-control" type="number" placeholder="Zip" value="<?php if(isset($r['zip'])){ echo $r['zip'];}?>" required>
					<input id="phone" name="phone" class="form-control" type="tel" placeholder="Employee Phone" value="<?php if(isset($r['phone'])){ echo $r['phone'];}?>" required>
					<input id="email" name="email" class="form-control" type="email" placeholder="Email" value="<?php if(isset($r['email'])){ echo $r['email'];}?>" required>
					<input id="ssn" name="ssn" class="form-control" type="text" placeholder="SSN" value="<?php if(isset($r['ssn'])){ echo $r['ssn'];}?>" required>
					<input id="batId" name="batId" class="form-control" type="number" placeholder="Bat ID" value="<?php if(isset($r['bat_id'])){ echo $r['bat_id'];}?>" required>
					<input id="dob" name="dob" class="form-control" type="date" value="<?php if(isset($r['dob'])){ echo $r['dob'];}?>" required>
					<input name="id" class="form-control" type="hidden" value="<?=$id?>">
					<label id="lActive" for="active"><input id="active" name="active" type="checkbox" <?php if($r['active'] == "1"){ echo "checked"; } ?>> Active</label>
					
					<div class="row">
						<input id="submit" class="form-control btn btn-primary col-md-6" name="editSubmit" type="submit" value="Submit">
						<a id="cancelBtn" class="form-control btn btn-default col-md-6" href="employees.php">Cancel</a>
					</div> <!-- END .row -->
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
	</section>
<?php
/* END edit employees page section *********************/
} elseif(isset($_POST['inactivateSubmit'])){
/* show inactivate employees page (code to inactivate selected employees) section ********************/
	$sql = "UPDATE employees SET active = false WHERE id=:id";
	$stmt = $conn->prepare($sql);
	
	$list = $_POST['iList'];
	$listArray = explode(",", $list);

	foreach($listArray as $id){
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		// run the query to make an employee inactive
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
	} // END foreach()
		showHeader("Inactivate an Employee Record");
?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<p>The following employees were inactivated:</p>	
			</div>
		</div>
		<table id="inactivatedTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip Code</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Bat ID</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql = "SELECT * FROM employees WHERE id IN (". $list .") ORDER BY last";

	$stmt = $conn->prepare($sql);
	// run the query to list all employees that just became inactive
	try{
		$stmt->execute();
		$employees = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}

	foreach($employees as $c){
?>
				<tr>
					<td><?=htmlspecialchars("$c[first]")?></td>
					<td><?=htmlspecialchars("$c[last]")?></td>
					<td><?=htmlspecialchars("$c[addr1]")?>
					<?php if(isset($c['addr2'])){ ?>
					<br><?=htmlspecialchars("$c[addr2]")?>
					<?php } ?></td>
					<td><?=htmlspecialchars("$c[city]")?></td>
					<td><?=htmlspecialchars("$c[state]")?></td>
					<td><?=htmlspecialchars("$c[zip]")?></td>
					<td><a href="tel:<?=htmlspecialchars("$c[phone]")?>" class="phoneLink"><?=htmlspecialchars("$c[phone]")?></a></td>
					<td><a href="mailto:<?=htmlspecialchars("$c[email]")?>" class="emailLink"><?=htmlspecialchars("$c[email]")?></a></td>
					<td><?=htmlspecialchars("$c[bat_id]")?></td>
				</tr>
<?php
	}
?>
			</tbody>
		</table>
	</section>
	<div class="row">
		<div class="col-md-2 col-md-offset-1">
			<a class="btn btn-primary" href="employees.php">Return to Employees List</a>
		</div>
		<div class="col-md-9">
			<a href="employees.php?create=true" class="btn btn-default">Create New Employee</a>	
		</div>
	</div>


<?php
/* END inactivate employees page (code to inactivate selected employees) section *********************/
} elseif(isset($_GET['inactive'])){
/* show inactive employees page section *********************/
	$sql = "SELECT * FROM employees ORDER BY last";
	$q = $conn->prepare($sql);

	// run the query to get all employee records
	try{
		$q->execute();		
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}
	$employees = $q->fetchAll(PDO::FETCH_ASSOC);
	showHeader("Inactivate an Employee Record");
?>
	<section id="allEmployees" class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				<a href="employees.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
			</div>
			<div class="col-md-8">
				<h1 class="text-center">All Employees</h1>
			</div>
			<div class="col-md-2">
				<a id="topNew" class="btn btn-primary addNew" href="employees.php?create=true">Add New</a>
				<form id="inactivateForm" action="employees.php?inactivate=true" method="post">
					<input id="iList" name="iList" type="hidden" value="">
					<input id="topInactive" name="inactivateSubmit" type="submit" class="btn btn-danger inactivate" value="Inactivate">
				</form>
			</div>
		</div> <!-- .row -->
		<table id="employeesTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th><label for="checkAll"><input id="checkAll" name="checkAll" type="checkbox"><small>Check All</small></label></th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip Code</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Bat ID</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// iterate over the $employees results and display them in the table
				foreach($employees as $e){
					if($e['active'] == "0"){
						echo "<tr class='warning'>";
					} else {
						echo "<tr>";
					} ?>
					<td><input id="<?=htmlspecialchars("$e[id]")?>" class="toRemove" name="toRemove" type="checkbox"></td>
					<td><?=htmlspecialchars("$e[first]")?></td>
					<td><?=htmlspecialchars("$e[last]")?></td>
					<td><?=htmlspecialchars("$e[addr1]")?>
					<?php if(isset($e['addr2'])){ ?>
					<br><?=htmlspecialchars("$e[addr2]")?>
					<?php } ?></td>
					<td><?=htmlspecialchars("$e[city]")?></td>
					<td><?=htmlspecialchars("$e[state]")?></td>
					<td><?=htmlspecialchars("$e[zip]")?></td>
					<td><a href="tel:<?=htmlspecialchars("$e[phone]")?>" class="phoneLink"><?=htmlspecialchars("$e[phone]")?></a></td>
					<td><a href="mailto:<?=htmlspecialchars("$e[email]")?>" class="emailLink"><?=htmlspecialchars("$e[email]")?></a></td>
					<td><?=htmlspecialchars("$e[bat_id]")?></td>
					<td><a title="Edit" href="employees.php?edit=true&id=<?=$e['id'];?>" class="btn btn-success">Edit</a></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<a id="bottomNew" class="btn btn-primary addNew" href="employees.php?create=true">Add New</a>
				<input id="bottomInactive" type="button" class="btn btn-danger inactivate" value="Inactivate">	
			</div>
		</div> <!-- .row -->
	</section>
<?php
/* END show inactive employees page section *********************/
} else { 
/* entire list of active employees page section *********************/
	$sql = "SELECT * FROM employees WHERE active=true ORDER BY last";
	// run the query to get all employee records that are active employees
	$q = $conn->prepare($sql);

	try{
		$q->execute();
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}
	$employees = $q->fetchAll(PDO::FETCH_ASSOC);

	showHeader("Active Employee Records");
?>
	<section id="allEmployees" class="container-fluid">
		<div class="row">
			<div class="col-md-2">
				<a href="employees.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
			</div>
			<div class="col-md-8">
				<h1 class="text-center">All Employees</h1>
			</div>
			<div class="col-md-2">
				<a id="topNew" class="btn btn-primary addNew" href="employees.php?create=true">Add New</a>
				<form id="inactivateForm" action="?" method="post">
					<input id="iList" name="iList" type="hidden" value="">
					<input id="topInactive" name="inactivateSubmit" type="submit" class="btn btn-danger inactivate" value="Inactivate">
				</form>
			</div>
		</div> <!-- .row -->
		<table id="employeesTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th><label for="checkAll"><input id="checkAll" name="checkAll" type="checkbox"><small>Check All</small></label></th>
					<th>First Name</th>
					<th>Last Name</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip Code</th>
					<th>Phone</th>
					<th>Email</th>
					<th>Bat ID</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php
				// iterate over the $employees results and display them in the table
				foreach($employees as $e){
				?>
				<tr>
					<td><input id="<?=htmlspecialchars("$e[id]")?>" class="toRemove" name="toRemove" type="checkbox"></td>
					<td><?=htmlspecialchars("$e[first]")?></td>
					<td><?=htmlspecialchars("$e[last]")?></td>
					<td><?=htmlspecialchars("$e[addr1]")?>
					<?php if(isset($e['addr2'])){ ?>
					<br><?=htmlspecialchars("$e[addr2]")?>
					<?php } ?></td>
					<td><?=htmlspecialchars("$e[city]")?></td>
					<td><?=htmlspecialchars("$e[state]")?></td>
					<td><?=htmlspecialchars("$e[zip]")?></td>
					<td><a href="tel:<?=htmlspecialchars("$e[phone]")?>" class="phoneLink"><?=htmlspecialchars("$e[phone]")?></a></td>
					<td><a href="mailto:<?=htmlspecialchars("$e[email]")?>" class="emailLink"><?=htmlspecialchars("$e[email]")?></a></td>
					<td><?=htmlspecialchars("$e[bat_id]")?></td>
					<td><a title="Edit" href="employees.php?edit=true&id=<?=$e['id'];?>" class="btn btn-success">Edit</a></td>
				</tr>
				<?php
				}
				?>
			</tbody>
		</table>
		<div class="row">
			<div class="col-md-10"></div>
			<div class="col-md-2">
				<a id="bottomNew" class="btn btn-primary addNew" href="employees.php?create=true">Add New</a>			
				<input id="bottomInactive" type="button" class="btn btn-danger inactivate" value="Inactivate">			
			</div>
		</div> <!-- .row -->

	</section>
<?php
/* END entire list of active employees page section *********************/
}
// include_once('inc/footer.inc.php');
showFooter();
?>