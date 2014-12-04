<?php
	include_once('inc/header.inc.php');
	if(isset($_POST['submit'])){

	} elseif(isset($_GET['create'])){
?>
	<section id="employees" class="employees">
		<h1 class="text-center">Create a New Employee Record</h1>
		<form id="employeeForm" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="name" type="text" placeholder="Employee Name">
					<input id="" name="addr1" type="text" placeholder="Employee Address 1">
					<input id="" name="addr2" type="text" placeholder="Employee Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="phone" name="phone" type="tel" placeholder="Employee Phone">
					<input type="email" id="email" placeholder="Email">

					<input id="submit" class="btn btn-primary" name="submit" type="submit" value="Submit">
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
					<input id="" name="name" type="text" placeholder="Employee Name">
					<input id="" name="addr1" type="text" placeholder="Employee Address 1">
					<input id="" name="addr2" type="text" placeholder="Employee Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="" name="phone" type="tel" placeholder="Employee Phone">
					<input id="email" name="email" type="email" placeholder="Email">					
					
					<input id="submit" class="btn btn-primary" name="submit" type="submit" value="Submit">
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