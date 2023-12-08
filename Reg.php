<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$database = 'registrationform';
$port = 3306;
$conn = new mysqli($hostname, $username, $password, $database, $port);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else {
    echo "Connected successfully";
}

if (isset($_POST["submit"])) {
    // Display form data
    echo "Form Data: ";
    print_r($_POST);
    
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $gender = $_POST['Gender'];
    $dateOfBirth = $_POST['DateOfBirth'];
    $grade = $_POST['Grade'];
    $schoolName = $_POST['SchoolName'];

    $sql = "INSERT INTO Students (FirstName, LastName, Gender, DateOfBirth, Grade, SchoolName)
            VALUES ('$firstName', '$lastName', '$gender', '$dateOfBirth', '$grade', '$schoolName')";

    // Display SQL query
    echo "SQL Query: $sql<br>";

    if ($conn->query($sql)) {
        echo "Registration successful!";
    } else {
        echo "Error in registration: " . $conn->error;
    }
}

$conn->close();
?>

