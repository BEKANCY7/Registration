<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Student Information</title>
    <link rel="stylesheet" href="styles.css">
    <!-- Include font-awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

            // Add "Edit" and "Delete" options with icons
            echo '<br><br>';
            echo '<a href="edit_student.php?id=' . $studentID . '" class="action-btn" title="Edit"><i class="fas fa-edit"></i> Edit</a>';
            echo '<a href="delete_student.php?id=' . $studentID . '" class="action-btn" title="Delete"><i class="fas fa-trash-alt"></i> Delete</a>';
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
