<?php
/** this script is meant to provide a form to request access.
  * All submissions must be manually approved by an individual.
  *	A submission is checked to see if they are a current employee
  * by checking their email against employee records. There is also a check
  * to ensure that two users do not have the same username.
  * All requests are added to the database with a column named 'active' which 
  * defaults to false or 0. The purpose of the approval is to change the active 
  * column to true or 1. After logging the person's request for admin access,
  * an email is sent to a current admin user to review if the person is expected
  * to be requesting access. If not, it can be ignored. If so, they can approve
  * the request.
  */
include_once('inc/common.inc.php');
require_once('inc/conn.inc.php');
if(isset($_POST['submitAdmin'])){
	$user = $_POST['user'];
	$pwd = $_POST['pwd'];
	$email = $_POST['email'];
	$confirm = $_POST['confirm'];
	$error_msg = [];
	$show_form = false;
	
	// make sure values were submitted with the form
	if(empty($user) && empty($pwd) && empty($confirm) && empty($email)){
		array_push($error_msg, "You must submit values for your form to be reviewed. Please try again.");
	}

	// make sure the email and confirmation email match
	if($pwd !== $confirm){
		array_push($error_msg, "Your password and password confirmation do not match.");
		$show_form = true;
	}

	// check email against current employees - if it exists, they can move on
	// if not, provide error message and link to return to form to request access
	$sql = "SELECT email, first, last FROM employees;";
	$stmt = $conn->prepare($sql);
	try{
		$stmt->execute();
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage(), FILE_APPEND);
		exit("The system could not complete your request. Please speak to the site administrator.");
	}
	$fetchAll = $stmt->fetchAll(PDO::FETCH_ASSOC);

	// create variable to see if there is a match between DB and user input
	$match = false;
	foreach ($fetchAll as $dbEmail) {
		// @TODO remove this echo
		// echo $dbEmail['email'] . "<br>";
		if($dbEmail['email'] === $email){
			$match = true;
			$name = $dbEmail['first'] . ' ' . $dbEmail['last'];
			break;
		}
	}

	// test to see if the email and username have already been submitted -- avoid duplicates
	$sql = "SELECT email,
				user
			FROM login";
	$stmt = $conn->prepare($sql);
	try{
		$stmt->execute();
	} catch(PDOException $e){
		file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage(), FILE_APPEND);
		exit("The system could not complete your request. Please speak to the site administrator.");
	}

	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	foreach($rows as $row){
		// first test the email
		if($row['email'] === $email){
			array_push($error_msg, "Your email already exists as a registered admin user. Please see your adminisitrator.");
			$show_form = true;
		}
		// next test the username
		if($row['user'] === $user){
			array_push($error_msg, "That username is taken. Please select another.");
			$show_form = true;
		}		
	}

	// there was no match between DB and user input
	if(!$match){
		array_push($error_msg, "You are not listed as a current employee. Please speak to the administrator or use your current email on your employee record.");
		$show_form=true;
		// there are obviously errors at this point, so display the form with errors and exit the script
		if(!empty($error_msg)){
			showForm($error_msg);
			exit();
		}
	} else { // if email is in DB, create a login user, email, and encrypted password and store it to the DB
		// first check to see if there are errors. If so, re-display the form with the errors at the top and the $_POST vars filled in where possible.
		if(!empty($error_msg)){
			showForm($error_msg);
			exit();
		}
		// higher cost is more secure but consumes more processing power
		// not necessary when using password_hash()
		// $cost = 10;
		// create random salt
		// $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
		// $salt = sprintf("$2a$%02d$", $cost) . $salt;

		// hash the password with the salt
		// old code for PHP>=v5.6
		// $hash = crypt($pwd, $salt);
		// have to change pwd column to be VARCHAR(255)
		$hash = password_hash($pwd, PASSWORD_DEFAULT);

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
			file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage(), FILE_APPEND);
			exit("The system couldn't create the request. Please speak to the site administrator");
		}
	} // end if($match)

	$msg = "<p>Your request has been submitted, and once the administrator approves the request you will be notified that access has been granted.</p>";
	$err = "<p class='alert alert-danger'>Your email could not be submitted. Please try again later or speak to the administrator about this error.</p>";
	// @TODO return to login page
	$mail = sendAccessRequest($name, $email);
	showHeader("Login Request Submitted");
	if($mail){
		echo $msg;
	} else {
		echo $err;
	} 
} else { // the form hasn't been submitted, so show the form
	showForm(null, null);
} // end else (form hasn't been submitted)

	function showForm($errorsArray){
	showHeader("Request Access");
	if(!empty($errorsArray)){
		for($i=0,$ii=count($errorsArray); $i<$ii; $i++){
			echo "<p class='alert alert-danger'>" . $errorsArray[$i] . "</p>";
		}
	}
?>
	<section id="requestAccess" class="container-fluid">
		<div class="row">
			<h1 class="col-md-3">Request Access</h1>
			<div class="col-md-9"></div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<form action="?" method="post" class="form-inline container-fluid">
					<div class="form-group">
						<label for="user">Username</label>
						<input id="user" class="form-control" name="user" type="text" placeholder="Username" value="<?php if(isset($_POST['user'])){ echo $_POST['user']; } ?>" required>
					</div>
					<div class="form-group">
						<label for="pwd">Password</label>
						<input id="pwd" class="form-control" name="pwd" type="password" placeholder="Password" value="<?php if(isset($_POST['pwd'])){ echo $_POST['pwd']; } ?>" required>
					</div>
					<div class="form-group">
						<label for="confirm">Password Confirmation</label>
						<input id="confirm" class="form-control" name="confirm" type="password" placeholder="Password Confirmation" value="<?php if(isset($_POST['confirm'])){ echo $_POST['confirm']; } ?>" required>
					</div>
					<div class="form-group">
						<label for="email">Email</label>
						<input id="email" class="form-control" name="email" type="email" placeholder="Email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>" required>
					</div>
					<input type="submit" id="submitAdmin" class="btn btn-default" name="submitAdmin" value="Submit Request">
				</form>
			</div>
		</div>
	</section>
<?php
	} // end showForm()
?>