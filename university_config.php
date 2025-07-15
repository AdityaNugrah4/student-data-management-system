<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "university_db";

$university_connection = new mysqli($host, $user, $password, $database);
if ($university_connection->connect_error) {
    die("Connection to university DB failed: ". $university_connection->connect_error);
};
?>