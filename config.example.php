<?php
$host = "your_database_host";
$user = "your_database_username";
$password = "your_password";
$database = "your_db_name";

$connection = new mysqli($host, $user, $password, $database);

if ($connection->connect_error) {
    die("Connection failed: ". $connection->connect_error);
}

?>