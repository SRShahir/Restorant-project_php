<?php
//start the session
session_start();

//Create conatants no repeating value
define('SITEURL','http://localhost/fooddelivary/');;
define('LOCALHOST','localhost');
define('DB_USERNAME','root');
define('DB_PASSWORD','');
define('DB_NAME','food-order');
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn));
$db_select = mysqli_select_db($conn, 'food-order') or die(mysqli_error($conn));
