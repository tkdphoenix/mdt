<?php
	require_once('inc/startsession.inc.php');
	require_once('inc/conn.inc.php');

	// Clear the error message
	$error_msg = "";

	if(!isset($_SESSION['user'])){
		if(isset($_POST['submit'])) { // if the form has been submitted
			$postUser = $_POST['user'];
			$pwd = $_POST['pwd'];

			if(!empty($user) && !empty($pwd)){ // make sure we have the values we need
				$sql = "SELECT pwd,
							user_id,
							user,
							active
						FROM login
						WHERE 
							user = :user";

				$stmt = $conn->prepare($sql);
				$stmt->bindParam(':user', $postUser, PDO::PARAM_STR);
				// run the query to select the employee record
				try{
					$stmt->execute();
					$user = $stmt->fetch(PDO::FETCH_OBJ); // should only be one record
				} catch(PDOException $e){
					file_put_contents('PDOErrors.txt', timeNow() . ' ' . $e->getMessage(), FILE_APPEND);
					exit("There was an issue with the database. Please try again or speak to your administrator.");
				}
				if($user){
					// hashing the password with its hash as the salt returns the same hash
					// old line for PHP>=v5.6 
					// if(hash_equals($user->pwd, crypt($pwd, $user->pwd))){
					if(password_verify($pwd, $user->pwd)){
						if($postUser === $user->user){
							if($user->active == true){ // confirm that the user is active
								// The log-in is OK so set the user ID and user session vars (and cookies), and redirect to the companies.php page
								$_SESSION['user_id'] = $user->user_id;
								$_SESSION['user'] = $user->user;
								setcookie('user_id', $user->user_id, time() + (60 * 60 * 24 * 30));    // expires in 30 days
								setcookie('user', $user->user, time() + (60 * 60 * 24 * 30));  // expires in 30 days
								$home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . 'companies.php';
								header('Location: ' . $home_url);
							} else { // end if($user->active == true)
								$error_msg = "Your credentials are not active yet. Please see your administrator to expidite this request.";
							}
						} else {
							$error_msg = "Your username does not match the database, or is not active. Check to ensure proper case is used.<br>".
							"Ex: 'MyUser' instead of 'myuser'";
						}
					} else {
						$error_msg = "Your password doesn't match.";
					}
				} else {
					// The user/pwd are incorrect so set an error message
					$error_msg = 'Sorry, you must enter a valid username and password to log in.';
				}
			} else { // if(!empty($user) && !empty($pwd))
				// The user/pwd weren't entered so set an error message
				$error_msg = 'Sorry, you must enter your username and password to log in.';
			}
		} // end if(isset($_POST['submit']))
	} else { // end if(isset($_SESSION['user']))
		// the session is set, so redirect to compainies.php
		header("Location: companies.php");
	}





// @TODO need to confirm person with active employee status and also test to see if admin access is active before allowing admin user to enter system




	// if the user is signed in then redirect to companies.php - otherwise, show the login form which redirects to login.php
	if(isset($_SESSION['user_id'])){
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . 'companies.php';
		header('Location: ' . $home_url);
	} else {
		require_once('inc/common.inc.php');
		showHeader("Log In");
		echo (!empty($error_msg))? '<p class="alert alert-danger">' . $error_msg . '</p>': '';
?>
	<section class="container-fluid">
		<div class="row">
			<h1 class="col-md-3">Log In</h1>
			<div class="col-md-9"></div>
		</div>
		<form class="form-inline container-fluid" action="?" method="post">
			<div class="form-group"><label for="user"><input class="form-control" type="text" name="user" placeholder="Username"></label></div>
			<div class="form-group"><label for="pwd"><input class="form-control" type="password" name="pwd" placeholder="Password"></label></div>
			<input type="submit" name="submit" value="Submit">
		</form>
		<div class="row">
			<a class="col-md-2" href="forgotPwd.php">Forgot username or password</a>
			<span class="col-md-10"></span>
		</div>

	</section>

<?php
	// require_once("inc/footer.inc.php");
	showFooter();
	}
?>