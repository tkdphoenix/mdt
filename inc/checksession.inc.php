<?php
	if(!isset($_SESSION['user'])){
		$home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . 'index.php';
		header('Location: ' . $home_url);
	}
?>