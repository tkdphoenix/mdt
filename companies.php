<?php
	include_once('inc/header.inc.php');
	require_once('inc/conn.inc.php');
	if(isset($_POST['createSubmit'])){

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

		$sql = "INSERT INTO companies(".
			"company_name,".
		    "addr1,".
		    "addr2,".
		    "city,".
		    "state,".
		    "zip,".
		    "company_phone,".
		    "company_der,".
		    "additional_phone,".
		    "email".
		") VALUES (".
			"'$company_name',".
		    "'$addr1',".
		    "'$addr2',".
		    "'$city',".
		    "'$state',".
		    "'$zip',".
		    "'$company_phone',".
		    "'$company_de'r".
		    "'$additional_phone',".
		    "'$email',".
		")";
		try{
			$result = $conn->query($sql);
		} catch(PDOException $e){
			echo $e->getMessage();
		}
	} elseif(isset($_POST['editSubmit'])){

	} elseif(isset($_GET['create'])){
?>
	<section id="companies" class="companies">
		<h1 class="text-center">Create a New Company</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" name="name" type="text" placeholder="Company Name">
					<input id="" name="addr1" type="text" placeholder="Company Address 1">
					<input id="" name="addr2" type="text" placeholder="Company Address 2">
					<input id="city" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip">
					<input id="phone" name="phone" type="tel" placeholder="Company Phone">
					<input id="DER" name="der" type="text" placeholder="Company DER">
					<input type="email" id="email" placeholder="Email">

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
	<h1 class="text-center">All Companies</h1>
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
			<td><input type="button" class="btn btn-success" value="Edit"></td>
		</tr>

	</table>
</section>

<?php
}
include_once('inc/footer.inc.php');
?>