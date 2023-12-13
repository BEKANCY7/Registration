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
    if (!preg_match("/^[A-Z][a-zA-Z]*$/", $firstName)) {
        $errors[] = "First Name should start with a capital letter and only contain letters.";
    }

    // Validation for Last Name: Only letters are allowed and should start with a capital letter
    if (!preg_match("/^[A-Z][a-zA-Z]*$/", $lastName)) {
        $errors[] = "Last Name should start with a capital letter and only contain letters.";
    }

    // Validation for Date of Birth: It should not be in the future
    if (strtotime($dateOfBirth) > time()) {
        $errors[] = "Date of Birth cannot be in the future.";
    }

    // Validation for Grade: It should not be empty
    if (empty($grade)) {
        $errors[] = "Grade is required.";
    }

    // Add more validation checks as needed

    // If no errors, proceed with registration
    if (empty($errors)) {
        $sql = "INSERT INTO Students (FirstName, LastName, Gender, DateOfBirth, Grade, SchoolName)
                VALUES ('$firstName', '$lastName', '$gender', '$dateOfBirth', '$grade', '$schoolName')";

        if ($conn->query($sql)) {
            // Redirect to the student list page
            header("Location: student_list.php");
            exit();
        } else {
            echo '<div class="error-message">Error in registration: ' . $conn->error . '</div>';
        }
    } else {
        // Display validation errors
        foreach ($errors as $error) {
            echo '<div class="error-message">' . $error . '</div>';
        }
    }
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
