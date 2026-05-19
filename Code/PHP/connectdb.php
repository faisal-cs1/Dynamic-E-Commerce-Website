<?php

$host = "localhost"; // Default host name
$username = "root"; // Default username
$password = ""; // Default password
$database = "champions_gear"; // The name of our database

// Establishes a connection with the database mentioned above
$conn = new mysqli($host, $username, $password, $database);

// If the connection fails the following error will be displayed
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>