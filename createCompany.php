<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create Company</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
</head>
<body>
	<header>
		<a href="index.php"><img src="" alt="MDT Logo"></a>
		<nav>
			<ul>
				<li><a href="index.php">Home</a></li>
				<li><a href="createCompany.php">Company</a></li>
				<li><a href="createCoc.php">CoC</a></li>
				<li><a href="employees.php">Employees</a></li>
				<li><a href="timeRecords.php">Time Records</a></li>
				<li><a href="payrollSummary.php">Payroll Summary</a></li>
				<li><a href="testSummary">Test Summary</a></li>
			</ul>
		</nav>
	</header>
	<section>
		<h2>Companies</h2>
		<form action="?" method="post">
			<input id="companyName" name="companyName" class="" type="text" placeholder="Company Name">
			<input id="companyAddr1" name="companyAddr1" class="" type="text" placeholder="Company Address 1">
			<input id="companyAddr2" name="companyAddr2" class="" type="text" placeholder="Company Address 2">
			<input id="city" name="city" class="" type="text" placeholder="City">
			<input id="state" name="state" class="" type="text" placeholder="State">
			<input id="zipCode" name="zipCode" class="" type="text" placeholder="Zip code">
			<input id="phone" name="phone" class="" type="text" placeholder="Company Phone">
			<input id="poc" name="poc" class="" type="text" placeholder="Point of Contact">

			<p id="topLabel">Tests available:</p>
			<input id="preemployment" name="preemployment" class="" type="checkbox">
			<label for="preemployment">Pre-employment</label>
			<input id="random" name="random" class="" type="checkbox">
			<label for="random">Random</label>
			<input id="reasonableSuspicion" name="reasonableSuspicion" class="" type="checkbox">
			<label for="reasonableSuspicion">Reasonablle Suspicion</label>
			<input id="postAccident" name="postAccident" class="" type="checkbox">
			<label for="postAccident">Post Accident</label>
			<input id="returnToDuty" name="returnToDuty" class="" type="checkbox">
			<label for="returnToDuty">Return to duty</label>
			<input id="followup" name="followup" class="" type="checkbox">
			<label for="followup">Follow up</label>
			<input id="other" name="other" class="" type="checkbox">
			<label for="other">Other</label>
			<input id="explain" name="explain" class="" type="text" placeholder="Explain other">

			<input id="submit" name="submit" class="" type="submit" value="Submit">
		</form>
	</section>
</body>
</html>