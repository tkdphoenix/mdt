<?php
/**
  * To change passwords we will verify that the email they put in is to a current login record, 
  * and verify the email as well as requiring a confirmation password to test against.
  */
require_once('inc/startsession.inc.php');
require_once('inc/common.inc.php');
require_once('inc/conn.inc.php');
require_once('inc/checksession.inc.php');

$title = "Change Password";// function to display the form at various times
function showChangeForm($title, $error_msg = []){

	showHeader($title);
	// form contents here
?>
	<section>
		<div class="row">
			<div class="col-md-12">
				<h1><?=$title?></h1>
			</div>
		</div>
<?php
	if(!empty($error_msg)){
?>
		<div class="row">
			<div class="col-md-12">
<?php
		foreach($error_msg as $error){
?>
			<p class="alert alert-danger"><?=$error?></p>
<?php
		}
?>
			</div>
		</div>
<?php
	}
?>
		<div class="row">
			<div class="col-md-12">
				<p>Please submit your password change with your current email for verification.</p>
			</div>
		</div>
		<form action="?" method="post">
			<label for="email">Email <input type="email" name="email" value="<?php echo (isset($_POST['email']))? $_POST['email'] : ''; ?>" required></label>
			<label for="oldPwd">Old Password <input type="password" name="oldPwd" value="<?php echo (isset($_POST['oldPwd']))? $_POST['oldPwd'] : ''; ?>" required></label>
			<label for="newPwd">New Password <input type="password" name="newPwd" value="<?php echo (isset($_POST['newPwd']))? $_POST['newPwd'] : ''; ?>" required></label>
			<label for="newPwd">New Password Confirmation <input type="password" name="confirmPwd" value="<?php echo (isset($_POST['confirmPwd']))? $_POST['confirmPwd'] : ''; ?>" required></label>
			<input type="submit" name="changePwdSubmit">
		</form>
	</section>
<?php
} // end showChangeForm()

$error_msg = [];

if(isset($_POST['changePwdSubmit'])){
	// set variables
	$email = $_POST['email'];
	$oldPwd = $_POST['oldPwd'];
	$newPwd = $_POST['newPwd'];
	$confirmPwd = $_POST['confirmPwd'];


	// start query to get the record from the DB based on the email address
	$sql = "SELECT email, pwd FROM login WHERE email=:email";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':email', $email, PDO::PARAM_STR);
	// run the query to insert a new company record
	try{
		$stmt->execute();
		$row = $stmt->fetch(PDO::FETCH_OBJ); // should only be one record
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
	}

	if($row){ // if we get a result back from the fetch()
		if(password_verify($oldPwd, $row->pwd)){ // if the passwords match (input and db)
			if($newPwd === $confirmPwd){ 
			// if the new password matches the confirmation password, hash and store it
				$hash = password_hash($newPwd, PASSWORD_DEFAULT);
				$sql = "UPDATE login SET pwd=$hash WHERE email=:email";
				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				// run the query to insert a new company record
				try{
					$stmt->execute();
					$row = $stmt->fetch(PDO::FETCH_OBJ); // should only be one record
				} catch(PDOException $e){
					file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
				}
				showHeader($title);
?>
			<section>
				<div class="row">
					<div class="col-md-12"></div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<p>Your password has been updated!</p>
					</div>
				</div>
			</section>
<?php
			} else { // the passwords don't match - add to $error_msg
				array_push($error_msg, "The passwords do not match between your new password and the confirmation password you entered.");
				showChangeForm($title, $error_msg);
			}
		} else { // the passwords didn't verify against the hash password
			array_push($error_msg, "The old password you entered could not be verified. This must match our records in order for you to change it.");
			showChangeForm($title, $error_msg);
		}
	} else { // there was not a record with that email
		array_push($error_msg, "The email that you provided was not found. Please review your input or talk to your administrator.");
		showChangeForm($title, $error_msg);
	}
// end if(isset($_POST['changePwdSubmit']))
} else { // the form hasn't been submitted
 	showChangeForm($title, $error_msg);
}
showFooter();
?>