function validateForm() {
    var firstName = document.getElementsByName("FirstName")[0].value;
    var lastName = document.getElementsByName("LastName")[0].value;
    var dateOfBirth = document.getElementsByName("DateOfBirth")[0].value;
    var grade = document.getElementsByName("Grade")[0].value;

    // Validate date of birth
    if (!dateOfBirth) {
        showAlert("Error: Date of Birth is required.");
        return false; // Stop form submission
    }

    // Validate grade
    if (!grade) {
        showAlert("Error: Grade is required.");
        return false; // Stop form submission
    }

    // Continue with additional validations if needed

    return true; // Proceed with form submission
}

function displayAlert(message) {
    alert(message);
}

function filterStudents() {
    let searchInput = document.getElementById('search').value.toLowerCase();
    let selectedSchool = document.getElementById('school').value.toLowerCase();

    let filteredStudents = allStudents.filter(student =>
        (selectedSchool === '' || student.SchoolName.toLowerCase() === selectedSchool) &&
        (student.FirstName.toLowerCase().includes(searchInput) ||
        student.LastName.toLowerCase().includes(searchInput) ||
        student.StudentID.includes(searchInput))
    );

    displayStudents(filteredStudents, currentPage);
}

// ... Your existing code ...
