<?php
/**
 *	common functions available to all pages
 *	@author Joel Grissom
 */

/**
 *	shows the header with the proper title in the title bar
 *	@param string - $title - string to put into the title tag
 */
function showHeader($title){
?>
	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title><?=htmlspecialchars($title)?></title>
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/jquery-ui.min.css">
		<link rel="stylesheet" href="css/mdt.css">
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/modernizr.custom.inputs.js"></script>
	</head>
	<body>
		<div class="row">
			<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/index.php'; ?>"><img id="mainLogo" class="col-md-2" src="images/MDTLogo.jpg" alt="MDT Logo"></a>
			<div class="col-md-10">
	<?php
	if(isset($_SESSION['user'])){ // the user is logged in, so show the menu
		// @TODO add "logout" button and welcome $name message for the logged in user.
	?>
				<nav>
					<ul class="row list-unstyled list-inline">
						<li class="col-md-1"><a href="companies.php">Companies</a></li>
						<li class="col-md-1"><a href="testRecords.php">Test Records</a></li>
						<li class="col-md-1"><a href="employees.php">Employees</a></li>
						<li class="col-md-1"><a href="payroll.php">Payroll Summary</a></li>
						<li class="col-md-1"><a href="tests.php">Test Summary</a></li>
						<li class="col-md-1 col-md-offset-4 btn btn-default"><a href="logout.php">Log Out</a></li>
						<span class="col-md-2"></span>
					</ul>
				</nav>
	<?php	
	} else { // the user is not logged in so only show special items on the menu
	?>
				<nav>
					<ul class="row list-unstyled list-inline">
						<li class="col-md-1 col-md-offset-8 btn btn-default"><a href="index.php">Log In</a></li>
						<li class="col-md-1 btn btn-default"><a href="createLogin.php">Request Access</a></li>
						<div class="col-md-2"></div>
					</ul>
				</nav>

	<?php 
	}
?>
		</div>
	</div> <!-- .row -->

<?php
} // END showHeader()

// shows the page footer
function showFooter(){
?>
		<footer>
			<script src="js/jquery-1.11.1.min.js"></script>
			<script src="js/bootstrap.min.js"></script>
			<script src="js/jquery-ui.min.js"></script>
			<script src="js/mdt.js"></script>
		</footer>
	</section>
</body>
</html>
<?php
} // END showFooter()

// confirm email matches confirm email field
function confirmEmailMatch($email, $confirm){
	return ($email === $confirm) ? true : false;
} // end confirmEmailMatch()


// send email
function sendAccessRequest($name, $email){
	// multiple recipients
	// $to  = 'aidan@example.com' . ', '; // note the comma
	// $to .= 'wez@example.com';
	$to = 'joelgrissom5@gmail.com';

	// subject
	$subject = 'Admin Rights Request';

	// message
	$message = "
	<html>
	<head>
	  <title>Admin request for mdtservices.org</title>
	</head>
	<body>
	  <p>$name has requested admin access to the site.</p>
	  <p>You can <a style='cursor: pointer;' href='http://mdtservices.org/grantAccess.php?email=$email'>grant access</a> or ignore the request and they 
	  will not be activated</p>
	</body>
	</html>
	";

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	// Additional headers
	$headers .= 'To: Joel <joelgrissom5@gmail.com>' . "\r\n";
	$headers .= 'From: Your Website <joel@example.com>' . "\r\n";
	// $headers .= 'Cc: birthdayarchive@example.com' . "\r\n";
	// $headers .= 'Bcc: birthdaycheck@example.com' . "\r\n";

	// Mail it
	$wasSent = mail($to, $subject, $message, $headers);	
	return ($wasSent) ? true : false;	
}
?>
