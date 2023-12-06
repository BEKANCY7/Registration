<?php
$db = new SQLite3('path/to/your/database.db');

$firstName = $_POST['FirstName'];
$lastName = $_POST['LastName'];
$gender = $_POST['Gender'];
$dateOfBirth = $_POST['DateOfBirth'];
$grade = $_POST['Grade'];
$schoolName = $_POST['SchoolName'];

$query = "INSERT INTO Students (FirstName, LastName, Gender, DateOfBirth, Grade, SchoolName)
          VALUES ('$firstName', '$lastName', '$gender', '$dateOfBirth', '$grade', '$schoolName')";

$result = $db->exec($query);

if ($result) {
    echo "Registration successful!";
} else {
    echo "Error in registration: " . $db->lastErrorMsg();
}

$db->close();
?>
