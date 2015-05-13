<?php
	// session_start() creates a new session, or joins a session already in progress.
	session_start();

	// If the session vars aren't set, try to set them with a cookie
	if (!isset($_SESSION['user_id'])) {
		if (isset($_COOKIE['user_id']) && isset($_COOKIE['user'])) {
			$_SESSION['user_id'] = $_COOKIE['user_id'];
			$_SESSION['user'] = $_COOKIE['user'];
		}
	}
?>
