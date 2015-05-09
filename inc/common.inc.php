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
		<img id="mainLogo" class="col-med-2" src="images/MDTLogo.jpg" alt="MDT Logo">
		<div class="col-med-10">
			<nav>
				<ul class="row list-unstyled list-inline">
					<li class="col-med-2"><a href="companies.php">Companies</a></li>
					<li class="col-med-2"><a href="testRecords.php">Test Records</a></li>
					<li class="col-med-2"><a href="employees.php">Employees</a></li>
					<!-- <li class="col-med-2"><a href="timeRecords.php">Time Records</a></li> -->
					<li class="col-med-2"><a href="payroll.php">Payroll Summary</a></li>
					<li class="col-med-2"><a href="tests.php">Test Summary</a></li>
				</ul>
			</nav>
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
