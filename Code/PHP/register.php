<?php
require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Checks if the HTTP request method for the form submitted is POST.
    if (isset($_POST["signup"])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phoneNumber'];

        $sql = "SELECT * FROM users WHERE email = '$email' OR phoneNumber = '$phoneNumber'";

        $insertToTable = "INSERT INTO users (fullName, email, password, phoneNumber) VALUES ('$fullName', '$email', '$password', '$phoneNumber')";
        if (mysqli_query($conn, $insertToTable)) {
            echo '<script>alert("Registered successfully! Please Login.");</script>';
            echo '<script>window.location.href = "../HTML/login_page.html";</script>';
        } else { 
            echo "Error adding user: " . mysqli_error($conn); 
        }  
    }
}
?>