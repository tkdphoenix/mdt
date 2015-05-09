<?php
require_once('inc/conn.inc.php');
$user = 'admin';
$pass = 'gf45_gdf#4hg';

// higher cost is more secure but consumes more processing power
$cost = 10;

// create random salt
$salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');

$salt = sprintf("$2a$%02d$", $cost) . $salt;

// get value
echo "salt = ".  $salt . "<br>";

// hash the password with the salt
$hash = crypt($pass, $salt);

// value
echo "hash = ". $hash . "<br>";
echo strlen($hash) . "<br>";
// REMEMBER TO USE TRY CATCH BLOCKS!!!
// $sql = "INSERT INTO login(user,
// 	pwd) VALUES (
// 	:user,
// 	:pwd)";

// $stmt = $conn->prepare($sql);

// $stmt->bindParam(':user', $user, PDO::PARAM_STR);
// $stmt->bindParam(':pwd', $hash, PDO::PARAM_STR);

// try{
// 	$stmt->execute();
// } catch(PDOException $e){
// 	file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
// 	exit("couldn't continue.");
// }


//////////////////////////////////////////////////
// should have data saved to db

$sql = "SELECT pwd
		FROM login
		WHERE 
			user = :user";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user', $user);

try{
	$stmt->execute();
} catch(PDOException $e){
	file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
}

$user = $stmt->fetch(PDO::FETCH_OBJ);

// hashing the password with its hash as the salt returns the same hash
if(hash_equals($user->pwd, crypt($pass, $user->pwd))){
	echo "yep, they match, buckaroo. Let 'em in!";
} else {
	echo "no way you're gettin' in here!<br>";
}

echo "pwd from DB: " . $user->pwd . "<br>";
echo strlen($user->pwd) . "<br><br>";
echo "crypt with pass and user -> pwd: " . crypt($pass, $user->pwd) . "<br>";
echo "var dump of user from DB: ";
var_dump($user);



