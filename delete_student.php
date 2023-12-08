<?php
if (isset($_GET['id'])) {
    $studentID = $_GET['id'];

    $hostname = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'registrationform';
    $port = 3306;
    $conn = new mysqli($hostname, $username, $password, $database, $port);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "DELETE FROM Students WHERE StudentID=$studentID";

    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Student ID not provided for deletion.";
}
?>