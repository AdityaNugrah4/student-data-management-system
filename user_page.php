<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    // Not logged in
    header("Location: index.php");
    exit();
};

// Fetch the user’s name
require_once 'university_config.php';
$students_result = $university_connection->query("SELECT * FROM students ORDER BY student_id ASC");

// Keep it for documentation
require_once 'config.php';
$stmt = $connection->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$stmt->bind_result($name);
$stmt->fetch();
$stmt->close();

$search_term = ''; // to initialize search term
$sql = "SELECT student_id, name, gender, faculty, major, year_enrolled FROM students";

if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
    $search_term = trim($_GET['search']);

    $sql .= " WHERE student_id LIKE ? OR name LIKE ? OR faculty LIKE ? OR major LIKE ?";
    $search_query = "%" . $search_term . "%";

    $stmt = $university_connection->prepare($sql);
    $stmt->bind_param("ssss", $search_query, $search_query, $search_query, $search_query); // To bind search to all 4 placeholders
    $stmt->execute();
    $students_result = $stmt->get_result();
} else {
    $sql .= " ORDER BY student_id ASC";
    $students_result = $university_connection->query($sql);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="box">
        <h1>Welcome <span><?= $name; ?></span></h1>
        <p>This is an <span>user</span> page</p>
        <hr>
        <div class="box">
            <h1>Find student</h1>
            <form action="user_page.php" method="GET">
                <button type="submit">Search</button>
                <input type="text" name="search" placeholder="Search by ID, name, faculty, or major" value="<?= htmlspecialchars($search_term); ?>" class="search-bar">
                <button type="button" onclick="window.location.href='user_page.php'">Clear search</button> 
            </form>
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
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <hr>
            <!-- This should be the table to display the information from SQL that contain student information -->
        </div>
        <button onclick="window.location.href='logout.php'" class="logout">Logout</button>
    </div>
</body>
</html>