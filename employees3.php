<?php
	include_once('inc/header.inc.php');
	require_once('inc/conn.inc.php');
	/* create employee $_POST section *********************/
	if(isset($_POST['createSubmit'])){
		// set post variables
		$employee_name = $_POST['employee_name'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'] || '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$employee_phone = $_POST['employee_phone'];
		$email = $_POST['email'];

		// SQL statement - use PDO::prepare() when possible
		$sql = "INSERT INTO companies(first,
			last,
			addr1,
			addr2,
			city,
			state,
			zip,
			phone,
			email,
			ssn,
			dob) VALUES (
			:employee_name,
			:addr1,
			:addr2,
			:city,
			:state,
			:zip,
			:employee_phone,
			:email)";
		
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
		$stmt->bindParam(':addr1', $addr1, PDO::PARAM_STR);
		$stmt->bindParam(':addr2', $addr2, PDO::PARAM_STR);
		$stmt->bindParam(':city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':state', $state, PDO::PARAM_STR);
		$stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
		$stmt->bindParam(':company_phone', $company_phone, PDO::PARAM_STR);
		$stmt->bindParam(':company_der', $company_der, PDO::PARAM_STR);
		$stmt->bindParam(':additional_phone', $additional_phone, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		// run the query to insert a new company record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
	/* END create employee $_POST section *********************/
	} elseif(isset($_POST['editSubmit'])){
	/* edit employee $_POST section *********************/
		// set post variables
		$employee_name = $_POST['employee_name'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'] || '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$employee_phone = $_POST['employee_phone'];
		$email = $_POST['email'];

		// SQL statement - use PDO::prepare() when possible
		$sql = "INSERT INTO companies(first,
			last,
			addr1,
			addr2,
			city,
			state,
			zip,
			phone,
			email,
			ssn,
			dob) VALUES (
			:employee_name,
			:addr1,
			:addr2,
			:city,
			:state,
			:zip,
			:employee_phone,
			:email)";
		
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
		$stmt->bindParam(':addr1', $addr1, PDO::PARAM_STR);
		$stmt->bindParam(':addr2', $addr2, PDO::PARAM_STR);
		$stmt->bindParam(':city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':state', $state, PDO::PARAM_STR);
		$stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
		$stmt->bindParam(':company_phone', $company_phone, PDO::PARAM_STR);
		$stmt->bindParam(':company_der', $company_der, PDO::PARAM_STR);
		$stmt->bindParam(':additional_phone', $additional_phone, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		// run the query to insert a new company record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
	/* END edit employee $_POST section *********************/
	} elseif(isset($_GET['create'])){
?>
	<section id="employees" class="employees">
		<h1 class="text-center">Create a New Employee Record</h1>
		<form id="employeeForm" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="employee_name" type="text" placeholder="Employee Name">
					<input id="" name="addr1" type="text" placeholder="Employee Address 1">
					<input id="" name="addr2" type="text" placeholder="Employee Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="phone" name="employee_phone" type="tel" placeholder="Employee Phone">
					<input type="email" id="email" placeholder="Email">

					<input id="submit" class="btn btn-primary" name="createSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
} elseif(isset($_GET['edit'])){
?>
	<section id="editEmployee" class="employees">
		<h1 class="text-center">Edit an Employee Record</h1>
		<form id="employeeForm" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="employee_name" type="text" placeholder="Employee Name">
					<input id="" name="addr1" type="text" placeholder="Employee Address 1">
					<input id="" name="addr2" type="text" placeholder="Employee Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="" name="employee_phone" type="tel" placeholder="Employee Phone">
					<input id="email" name="email" type="email" placeholder="Email">					
					
					<input id="submit" class="btn btn-primary" name="editSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
} else { // default is to show all current companies
?>
<section id="allEmployees">
	<h1 class="text-center">All Employees</h1>
	<table id="employeesTable" class="table">
		<tr>
			<th><label for="checkAll"><input id="checkAll" name="checkAll" type="checkbox"><small>Check All</small></label></th>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip Code</th>
			<th>Phone</th>
			<th>DOB</th>
			<th>SSN</th>
			<th>Email</th>
			<th>Active</th>
			<th>&nbsp;</th>
		</tr>
		<!-- insert companies from database here -->
		<tr>
			<td><input name="toRemove" type="checkbox"></td>
			<td>Joel Grissom</td>
			<td>111 Main St.</td>
			<td>Chandler</td>
			<td>AZ</td>
			<td>85225</td>
			<td><a href="tel:480-555-1234">480-555-1234</td>
			<td>12/18/1973</td>
			<td>555-12-3456</td>
			<td><a href="mailto:bill.smith@someplace.com">bill.smith@someplace.com</a></td>
			<td>Yes</td>
			<td><input type="button" class="btn btn-success" value="Edit"></td>
		</tr>
		<tr>
			<td><input name="toRemove" type="checkbox"></td>
			<td>Fred Flintstone</td>
			<td>222 S. Sparrow St.</td>
			<td>Chandler</td>
			<td>AZ</td>
			<td>85225</td>
			<td><a href="tel:480-555-7777">480-555-7777</td>
			<td>1/31/1942</td>
			<td>648-88-1234</td>
			<td><a href="mailto:fred.jones@someplace.com">fred.jones@someplace.com</a></td>
			<td>No</td>
			<td><input type="button" class="btn btn-success" value="Edit"></td>
		</tr>
		<tr>
			<td><input name="toRemove" type="checkbox"></td>
			<td>Janet Brush</td>
			<td>135 Dock St.</td>
			<td>Chandler</td>
			<td>AZ</td>
			<td>85225</td>
			<td><a href="tel:480-555-9999">480-555-9999</td>
			<td>1/1/1985</td>
			<td>444-33-2211</td>
			<td><a href="mailto:hank.johansen@someplace.com">hank.johansen@someplace.com</a></td>
			<td>Yes</td>
			<td><input type="button" class="btn btn-success" value="Edit"></td>
		</tr>

	</table>
</section>

<?php
}
include_once('inc/footer.inc.php');
?>