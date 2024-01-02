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

// Query to retrieve student information
$query = "SELECT * FROM Students";
$result = $conn->query($query);

$students = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Information List</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
            text-align: center;
        }

        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #ddd;
        }

        .action-btn {
            display: inline-block;
            margin: 5px;
            padding: 8px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #28a745;
        }

        .view-btn {
            background-color: #17a2b8;
        }

        .delete-btn {
            background-color: #dc3545;
        }

        .search-container {
            margin-bottom: 20px;
        }

        .search-container input {
            padding: 8px;
        }

        #paging-info {
            margin-bottom: 10px;
        }

        #prev-btn,
        #next-btn {
            padding: 8px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        #prev-btn[disabled],
        #next-btn[disabled] {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

    <h2>Student Information List</h2>
     <!-- Add a dropdown for school names -->
     <div class="search-container">
        <label for="school">School:</label>
        <select id="school" onchange="filterStudents()">
            <option value="">All Schools</option>
            <?php
                // Assuming $students is an array containing your student data
                $uniqueSchools = array_unique(array_column($students, 'SchoolName'));
                foreach ($uniqueSchools as $school) {
                    echo "<option value=\"$school\">$school</option>";
                }
            ?>
        </select>

        <label for="search">Search:</label>
        <input type="text" id="search" oninput="filterStudents()" placeholder="Search by Name or ID">
    </div>

    <table id="student-table">
        <thead>
            <tr>
                <th>StudentID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Date of Birth</th>
                <th>Grade</th>
                <th>School Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="student-table-body"></tbody>
    </table>

    <div id="paging-info"></div>
    <button id="prev-btn" onclick="goToPrevPage()">Previous Page</button>
    <button id="next-btn" onclick="goToNextPage()">Next Page</button>

    <script src="script.js"></script>
    <script>
        const studentsPerPage = 5; // Adjust this number based on your preference
        let currentPage = 1;

        document.addEventListener('DOMContentLoaded', function () {
            let students = <?php echo json_encode($students); ?>;
            filterStudents(students); // Initial display of all students on the first page
        });

        function filterStudents(allStudents) {
            let searchInput = document.getElementById('search').value.toLowerCase();
            let filteredStudents = allStudents.filter(student =>
                student.FirstName.toLowerCase().includes(searchInput) ||
                student.LastName.toLowerCase().includes(searchInput) ||
                student.StudentID.includes(searchInput)
            );

            displayStudents(filteredStudents, currentPage);
        }

        function displayStudents(studentList, page) {
            let startIndex = (page - 1) * studentsPerPage;
            let endIndex = startIndex + studentsPerPage;
            let paginatedStudents = studentList.slice(startIndex, endIndex);

            let tableBody = document.getElementById('student-table-body');
            tableBody.innerHTML = '';

            paginatedStudents.forEach(student => {
                let row = tableBody.insertRow();
                let cellStudentID = row.insertCell(0);
                let cellFirstName = row.insertCell(1);
                let cellLastName = row.insertCell(2);
                let cellGender = row.insertCell(3);
                let cellDateOfBirth = row.insertCell(4);
                let cellGrade = row.insertCell(5);
                let cellSchoolName = row.insertCell(6);
                let cellAction = row.insertCell(7);

                cellStudentID.textContent = student.StudentID;
                cellFirstName.textContent = student.FirstName;
                cellLastName.textContent = student.LastName;
                cellGender.textContent = student.Gender;
                cellDateOfBirth.textContent = student.DateOfBirth;
                cellGrade.textContent = student.Grade;
                cellSchoolName.textContent = student.SchoolName;

                // Add action buttons
                let editBtn = createActionButton('Edit', 'edit-btn', 'fas fa-edit', 'edit_form.php?StudentID=' + student.StudentID);
                let deleteBtn = createActionButton('Delete', 'delete-btn', 'fas fa-trash-alt', 'delete_student.php?id=' + student.StudentID);
                let viewBtn = createActionButton('View', 'view-btn', 'fas fa-eye', 'view_student.php?id=' + student.StudentID);

                cellAction.appendChild(editBtn);
                cellAction.appendChild(deleteBtn);
                cellAction.appendChild(viewBtn);
            });

            // Update paging information
            updatePagingInfo(page, studentList.length);
        }

        function updatePagingInfo(currentPage, totalStudents) {
            let totalPages = Math.ceil(totalStudents / studentsPerPage);

            document.getElementById('paging-info').textContent =
                `Page ${currentPage} of ${totalPages}`;

            document.getElementById('prev-btn').disabled = currentPage === 1;
            document.getElementById('next-btn').disabled = currentPage === totalPages;
        }

        function goToPrevPage() {
            if (currentPage > 1) {
                currentPage--;
                filterStudents(<?php echo json_encode($students); ?>);
            }
        }

        function goToNextPage() {
            let totalPages = Math.ceil(<?php echo count($students); ?> / studentsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                filterStudents(<?php echo json_encode($students); ?>);
            }
        }

        function createActionButton(title, className, iconClass, link) {
            let button = document.createElement('a');
            button.href = link;
            button.className = 'action-btn ' + className;
            button.title = title;

            let icon = document.createElement('i');
            icon.className = iconClass;

            button.appendChild(icon);

            return button;
        }
    </script>
<script src="script.js"></script>
</body>
</html>
