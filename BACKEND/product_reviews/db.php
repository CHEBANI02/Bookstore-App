<?php
$host = 'localhost'; 
$port = '5432'; 
$dbname = 'product_reviews'; 
$user = 'nebula'; 
$password = 'cool'; 

$connection_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

$conn = pg_connect($connection_string);

if (!$conn) {
    die("Connection failed: " . pg_last_error());
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "Database connection successful!";

?>
