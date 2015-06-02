<?php
	require_once('inc/startsession.inc.php');
	require_once('inc/common.inc.php');
	require_once('inc/conn.inc.php');
	require_once('inc/checksession.inc.php');

	showHeader('Reports');
?>

	<section id="reports" class="container-fluid">
		<div class="row">
			<!-- left nav area -->
			<div class="col-md-3">
				<h4>Report Types</h4>
				<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingOne">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
									Monthly Reports
								</a>
							</h4>
						</div>
						<div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
							<div class="panel-body">
								<select class="form-control reporting" name="monthlyEmployee" id="monthlyEmployee">
									<option value="default">By Employee</option>
<?php
// start query for employees by name who are active, add li for each one.
$sql = "SELECT id, first, last FROM employees WHERE active = 1 ORDER BY last";
$q = $conn->prepare($sql);
// run the query to get all company records
try{
	$q->execute();
} catch(PDOException $e){
	file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
}
$employees = $q->fetchAll(PDO::FETCH_ASSOC);
foreach($employees as $e){
?>
									<option value="<?=htmlspecialchars("$e[id]")?>"><?=htmlspecialchars("$e[first]")?> <?=htmlspecialchars("$e[last]")?></option>
<?php
}
?>
								</select>

								<select class="form-control reporting" name="monthlyCompany" id="monthlyCompany">
									<option value="default">By Company</option>
<?php
// start query for companies by name who are active, add li for each one.
$sql = "SELECT id, company_name FROM companies WHERE active = 1 ORDER BY company_name";
$q = $conn->prepare($sql);
// run the query to get all company records
try{
	$q->execute();
} catch(PDOException $e){
	file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage()."\n\r", FILE_APPEND | LOCK_EX);
}
$companies = $q->fetchAll(PDO::FETCH_ASSOC);
foreach($companies as $c){
?>
									<option value="<?=htmlspecialchars("$c[id]")?>"><?=htmlspecialchars("$c[company_name]")?></option>
<?php
}
?>
								</select>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingTwo">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
									Semi-annual Reports
								</a>
							</h4>
						</div>
						<div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
							<div class="panel-body">
								<select class="form-control reporting" name="semiannualEmployee" id="semiannualEmployee">
									<option value="default">By Employee</option>
<?php
// $employees query is already done above, so reuse it again
foreach($employees as $e){
?>
									<option value="<?=htmlspecialchars("$e[id]")?>"><?=htmlspecialchars("$e[first]")?> <?=htmlspecialchars("$e[last]")?></option>
<?php
}
?>
								</select>

								<select class="form-control reporting" name="semiannualCompany" id="semiannualCompany">
									<option value="default" selected>By Company</option>
<?php
// $companies query is already done above, so reuse it again.
foreach($companies as $c){
?>
									<option value="<?=htmlspecialchars("$c[id]")?>"><?=htmlspecialchars("$c[company_name]")?></option>
<?php
}
?>
								</select>

							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="headingThree">
							<h4 class="panel-title">
								<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
									Yearly Reports
								</a>
							</h4>
						</div>
						<div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
							<div class="panel-body">
								<select class="form-control reporting" name="yearToDate" id="yearToDate">
									<option value="default" selected>Year To Date Report</option>
<?php
// @TODO find correct query for year to date report
$sql = "SELECT company_name FROM companies WHERE active = 1 ORDER BY company_name";
?>
									<!-- <option value="<?=htmlspecialchars("$c[id]")?>"><?=htmlspecialchars("$c[company_name]")?></option> -->
								</select>

								<select class="form-control reporting" name="yearEndReport" id="yearEndReport">
									<option value="default" selected>Year End Report</option>
<?php
// @TODO find correct query for year end report
$sql = "SELECT company_name FROM companies WHERE active = 1 ORDER BY company_name";

?>
									<!-- <option value="<?=htmlspecialchars("$c[id]")?>"><?=htmlspecialchars("$c[company_name]")?></option> -->
								</select>


								<select class="form-control reporting" name="YOY" id="YOY">
									<option value="default" selected>Year Over Year Report</option>
<?php
// @TODO find correct query for year over year report
$sql = "SELECT company_name FROM companies WHERE active = 1 ORDER BY company_name";
?>
									<!-- <option value="<?=htmlspecialchars("$c[id]")?>"><?=htmlspecialchars("$c[company_name]")?></option> -->
								</select>
							</div>
						</div>
					</div>
				</div>





			</div> <!-- end .col-md-3 -->
			<div class="col-md-9">
				<table>
							<th>
								<tr>
									<td></td>
								</tr>
							</th>
						</table>		
			</div> <!-- end .col-md-9 -->
		</div>
	</section>

<?php
showFooter();
?>