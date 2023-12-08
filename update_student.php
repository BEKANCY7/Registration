<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'registrationform';
    $port = 3306;
    $conn = new mysqli($hostname, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $studentID = $_POST['StudentID'];
    $firstName = $_POST['FirstName'];
    $lastName = $_POST['LastName'];
    $gender = $_POST['Gender'];
    $dateOfBirth = $_POST['DateOfBirth'];
    $grade = $_POST['Grade'];
    $schoolName = $_POST['SchoolName'];

    $sql = "UPDATE Students
            SET FirstName='$firstName', LastName='$lastName', Gender='$gender', 
                DateOfBirth='$dateOfBirth', Grade='$grade', SchoolName='$schoolName'
            WHERE StudentID=$studentID";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
