<?php
// This script is meant to allow admin users to validate that someone shoud have 
// access before granting access
require_once('inc/startsession.php');
require_once('inc/common.inc.php');
require_once('inc/conn.inc.php');

if(isset($_POST['approve'])){
	$postMail = $_POST['postMail'];
	$person = $_POST['person'];
	$sql = "UPDATE login SET active=1 WHERE email=:email";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':email', $postMail, PDO::PARAM_STR);
	// run the query to update the reocrd
	try{
		$stmt->execute();
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}
	showHeader("Access Approved");
?>
		<section class="container-fluid">
			<div class="row">
				<h1 class="col-md-3">Access Approved</h1>
				<div class="col-md-9"></div>
			</div>

<?php
	// send the email to the user to let them know that they have been granted access.
	$msg = "<p><?=$person?> has been approved for admin access. An email has be sent to notify them as well.</p>";
	$err = "<p class='alert alert-danger'>The email could not be submitted. Please try again later or speak to the site administrator about this error.</p>";
	// @TODO return to login page
	$mail = accessApprovalNotice($person, $postMail);	
?>
			<div class="row">
				<div class="col-md-12">
					<?php echo ($mail) ? $msg : $err; ?>
				</div>
			</div>
		</section>
<?php
} elseif(isset($_GET['email'])){
	$getEmail = $_GET['email'];

	// query the database to find if the email exists in the employees table
	// and to get some extra information.
	$sql = "SELECT first, last, phone, email, active FROM employees WHERE email=:email";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':email', $getEmail, PDO::PARAM_STR);
	// run the query to insert a new company record
	try{
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ); // should only be one record
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}

	// display the page header
	showHeader("Grant Access");
	?>
	// this part needs to show regardless if a row was found in the DB
		<section class="container-fluid">
			<div class="row">
				<h1 class="col-md-3">Grant Access</h1>
				<div class="col-md-9"></div>
			</div>
			<div class="row">
				<div class="col-md-12">
	<?php
	if($row){ // if a record was found with that email
	// set variables
	$name = $row->first . ' ' . $row->last;
	$phone = $row->phone;
	$email = $row->email;
	?>

					<p>There is a request for access from <?=$name?>. They are found in the company database. Do you want to approve this request for admin access? If not, just leave the page and you do not need to confirm them.</p>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<p><?=$name?><br>
						<?=$phone?><br>
						<?=$email?></p>
				</div>
			</div>
			<form class="form-inline container-fluid" action="?" method="post">
				<div class="form-group">
					<input class="btn btn-primary" type="submit" name="approve" value="Approve">
					<input type="hidden" name="postMail" value="<?=$getEmail?>">
					<input type="hidden" name="person" value="<?=$name?>">
				</div>
			</form>
		</section>
	<?php
	} else { // end if($row)
	?>
					<p>Either this email - <strong><?=$getEmail?></strong> - was not found in the database, or something else went wrong. Please speak to the site administrator to review what went wrong.</p>
				</div>
			</div>
		</section>
	<?php
	} // end else
}
showFooter();
?>

