<?php
/**
 *	This is a common include file
 *	PDO Library Management 
 *	@author Joel Grissom
 */
$connStr = 'mysql:host=localhost;dbname=mobile_drug_testing';
$user = 'root';
$pwd = 'root';
$conn = new PDO($connStr, $user, $pwd);

?>