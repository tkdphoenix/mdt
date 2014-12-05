<?php
/**
 *	This is a common include file for the database connection
 *	PDO Library Management 
 *	@author Joel Grissom
 */
$connStr = 'mysql:host=localhost;dbname=mobile_drug_testing';
$user = 'root';
$pwd = 'root';

try{
	$conn = new PDO($connStr, $user, $pwd);
	$conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
} catch(PDOException $e){
	file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}
?>