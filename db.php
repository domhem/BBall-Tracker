<?php
/* Database connection settings */

$host = 'localhost';
$user = 'db_admin';
$pass = 'password123';
$db = 'cpsc431_final';
$mysqli = new mysqli($host,$user,$pass,$db) or die($mysqli->error);

?>
