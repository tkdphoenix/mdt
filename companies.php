<?php
	include_once('inc/header.inc.php');
	require_once('inc/conn.inc.php');
	if(isset($_POST['createSubmit'])){
		/* create companies $_POST section *********************/
		// set post variables
		$company_name = $_POST['company_name'];
		$addr1 = $_POST['addr1'];
		$addr2 = ($_POST['addr2']) ? $_POST['addr2'] : '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$company_phone = $_POST['company_phone'];
		$company_der = $_POST['company_der'];
		$additional_phone = ($_POST['additional_phone']) ? $_POST['additional_phone'] : '';
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
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
		/* END create companies $_POST section *********************/
?>

<?php
	} elseif(isset($_POST['editSubmit'])){
		/* edit companies $_POST section *********************/
		// set post variables
		$id = $_POST['id'];
		$company_name = $_POST['company_name'];
		$addr1 = $_POST['addr1'];
		$addr2 = ($_POST['addr2']) ? $_POST['addr2'] : '';
		$city = $_POST['city'];
		$state = $_POST['state'];
		$zip = $_POST['zip'];
		$company_phone = $_POST['company_phone'];
		$company_der = $_POST['company_der'];
		$additional_phone = ($_POST['additional_phone']) ? $_POST['additional_phone'] : '';
		$email = $_POST['email'];

		// SQL statement - use PDO::prepare() when possible
		$sql = "UPDATE companies SET company_name=:company_name,
					addr1=:addr1,
					addr2=:addr2,
					city=:city,
					state=:state,
					zip=:zip,
					company_phone=:company_phone,
					company_der=:company_der,
					additional_phone=:additional_phone,
					email=:email
					WHERE id=:id";
		
		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':company_name', $company_name, PDO::PARAM_STR);
		$stmt->bindParam(':addr1', $addr1, PDO::PARAM_STR);
		$stmt->bindParam(':addr2', $addr2, PDO::PARAM_STR);
		$stmt->bindParam(':city', $city, PDO::PARAM_STR);
		$stmt->bindParam(':state', $state, PDO::PARAM_STR);
		$stmt->bindParam(':zip', $zip, PDO::PARAM_STR);
		$stmt->bindParam(':company_phone', $company_phone, PDO::PARAM_STR);
		$stmt->bindParam(':additional_phone', $additional_phone, PDO::PARAM_STR);
		$stmt->bindParam(':company_der', $company_der, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		// run the query to insert a new company record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
	/* END edit companies $_POST section *********************/
	} elseif(isset($_GET['create'])){
	/* create companies page section *********************/
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
/* END create companies page section *********************/
} elseif(isset($_GET['edit'])){
/* edit companies page section *********************/
$id = htmlspecialchars($_GET['id']);
$sql = "SELECT * FROM companies WHERE id=$id";
$q = $conn->query($sql);
$q->setFetchMode(PDO::FETCH_ASSOC);
$r = $q->fetch();
?>
	<section id="editCompany" class="companies">
		<h1 class="text-center">Edit a Company</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="company_name" name="company_name" type="text" placeholder="Company Name" value="<?php if(isset($r['company_name'])){ echo $r['company_name'];}?>">
					<input id="addr1" name="addr1" type="text" placeholder="Company Address 1" value="<?php if(isset($r['addr1'])){ echo $r['addr1'];}?>">
					<input id="addr2" name="addr2" type="text" placeholder="Company Address 2" value="<?php if(isset($r['addr2'])){ echo $r['addr2'];}?>">
					<input id="city" name="city" type="text" placeholder="City" value="<?php if(isset($r['city'])){ echo $r['city'];}?>">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" name="zip" type="number" placeholder="Zip" value="<?php if(isset($r['zip'])){ echo $r['zip'];}?>">
					<input id="company_phone" name="company_phone" type="tel" placeholder="Company Phone" value="<?php if(isset($r['company_phone'])){ echo $r['company_phone'];}?>">
					<input id="additional_phone" name="additional_phone" type="tel" placeholder="Additional Phone" value="<?php if(isset($r['additional_phone'])){ echo $r['additional_phone'];}?>">
					<input id="company_der" name="company_der" type="text" placeholder="Company DER" value="<?php if(isset($r['company_der'])){ echo $r['company_der'];}?>">
					<input id="email" name="email" type="email" placeholder="Email" value="<?php if(isset($r['email'])){ echo $r['email'];}?>">
					<input name="id" type="hidden" value="<?=$id?>">
					
					<input id="submit" class="btn btn-primary" name="editSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
/* END edit companies page section *********************/
} elseif(isset($_GET['inactive'])){
/* show inactive companies page section *********************/

	$sql = "SELECT * FROM companies";
	// run the query to insert a new company record
	try{
		$q = $conn->query($sql);
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}
	$companies = $q->fetchAll(PDO::FETCH_ASSOC);
?>
	<section id="allCompanies">
		<div class="row">
			<div class="col-md-2">
				<a href="companies.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
			</div>
			<div class="col-md-8">
				<h1 class="text-center">All Companies</h1>
			</div>
			<div class="col-md-2">
				<a id="topNew" class="btn btn-primary addNew" href="companies.php?create=true">Add New</a>
				<input id="topInactive" type="button" class="btn btn-danger inactivate" value="Inactivate">
			</div>
		</div> <!-- .row -->
		<table id="companiesTable" class="table table-hover">
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
				?>
				<tr>
					<td><input name="toRemove" type="checkbox"></td>
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
/* END show inactive companies page section *********************/
} else { 
/* entire list of active companies page section *********************/
	$sql = "SELECT * FROM companies WHERE active=true";
	// run the query to insert a new company record
	try{
		$q = $conn->query($sql);
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}
	$companies = $q->fetchAll(PDO::FETCH_ASSOC);
?>
	<section id="allCompanies">
		<div class="row">
			<div class="col-md-2">
				<a href="companies.php?inactive=true" id="showInactive" class="btn btn-primary showInactive">Show Inactive</a>
			</div>
			<div class="col-md-8">
				<h1 class="text-center">All Companies</h1>
			</div>
			<div class="col-md-2">
				<a id="topNew" class="btn btn-primary addNew" href="companies.php?create=true">Add New</a>
				<input id="topInactive" type="button" class="btn btn-danger inactivate" value="Inactivate">
			</div>
		</div> <!-- .row -->
		<table id="companiesTable" class="table table-hover">
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
				?>
				<tr>
					<td><input name="toRemove" type="checkbox"></td>
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
/* END entire list of active companies page section *********************/
}
include_once('inc/footer.inc.php');
?>