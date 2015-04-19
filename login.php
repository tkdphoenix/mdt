<?php
	require_once('inc/conn.inc.php');
	// start the session
	session_start();

	// Clear the error message
	$error_msg = "";

	if(isset($_POST['submit'])) { // if the form has been submitted
		$user = $_POST['user'];
		$pwd = $_POST['pwd'];
		$sql = "SELECT user, pwd FROM login WHERE user='$user' AND pwd='$pwd'";

		$stmt = $conn->prepare($sql);

		$stmt->bindParam(':user', $user, PDO::PARAM_STR);
		$stmt->bindParam(':pwd', $pwd, PDO::PARAM_STR);
		// run the query to insert a new employee record
		try{
			$stmt->execute();
		} catch(PDOException $e){
			file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
		}
	} else {



	// If the user isn't logged in, try to log them in
	if (!isset($_SESSION['user'])) {
		if (isset($_POST['submit'])) {

			// Grab the user-entered log-in data
			$user = $_POST['user'];
			$pwd = $_POST['pwd'];

			if (!empty($user) && !empty($pwd)) {
				// Look up the username and pwd in the database
				$query = "SELECT user_id, user FROM mismatch_user WHERE user = '$user_username' AND pwd = SHA('$pwd')";
				$data = mysqli_query($dbc, $query);

				if (mysqli_num_rows($data) == 1) {
					// The log-in is OK so set the user ID and user session vars (and cookies), and redirect to the home page
					$row = mysqli_fetch_array($data);
					$_SESSION['user_id'] = $row['user_id'];
					$_SESSION['user'] = $row['user'];
					setcookie('user_id', $row['user_id'], time() + (60 * 60 * 24 * 30));    // expires in 30 days
					setcookie('user', $row['user'], time() + (60 * 60 * 24 * 30));  // expires in 30 days
					$home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
					header('Location: ' . $home_url);
				} else {
					// The user/pwd are incorrect so set an error message
					$error_msg = 'Sorry, you must enter a valid username and password to log in.';
				}
			} else {
				// The user/pwd weren't entered so set an error message
				$error_msg = 'Sorry, you must enter your username and password to log in.';
			}
		}
	}

	// If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
	if (empty($_SESSION['user_id'])) {
	echo '<p class="error">' . $error_msg . '</p>';
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
	<h1>Log In</h1>
	<p>Please log in to access this site. If you don't have a login and need access, please <a href="#">sign up here</a></p>
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
