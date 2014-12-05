<?php
	include_once('inc/header.inc.php');
	require_once('inc/conn.inc.php');
	if(isset($_POST['createSubmit'])){
		// set post variables
		$company_name = $_POST['company_name'];
		$addr1 = $_POST['addr1'];
		$addr2 = $_POST['addr2'] || '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$company_phone = $_POST['company_phone'];
		$company_der = $_POST['company_der'];
		$additional_phone = $_POST['additional_phone'] || '';
		$email = $_POST['email'];

		// SQL statement - use PDO::prepare() when possible
		$sql = "INSERT INTO companies(company_name,
					addr1,
					addr2,
					city,
					state,
					zip,
					company_phone,
					company_der,
					additional_phone,
					email) VALUES (
					:company_name,
					:addr1,
					:addr2,
					:city,
					:state,
					:zip,
					:company_phone,
					:company_der,
					:additional_phone,
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
			echo $e->getMessage();
			echo "<br> query failed <br>";
		}

		if(!$conn){ echo "connection failed"; } else { echo "Yay, connection!<br>"; }

?>

<?php
	} elseif(isset($_POST['editSubmit'])){

	} elseif(isset($_GET['create'])){
?>
	<section id="companies" class="companies">
		<h1 class="text-center">Create a New Company</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="company_name" type="text" placeholder="Company Name">
					<input id="" name="addr1" type="text" placeholder="Company Address 1">
					<input id="" name="addr2" type="text" placeholder="Company Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="phone" name="company_phone" type="tel" placeholder="Company Phone">
					<input id="additional_phone" name="additional_phone" type="tel" placeholder="Additional Phone">
					<input id="DER" name="company_der" type="text" placeholder="Company DER">
					<input id="email" name="email" type="email" placeholder="Email">

					<input id="submit" class="btn btn-primary" name="createSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
} elseif(isset($_GET['edit'])){
?>
	<section id="editCompany" class="companies">
		<h1 class="text-center">Edit a Company</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="name" type="text" placeholder="Company Name">
					<input id="" name="addr1" type="text" placeholder="Company Address 1">
					<input id="" name="addr2" type="text" placeholder="Company Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="" name="phone" type="tel" placeholder="Company Phone">
					<input id="" name="der" type="text" placeholder="Company DER">
					<input id="email" name="email" type="email" placeholder="Email">					
					
					<input id="submit" class="btn btn-primary" name="editSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
} else { // default is to show all current companies
?>
<section id="allCompanies">
	<div class="row">
		<div class="col-md-10">
			<h1 class="text-center">All Companies</h1>
		</div>
		<div class="col-md-2">
			<input id="topBtn" type="button" class="btn btn-danger deleteBtn" value="Inactivate">
		</div>
	</div> <!-- .row -->
	<table id="companiesTable" class="table">
		<tr>
			<th><label for="checkAll"><input id="checkAll" name="checkAll" type="checkbox"><small>Check All</small></label></th>
			<th>Name</th>
			<th>Address</th>
			<th>City</th>
			<th>State</th>
			<th>Zip Code</th>
			<th>Phone</th>
			<th>DER</th>
			<th>Email</th>
			<th>&nbsp;</th>
		</tr>
		<!-- insert companies from database here -->
		<tr>
			<td><input name="toRemove" type="checkbox"></td>
			<td>Janet's Dry Cleaning</td>
			<td>111 Main St.</td>
			<td>Chandler</td>
			<td>AZ</td>
			<td>85225</td>
			<td><a href="tel:480-555-1234">480-555-1234</td>
			<td>Bill Smith</td>
			<td><a href="mailto:bill.smith@someplace.com">bill.smith@someplace.com</a></td>
			<td><input type="button" class="btn btn-success" value="Edit"></td>
		</tr>
		<tr>
			<td><input name="toRemove" type="checkbox"></td>
			<td>Fred's Electric Company</td>
			<td>222 S. Sparrow St.</td>
			<td>Chandler</td>
			<td>AZ</td>
			<td>85225</td>
			<td><a href="tel:480-555-7777">480-555-7777</td>
			<td>Fred Jones</td>
			<td><a href="mailto:fred.jones@someplace.com">fred.jones@someplace.com</a></td>
			<td><input type="button" class="btn btn-success" value="Edit"></td>
		</tr>
		<tr>
			<td><input name="toRemove" type="checkbox"></td>
			<td>Hank's Bait &amp; Tackle</td>
			<td>135 Dock St.</td>
			<td>Chandler</td>
			<td>AZ</td>
			<td>85225</td>
			<td><a href="tel:480-555-9999">480-555-9999</td>
			<td>Hank Johansen</td>
			<td><a href="mailto:hank.johansen@someplace.com">hank.johansen@someplace.com</a></td>
			<td><i class="icon-pencil"></i></td>
		</tr>
	</table>
	<div class="row">
		<div class="col-md-10"></div>
		<div class="col-md2">
			<input id="bottomBtn" type="button" class="btn btn-danger deleteBtn" value="Inactivate">			
		</div>
	</div> <!-- .row -->

</section>

<?php
}
include_once('inc/footer.inc.php');
?>