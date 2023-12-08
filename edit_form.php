<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Student Information</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <h2>Edit Student Information</h2>

    <?php
    if (isset($studentID)) {
        // Fetch student information based on ID and pre-fill the form
        $query = "SELECT * FROM Students WHERE StudentID = $studentID";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
    ?>
            <form action="update_student.php" method="post">
                <!-- Add your input fields here with pre-filled values from $row -->
                First Name: <input type="text" name="FirstName" value="<?= $row['FirstName'] ?>" required><br>
                Last Name: <input type="text" name="LastName" value="<?= $row['LastName'] ?>" required><br>
                Gender: <input type="text" name="Gender" value="<?= $row['Gender'] ?>" required><br>
                Date of Birth: <input type="date" name="DateOfBirth" value="<?= $row['DateOfBirth'] ?>" required><br>
                Grade: <input type="text" name="Grade" value="<?= $row['Grade'] ?>" required><br>
                School Name: <input type="text" name="SchoolName" value="<?= $row['SchoolName'] ?>" required><br>
                <!-- Add hidden input for StudentID to identify the student being edited -->
                <input type="hidden" name="StudentID" value="<?= $row['StudentID'] ?>">
                <input type="submit" name="submit" value="Update">
            </form>
    <?php
        } else {
            echo "No student found with the provided ID for editing.";
        }
    } else {
        echo "Student ID not provided for editing.";
    }
    ?>

</body>
</html>
