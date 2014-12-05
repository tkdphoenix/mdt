<?php
require_once('inc/conn.inc.php');
$stmt = $conn->prepare("SELECT * FROM companies WHERE id = ?");
if($stmt->execute(array($_GET['id']))){
	while($row = $stmt->fetch()){
		print_r($row);
	}
}