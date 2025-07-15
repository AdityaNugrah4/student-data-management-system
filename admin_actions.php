<?php
session_start();
require_once 'university_config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { // To check if the user is admin
    die("Access denied. You must be an admin to perform this action.");
};

// Action to add new student information
if (isset($_POST['create_student'])) {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $major = $_POST['major'];
    $year_enrolled = $_POST['year_enrolled'];

    $stmt = $university_connection->prepare("INSERT INTO students (student_id, name, gender, faculty, major, year_enrolled) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $student_id, $name, $gender, $faculty, $major, $year_enrolled);
    $stmt->execute();
    $stmt->close();
};

// Action to edit or update sudent information
if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $gender = $_POST['gender'];
    $faculty = $_POST['faculty'];
    $major = $_POST['major'];
    $year_enrolled = $_POST['year_enrolled'];

    $stmt = $university_connection->prepare("UPDATE students SET student_id = ?, name = ?, gender = ?, faculty = ?, major = ?, year_enrolled = ? WHERE id = ?");
    $stmt->bind_param("sssssii", $student_id, $name, $gender, $faculty, $major, $year_enrolled, $id);
    $stmt->execute();
    $stmt->close();
};

// Action to delete unused student information
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $university_connection->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}

header("Location: admin_page.php");
exit();

?>