<?php
	require_once('inc/startsession.inc.php');
	require_once('inc/common.inc.php');
	require_once('inc/conn.inc.php');
	require_once('inc/checksession.inc.php');

	showHeader('Test Summary');
?>

	<section id="testSummary" class="container-fluid">
		<div class="row">
			<!-- left nav area -->
			<div class="col-md-3">
				<h4>Report Types</h4>
 				<ul>
					<li><a href="#">Monthly Payroll</a></li>
					<li><a href="#">Annual Payroll</a></li>
				</ul>
			</div> <!-- end .col-md-3 -->