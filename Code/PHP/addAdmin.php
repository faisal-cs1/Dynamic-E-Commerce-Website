<?php
require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Checks if the HTTP request method for the form submitted is POST.
    if (isset($_POST["signup"])) {
        $fullName = $_POST['fullName'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $phoneNumber = $_POST['phoneNumber'];

        $sql = "SELECT * FROM users WHERE email = '$email' OR phoneNumber = '$phoneNumber'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo '<script>alert("Admin already exists!");</script>';
            echo '<script>window.location.href = "../PHP/admins.php";</script>';
        } else {
            $insertToTable = "INSERT INTO users (fullName, email, password, phoneNumber, userType) VALUES ('$fullName', '$email', '$password', '$phoneNumber', 'admin')";
            if (mysqli_query($conn, $insertToTable)) {
                echo '<script>alert("Admin added successfully!");</script>';
                echo '<script>window.location.href = "../PHP/admins.php";</script>';
            } else { 
                echo "Error adding user: " . mysqli_error($conn); 
            } 
        }
    }
}
?>