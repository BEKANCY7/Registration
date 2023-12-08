<!-- student_list.php -->

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
    </style>
</head>
<body>

    <h2>Student Information List</h2>

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
    ?>

    <table>
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

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['StudentID'] . '</td>
                        <td>' . $row['FirstName'] . '</td>
                        <td>' . $row['LastName'] . '</td>
                        <td>' . $row['Gender'] . '</td>
                        <td>' . $row['DateOfBirth'] . '</td>
                        <td>' . $row['Grade'] . '</td>
                        <td>' . $row['SchoolName'] . '</td>
                        <td>
                            <a href="edit_form.php?StudentID=' . $row['StudentID'] . '" class="action-btn edit-btn" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="delete_student.php?id=' . $row['StudentID'] . '" class="action-btn delete-btn" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <a href="view_student.php?id=' . $row['StudentID'] . '" class="action-btn view-btn" title="View">
    <i class="fas fa-eye"></i>
</a>

                        </td>
                    </tr>';
            }
        } else {
            echo "No records found.";
        }

        $conn->close();
        ?>

    </table>

</body>
</html>
