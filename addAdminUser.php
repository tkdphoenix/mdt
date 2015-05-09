<?php
include_once('inc/common.inc.php');
require_once('inc/conn.inc.php');
if(isset($_POST['submitAdmin'])){
	$user = $_POST['user'];
	$pass = $_POST['pwd'];
	$email = $_POST['email'];

	// check email against current employees - if it exists, they can move on
	// if not, provide error message and link to return to form to request access
	$sql = "SELECT email, first, last FROM employees;";
	$stmt = $conn->prepare($sql);
	try{
		$stmt->execute();
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		exit("Could not compare emails. Try again later");
	}
	$fetchAll = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// create variable to see if there is a match between DB and user input
	$match = false;
	foreach ($fetchAll as $dbEmail) {
		// @TODO remove this echo
		echo $dbEmail['email'] . "<br>";
		if($dbEmail['email'] === $email){
			$match = true;
			$name = $dbEmail['first'] . ' ' . $dbEmail['last'];
			break;
		}

		if(!$match){
			exit("<p class='alert alert-danger'>You are not listed as a current employee. Please speak to the administrator.</p>");
		}
	}

	if($match){ // if email is in DB, create a user and encrypted password and store it to the DB
		// higher cost is more secure but consumes more processing power
		$cost = 10;

		// create random salt
		$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

		$salt = sprintf("$2a$%02d$", $cost) . $salt;

		// hash the password with the salt
		$hash = crypt($pass, $salt);

		// REMEMBER TO USE TRY CATCH BLOCKS!!!
		$sql = "INSERT INTO login(user,
			pwd,
			email) VALUES (
			:user,
			:pwd,
			:email)";

		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':user', $user, PDO::PARAM_STR);
		$stmt->bindParam(':pwd', $hash, PDO::PARAM_STR);
		$stmt->bindParam(':email', $email, PDO::PARAM_STR);

		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
			exit("Couldn't create the request.");
		}
	} // end if($match)

	// @TODO by default the user will not be active and will need to have an email sent to get them validated

	// @TODO provide a message to the user that they will be notified by the administrator once they are granted access
	$msg = "<p>Your request has been submitted, and once the administrator approves you you will be notified that access has been granted</p>";
	$err = "<p class='alert alert-danger'>Your email could not be submitted. Please try again later or speak to the administrator about this error</p>";
	$mail = sendAccessRequest($name, $email);
	echo ($mail) ? $msg : $err;
	




} else { // the form hasn't been submitted, so show the form
	showHeader("Request Access");
?>
	<section id="requestAccess" class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-10">
				<form action="?" method="post" class="form-inline container-fluid">
					<div class="form-group">
						<label for="user" class="sr-only">Username</label>
						<input id="user" name="user" type="text" placeholder="Username" required>
					</div>
					<div class="form-group">
						<label for="pwd" class="sr-only">Password</label>
						<input id="pwd" name="pwd" type="password" placeholder="Password" required>
					</div>
					<div class="form-group">
						<label for="confirm" class="sr-only">Password Confirmation</label>
						<input id="confirm" name="confirm" type="password" placeholder="Password Confirmation" required>
					</div>
					<div class="form-group">
						<label for="email" class="sr-only">Email</label>
						<input id="email" name="email" type="email" placeholder="Email" required>
					</div>
					<input type="submit" id="submitAdmin" class="btn btn-default" name="submitAdmin" value="Submit Request">
				</form>
			</div>
		</div>
	</section>
<?php
}
