<?php
echo "host: " . $_SERVER['HTTP_HOST'] . "<br>";
echo "PHP_SELF: " . dirname($_SERVER['PHP_SELF']) . "<br>";
$home_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . 'companies.php';
echo "home_url: " . $home_url;

?>