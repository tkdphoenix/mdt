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
		// @TODO write response to user to know that new company was added to DB
?>
	<section id="newCompanyInfo" class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h1 class="center">New Company Added!</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<p>Company Name: <?=$company_name?></p>
				<p>Address 1: <?=$addr1?></p>
				<p>Address 2: <?php if(isset($addr2)){ echo $addr2; }?></p>
				<p>City: <?=$city?></p>
				<p>State: <?=$state?></p>
				<p>Zip: <?=$zip?></p>
				<p>Company Phone: <?=$company_phone?></p>
				<p>Additional Phone: <?=$additional_phone?></p>
				<p>Company DER: <?=$company_der?></p>
				<p>Email: <?=$email?></p>
				<p>Active: Yes</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a class="btn btn-primary" href="companies.php">Return to Companies List</a>
			</div>
		</div>
		<div id="createAnother" class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a href="companies.php?create=true" class="btn btn-default">Create New Company</a>
			</div>
		</div>
	</section>
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
		if(isset($_POST['active']) && $_POST['active'] == 'on'){
			$active = 1;
		} else {
			$active = 0;
		}

		// SQL statement - use PDO::prepare() when possible
		$sql = "UPDATE companies SET company_name=:company_name,
					addr1=:addr1,
					addr2=:addr2,
					city=:city,
					state=:state,
					zip=:zip,
					company_phone=:company_phone,
					additional_phone=:additional_phone,
					company_der=:company_der,
					email=:email,
					active=:active
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
		$stmt->bindParam(':active', $active, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_STR);
		// run the query to update a company record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
		}
		// @TODO write response to let user know info was updated
?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<h1>Company Updated</h1>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<p>Company Name: <?=$company_name?></p>
				<p>Address 1: <?=$addr1?></p>
				<p>Address 2: <?php if(isset($addr2)){ echo $addr2; }?></p>
				<p>City: <?=$city?></p>
				<p>State: <?=$state?></p>
				<p>Zip: <?=$zip?></p>
				<p>Company Phone: <?=$company_phone?></p>
				<p>Additional Phone: <?=$additional_phone?></p>
				<p>Company DER: <?=$company_der?></p>
				<p>Email: <?=$email?></p>
				<p>Active: Yes</p>
			</div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10"><a class="btn btn-primary" href="companies.php">Return to Companies List</a></div>
		</div>
		<div id="createAnother" class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<a href="companies.php?create=true" class="btn btn-default">Create New Company</a>
			</div>
		</div>
	</section>
<?php
	/* END edit companies $_POST section *********************/
	} elseif(isset($_GET['create'])){
	/* create companies page section *********************/
?>
	<section id="companies" class="companies container-fluid">
		<h1 class="text-center">Create a New Company</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="" class="form-control" name="company_name" type="text" placeholder="Company Name">
					<input id="" class="form-control" name="addr1" type="text" placeholder="Company Address 1">
					<input id="" class="form-control" name="addr2" type="text" placeholder="Company Address 2">
					<input id="city" class="form-control" name="city" type="text" placeholder="City">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" class="form-control" name="zip" type="number" placeholder="Zip">
					<input id="phone" class="form-control" name="company_phone" type="tel" placeholder="Company Phone">
					<input id="additional_phone" class="form-control" name="additional_phone" type="tel" placeholder="Additional Phone">
					<input id="DER" class="form-control" name="company_der" type="text" placeholder="Company DER">
					<input id="email" class="form-control" name="email" type="email" placeholder="Email">

					<input id="submit" class="form-control btn btn-primary" name="createSubmit" type="submit" value="Submit">
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
	<section id="editCompany" class="companies container-fluid">
		<h1 class="text-center">Edit a Company</h1>
		<form id="form1" class="form-inline container-fluid" action="?" method="post">
			<div class="row">
				<div id="leftCol" class="col-md-6">
					<input id="company_name" class="form-control" name="company_name" type="text" placeholder="Company Name" value="<?php if(isset($r['company_name'])){ echo $r['company_name'];}?>">
					<input id="addr1" class="form-control" name="addr1" type="text" placeholder="Company Address 1" value="<?php if(isset($r['addr1'])){ echo $r['addr1'];}?>">
					<input id="addr2" class="form-control" name="addr2" type="text" placeholder="Company Address 2" value="<?php if(isset($r['addr2'])){ echo $r['addr2'];}?>">
					<input id="city" class="form-control" name="city" type="text" placeholder="City" value="<?php if(isset($r['city'])){ echo $r['city'];}?>">
					
					<?php include_once('inc/states.inc.php'); //#state ?>

					<input id="zip" class="form-control" name="zip" type="number" placeholder="Zip" value="<?php if(isset($r['zip'])){ echo $r['zip'];}?>">
					<input id="company_phone" class="form-control" name="company_phone" type="tel" placeholder="Company Phone" value="<?php if(isset($r['company_phone'])){ echo $r['company_phone'];}?>">
					<input id="additional_phone" class="form-control" name="additional_phone" type="tel" placeholder="Additional Phone" value="<?php if(isset($r['additional_phone'])){ echo $r['additional_phone'];}?>">
					<input id="company_der" class="form-control" name="company_der" type="text" placeholder="Company DER" value="<?php if(isset($r['company_der'])){ echo $r['company_der'];}?>">
					<input id="email" class="form-control" name="email" type="email" placeholder="Email" value="<?php if(isset($r['email'])){ echo $r['email'];}?>">
					<input name="id" type="hidden" value="<?=$id?>">
					<label id="lActive" for="active"><input id="active" name="active" type="checkbox" <?php if($r['active'] == "1"){ echo "checked"; } ?>> Active</label>
					
					<input id="submit" class="form-control btn btn-primary" name="editSubmit" type="submit" value="Submit">
				</div> <!-- #leftCol -->
				
				<div id="rightCol" class="col-md-6"></div> <!-- #rightCol -->	
			</div> <!-- .row -->
		</form>
<?php
/* END edit companies page section *********************/
} elseif(isset($_POST['inactivateSubmit'])){
/* show inactivate companies page (code to inactivate selected companies) section ********************/
	$sql = "UPDATE companies SET active = false WHERE id=:id";
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
	// @TODO display message for user to know that "X" companies were inactivated
?>
	<section class="container-fluid">
		<div class="row">
			<div class="col-md-1"></div>
			<div class="col-md-11">
				<p>The following companies were inactivated:</p>	
			</div>
		</div>
		<table id="inactivatedTable" class="table table-hover table-responsive">
			<thead>
				<tr>
					<th>Name</th>
					<th>Address</th>
					<th>City</th>
					<th>State</th>
					<th>Zip Code</th>
					<th>Phone</th>
					<th>Additional Phone</th>
					<th>DER</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
<?php
	$sql = "SELECT * FROM companies WHERE id IN (". $list .") ORDER BY company_name";

	$stmt = $conn->prepare($sql);
	// $stmt->bindParam(':list', $list, PDO::PARAM_INT); 
	// run the query to list all companies that just became inactive
	try{
		$stmt->execute();
		$companies = $stmt->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}

	foreach($companies as $c){
?>
				<tr>
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
				</tr>
<?php
	}
?>
			</tbody>
		</table>
	</section>
	<div class="row">
		<div class="col-md-2 col-md-offset-1">
			<a class="btn btn-primary" href="companies.php">Return to Companies List</a>
		</div>
		<div class="col-md-9">
			<a href="companies.php?create=true" class="btn btn-default">Create New Company</a>	
		</div>
	</div>


<?php
/* END inactivate companies page (code to inactivate selected companies) section *********************/
} elseif(isset($_GET['inactive'])){
/* show inactive companies page section *********************/
	$sql = "SELECT * FROM companies ORDER BY company_name";
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
/* END show inactive companies page section *********************/
} else { 
/* entire list of active companies page section *********************/
	$sql = "SELECT * FROM companies WHERE active=true ORDER BY company_name";
	// run the query to get all company records that are active companies
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
				<form id="inactivateForm" action="companies.php" method="post">
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
				?>
				<tr>
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
/* END entire list of active companies page section *********************/
}
include_once('inc/footer.inc.php');
?>