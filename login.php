<?php
if(isset($_POST['submit'])) { // if the form has been submitted
	$user = $_POST['user'];
	$pwd = $_POST['pwd'];
	include('inc/conn.inc.php');
	$sql = "SELECT username, password FROM login WHERE username='$user' AND password='$pwd'";

} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<title>Log In</title>
</head>
<body>
	<header>
		<a href="index.php"><img src="" alt="MDT Logo"></a>
	</header>
	<form id="loginForm" action="?" method="post">
		<input id="user" name="user" class="login" type="text" placeholder="User Name">
		<input id="pwd" name="pwd" class="login" type="password" placeholder="Password">
		<input id="submit" name="submit" type="submit" value="Submit">
		<a href="createLogin.php">Need access? Request access here</a>
		<a href="forgotPwd.php">Forgot username or password</a>
	</form>
</body>
</html>
<?php
}
?>
