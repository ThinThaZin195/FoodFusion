<?php
$host = 'localhost';
$db = 'foodfusion_new';
$user = 'root';
$pass = '12345678'; // or your password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

}
?>
