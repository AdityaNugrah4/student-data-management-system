<?php
session_start();
require_once 'university_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { // Security check
    die("Access denied.");
}

$student_id_to_edit = $_GET['id'];
$stmt = $university_connection->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id_to_edit);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    die("Student not found");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit student information</title>
</head>
<body class="box">
    <h1>Edit Student: <?= $student['name'] ?></h1>
    <form action="admin_actions.php" method="post">
        <input type="hidden" name="id" value="<?= $student['id'] ?>">

        <label>Student ID:</label>
        <input type="text" name="student_id" value="<?= htmlspecialchars($student['student_id']) ?>" required>

        <label>Name:</label>
        <input type="text" name="name" value="<?= htmlspecialchars($student['name'])?>" required>

        <label>Gender:</label>
        <select name="gender" required>
            <option value="M" <?= $student['gender'] === 'M' ? 'selected' : '' ?>>Male</option>
            <option value="F" <?= $student['gender'] === 'F' ? 'selected' : '' ?>>Female</option>
        </select>

        <label>Faculty</label>
        <input type="text" name="faculty" value=" <?= htmlspecialchars($student['faculty']) ?>" required>

        <label>Major:</label>
        <input type="text" name="major" value="<?= htmlspecialchars($student['major']) ?>" required>
            
        <label>Year Enrolled:</label>
        <input type="number" name="year_enrolled" value="<?= htmlspecialchars($student['year_enrolled']) ?>" required>

        <button type="submit" name="update_student">Update Student</button>
        <a href="admin_page.php">Cancel</a>
    </form>
</body>
</html>