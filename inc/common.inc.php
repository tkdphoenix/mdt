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
		<link rel="stylesheet" href="http://cdn.datatables.net/1.10.2/css/jquery.dataTables.min.css"></style>
		<link rel="stylesheet" href="css/mdt.css">
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/modernizr.custom.inputs.js"></script>
	</head>
	<body>
		<div class="row">
			<div class="col-md-3">
				<a href="<?php echo 'http://' . $_SERVER['HTTP_HOST'] . '/index.php'; ?>"><img id="mainLogo" class="col-md-2" src="images/MDTLogo.jpg" alt="MDT Logo"></a>
			</div>
	<?php
	if(isset($_SESSION['user'])){ // the user is logged in, so show the menu
		// @TODO add "logout" button and welcome $name message for the logged in user.
	?>
			<div class="col-md-9">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul id="mainNav" class="nav navbar-nav">
        <li><a href="companies.php">Comanies</a></li>
        <li><a href="testRecords.php">Test Records</a></li>
        <li><a href="employees.php">Employees</a></li>
        <li><a href="payroll.php">Payroll Summary</a></li>
        <li><a href="testSummary.php">Test Summary</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><a class="btn btn-default" href="logout.php">Log out</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>



					<!-- original -->
			<!-- 	<nav>
					<ul class="row list-unstyled list-inline">
						<li class="col-md-1"><a href="companies.php">Companies</a></li>
						<li class="col-md-1"><a href="testRecords.php">Test Records</a></li>
						<li class="col-md-1"><a href="employees.php">Employees</a></li>
						<li class="col-md-1"><a href="payroll.php">Payroll Summary</a></li>
						<li class="col-md-1"><a href="tests.php">Test Summary</a></li>
						<li class="col-md-1 col-md-offset-3 btn btn-default"><a href="logout.php">Log Out</a></li>
						<span class="col-md-3"></span>
					</ul>
				</nav> -->
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
			<script type="text/javascript" src="http://cdn.datatables.net/1.10.2/js/jquery.dataTables.min.js"></script>
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
} // end sendAccessRequest()

// email for approval of access
function accessApprovalNotice($name, $email){
	$to = $email;
	$from = 'jejabrush@yahoo.com';
	// subject
	$subject = 'Admin Rights Approved for mdtservices.org';

	// message
	$message = "
	<html>
	<head>
	  <title>Admin request approved for mdtservices.org</title>
	</head>
	<body>
	  <p>Hello <?=$name?>,</p>
	  <p>You can have been approved for admin rights to mdtservices.org. 
	  	You can start using your login credentials right away to make 
	  	changes to accounts and records in the system. If you make a change, 
	  	the system is set up so that no data is permanently lost. It will only 
	  	be inactivated.</p>
	  <p>If you have any questions about this access, contact your administrator.</p>
	</body>
	</html>
	";

	// To send HTML mail, the Content-type header must be set
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";

	// Additional headers
	$headers .= 'To: $name <$email>' . "\r\n";
	$headers .= 'From: mdtservices.org <$from>' . "\r\n";

	// Mail it
	$wasSent = mail($to, $subject, $message, $headers);	
	return ($wasSent) ? true : false;	
}

function timeNow(){
	date_default_timezone_set('America/Phoenix');
	$date = date('m/d/y H:i:s');
	return $date;
} // end timeNow()
?>
