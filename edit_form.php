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

// Check if StudentID is provided in the URL
if (isset($_GET['StudentID'])) {
    $studentID = $_GET['StudentID'];

    // Fetch student information based on ID and pre-fill the form
    $query = "SELECT * FROM Students WHERE StudentID = $studentID";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
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
            // Display error messages if any
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $errors = array();

                // Validate and sanitize user inputs
                $firstName = cleanInput($_POST["FirstName"]);
                $lastName = cleanInput($_POST["LastName"]);
                $gender = cleanInput($_POST["Gender"]);
                $dateOfBirth = cleanInput($_POST["DateOfBirth"]);
                $grade = cleanInput($_POST["Grade"]);
                $schoolName = cleanInput($_POST["SchoolName"]);

                // Validation for First Name: Only letters are allowed and should start with a capital letter
                if (!preg_match("/^[A-Z][a-z]*$/", $firstName)) {
                    $errors[] = "First Name should start with a capital letter and only contain letters.";
                }

                // Validation for Last Name: Only letters are allowed and should start with a capital letter
                if (!preg_match("/^[A-Z][a-z]*$/", $lastName)) {
                    $errors[] = "Last Name should start with a capital letter and only contain letters.";
                }

                // Validation for Date of Birth: It should not be in the future
                if (strtotime($dateOfBirth) > time()) {
                    $errors[] = "Date of Birth cannot be in the future.";
                }

                // Add more validation checks as needed

                // If no errors, update the student information
                if (empty($errors)) {
                    // Update the student information in the database
                    $updateQuery = "UPDATE Students SET
                        FirstName = '$firstName',
                        LastName = '$lastName',
                        Gender = '$gender',
                        DateOfBirth = '$dateOfBirth',
                        Grade = '$grade',
                        SchoolName = '$schoolName'
                        WHERE StudentID = $studentID";

                    if ($conn->query($updateQuery) === TRUE) {
                        echo "Student information updated successfully";
                    } else {
                        echo "Error updating student information: " . $conn->error;
                    }
                } else {
                    // Display validation errors
                    foreach ($errors as $error) {
                        echo "<p style='color: red;'>$error</p>";
                    }
                }
            }
            ?>

            <!-- Display the student information editing form -->
            <form action="" method="post">
                First Name: <input type="text" name="FirstName" pattern="[A-Za-z]+" title="First Name should start with a capital letter and only contain letters." value="<?= $row['FirstName'] ?>" required><br>
                Last Name: <input type="text" name="LastName" pattern="[A-Za-z]+" title="Last Name should start with a capital letter and only contain letters." value="<?= $row['LastName'] ?>" required><br>
                Gender: <input type="radio" name="Gender" value="Male" required> Male
                        <input type="radio" name="Gender" value="Female" required> Female
                Date of Birth: <input type="date" name="DateOfBirth" value="<?= $row['DateOfBirth'] ?>" required><br>
                Grade: <input type="text" name="Grade" value="<?= $row['Grade'] ?>" required><br>
                School Name: 
                <select name="SchoolName" required>
            <option value="Bole School">Bole School</option>
            <option value="Lideta School">Lideta School</option>
            <option value="Menilik School">Menilik School</option>
            <option value="Akaki School">Akaki School</option>
            <option value="Arada School">Arada School</option>
        </select><br>
                <!-- Add hidden input for StudentID to identify the student being edited -->
                <input type="hidden" name="StudentID" value="<?= $row['StudentID'] ?>">
                <input type="submit" name="submit" value="Update">
            </form>

        </body>
        </html>
<?php
    } else {
        echo "No student found with the provided ID for editing.";
    }
} else {
    echo "Student ID not provided for editing.";
}

$conn->close();

// Function to sanitize and validate input
function cleanInput($input) {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
}
?>
