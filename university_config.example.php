<?php
$host = "your_database_host";
$user = "your_database_username";
$password = "your_password";
$database = "your_db_name";

$university_connection = new mysqli($host, $user, $password, $database);
if ($university_connection->connect_error) {
    die("Connection to university DB failed: ". $university_connection->connect_error);
};
?>