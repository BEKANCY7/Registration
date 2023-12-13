function validateForm() {
    var firstName = document.getElementsByName("FirstName")[0].value;
    var lastName = document.getElementsByName("LastName")[0].value;
    var dateOfBirth = document.getElementsByName("DateOfBirth")[0].value;
    var grade = document.getElementsByName("Grade")[0].value;

   

    // Validate date of birth
    if (!dateOfBirth) {
        displayAlert("Error: Date of Birth is required.");
        return false; // Stop form submission
    }

    // Validate grade
    if (!grade) {
        displayAlert("Error: Grade is required.");
        return false; // Stop form submission
    }

    // Continue with additional validations if needed

    return true; // Proceed with form submission
}

function displayAlert(message) {
    alert(message);
}