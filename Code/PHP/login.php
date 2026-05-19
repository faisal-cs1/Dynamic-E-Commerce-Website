<?php

require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Checks if the HTTP request method for the form submitted is POST.
    if (isset($_POST["login"])) { // Checks if the form was submitted using the 'login' button which is defined in the login_form.html with name='login.
        $email = $_POST['email']; // Takes the value inputted for the email into the login form and stores it in the $email.
        $password = $_POST['password']; // Takes value inputted for the password into the login form and stores it in the $password.
        
        $checkEmail =  "SELECT * FROM users WHERE email = '$email'"; // This is a SQL query stored as a string in $checkEmail. Takes all the data from the users table where the email matches the value stored in $email (the inputted email in the form).
        $emailExist = mysqli_query($conn, $checkEmail); // Checks if the email inputted exists in the database.

        if (mysqli_num_rows($emailExist) > 0) { // Returns the number of rows that contains the inputted email and checks that if they are greater than 0. 
            $checkPassword =  "SELECT * FROM users WHERE email = '$email' AND password = '$password'"; // This is a SQL query stored as a string in $checkPassword. Takes all the data from the users table where the password matches the values stored in $email and $password (the inputted values in the form).
            $result = mysqli_query($conn, $checkPassword); // Checks if the password inputted exists in the database.
            
            if (mysqli_num_rows($result) > 0) { // Returns the number of rows that contains the inputted password and checks that if they are greater than 0. 
                $user = mysqli_fetch_assoc($result);
                $_SESSION['loggedin'] = true; // Indicates that the user is logged in.
                $_SESSION['email'] = $user['email'];
                $_SESSION['userId'] = $user['userId'];
                $_SESSION['userType'] = $user['userType'];


                if ($_SESSION['userType'] === 'admin') {
                    header("Location: ../PHP/customers.php");
                } else {
                    header("Location: ../PHP/home.php");
                }
                
                exit(); // Avoid any code being executed after the user gets to the homepage.

            } else {
                echo '<script>alert("The password you entered is incorrect. Please try again.");</script>'; // Uses JavaScript to display a pop-up message to inform the user that the password entered is incorrect.
                echo '<script>window.location.href = "../HTML/login_page.html";</script>'; // Uses JavaScript to redirect the user to the login page after the pop-up message.
                exit(); // Avoid any code being executed after the user gets to the login page.
            }

        } else {
            echo '<script>alert("The email address is not registered. Please sign up.");</script>'; // Uses JavaScript to display a pop-up message to inform the user that the email entered is not registered.
            echo '<script>window.location.href = "../HTML/signup_page.html";</script>'; // Uses JavaScript to redirect the user to sign up page after the pop-up message.
            exit(); // Avoid any code being executed after the user gets to the sign up page.
        }
    }
}
?>