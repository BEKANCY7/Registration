<?php
$hostname = 'localhost';
$username = 'bereket';
$password = '@bekiglad78';
$database = 'student registration';

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
