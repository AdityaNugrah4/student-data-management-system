<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Not logged in
    header("Location: index.php");
    exit();
}

require_once 'university_config.php';
$students_result = $university_connection->query("SELECT * FROM students ORDER BY student_id ASC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h1>Welcome <span><?= $_SESSION['name']; ?></span></h1>
        <p>This is an <span>admin</span> page</p>
        <hr>
        <div class="box">
            <h1>Student</h1>
            <table>
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Faculty</th>
                        <th>Major</th>
                        <th>Year</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $students_result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['student_id']); ?></td>
                            <td><?= htmlspecialchars($row['name']); ?></td>
                            <td><?= htmlspecialchars($row['gender']); ?></td>
                            <td><?= htmlspecialchars($row['faculty']); ?></td>
                            <td><?= htmlspecialchars($row['major']); ?></td>
                            <td><?= htmlspecialchars($row['year_enrolled']); ?></td>
                            <td>
                                <a href="edit_student.php?id=<?= $row['id'] ?>">Edit</a>
                                <a href="admin_actions.php?action=delete&id=<?= $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this data?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <!-- This should be the table to display the information from SQL that contain student information -->
        </div>
        <hr>
        <div class="box">
            <h1>Adding new data</h1>
            <form action="admin_actions.php" method="post">
                <button type="submit" name="create_student">Add Student</button>
                <input type="text" name="student_id" placeholder="Student ID (e.g., S2021999)" required>
                <input type="text" name="name" placeholder="Full Name" required>
                <select name="gender">
                    <option value="">--Select Gender--</option>
                    <option value="M">Male</option>
                    <option value="F">Female</option>
                </select>
                <input type="text" name="faculty" placeholder="Faculty" required>
                <input type="text" name="major" placeholder="Major" required>
                <input type="number" name="year_enrolled" placeholder="Year Enrolled (e.g., 2024)" required>
            </form>
        </div>
        <hr>
        <button onclick="window.location.href='logout.php'">Logout</button>
    </div>
    </div>
    
</body>
</html>