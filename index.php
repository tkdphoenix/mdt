<?php
if($_POST['submit']){ // if the form has been submitted
	$user = $_POST['user'];
	$pwd = $_POST['pwd'];
	include('inc/conn.inc.php');
	$sql = "SELECT username, password FROM XXX WHERE username='$user' AND password='$pwd'";

}
?>
