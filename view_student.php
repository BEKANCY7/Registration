<!-- view_student.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Information</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>View Student Information</h2>

    <?php
    // Check if StudentID is provided in the URL
    if (isset($_GET['id'])) {
        $studentID = $_GET['id'];

        // Perform your database query to retrieve the student information
        // Replace this with your actual database retrieval logic
        $hostname = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'registrationform';
        $port = 3306;
        $conn = new mysqli($hostname, $username, $password, $database, $port);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query to retrieve the student information
        $query = "SELECT * FROM Students WHERE StudentID = $studentID";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            // Display the student information
            echo '<p><strong>Student ID:</strong> ' . $row['StudentID'] . '</p>';
            echo '<p><strong>First Name:</strong> ' . $row['FirstName'] . '</p>';
            echo '<p><strong>Last Name:</strong> ' . $row['LastName'] . '</p>';
            echo '<p><strong>Gender:</strong> ' . $row['Gender'] . '</p>';
            echo '<p><strong>Date of Birth:</strong> ' . $row['DateOfBirth'] . '</p>';
            echo '<p><strong>Grade:</strong> ' . $row['Grade'] . '</p>';
            echo '<p><strong>School Name:</strong> ' . $row['SchoolName'] . '</p>';
        } else {
            echo "No student found with the provided ID.";
        }

        $conn->close();
    } else {
        echo "Student ID not provided.";
    }
    ?>

</body>
</html>
