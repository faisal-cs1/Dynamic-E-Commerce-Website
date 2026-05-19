<?php

require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <link rel="stylesheet" href="../CSS/customers.css">
    <script src="../JavaScript/removeCustomers.js"></script>

</head>

<body>
    <nav id="navbar" class="navbar">
        <div class="logo-slogan">
            <img src="../Assets/logo.png" alt="Logo image">
            <h1>GEAR UP FOR GREATNESS</h1>
        </div>

        <div class="navbar-links">
            <a href="../PHP/home.php" target="_blank"><i class="fa fa-solid fa-globe"></i></a>

            <div class="profile-menu">
                <button class="profile-button"><i class="fa fa-fw fa-user"></i></button>
                <div class="menu-content">
                    <a href="../PHP/profile.php">Profile</a>
                    <a href="../PHP/logout.php">Logout</a>
                </div>
            </div>
        </div>
    </nav>

    <div id="mySidenav" class="sidenav">
        <h1>Admin Menu</h1>
        <a href="../PHP/customers.php">Customers</a>
        <a href="../PHP/admins.php">Admins</a>
        <a href="../PHP/products.php">Website Products</a>
        <a href="../PHP/orders.php">Orders</a>
        <a href="../PHP/cartProducts.php">Cart Products</a>
        <a href="../PHP/wishlistProducts.php">Wishlist Products</a>
    </div>

    <div id="open-button" class="open-button">
        <i id="open-nav" class="fa-solid fa-square-chevron-right" onclick="toggleNav()"></i>
        <p id="menu">Menu</p>
    </div>

    <div id="main" class="main">
        <h2>Admins</h2>

        <div class="add-button">
            <button id="add-customer" class="add-customer" onclick="addAdmin()">Add Admin</button>
        </div>
        <div id="signUp-container" class="signUp-container">
            <form action="../PHP/addAdmin.php" method="POST" class="signUpForm" id="signUpForm">
                
                <div class="input_container">
                    <label for="email">Email: * </label>
                    <input 
                        id="email"
                        name="email"
                        placeholder="Enter your email"
                        type="email"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="password">Password: * </label>
                    <input 
                        id="password"
                        name="password"
                        placeholder="Enter your password"
                        type="password"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="fullName">Full Name: * </label>
                    <input 
                        id="fullName"
                        name="fullName"
                        placeholder="Enter your full name"
                        type="text"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="phoneNumber">Contact number: * </label>
                    <input 
                        id="phoneNumber"
                        name="phoneNumber"
                        placeholder="Enter your contact number"
                        type="tel"
                        class="form_input"
                        maxlength="11"
                        pattern="^(\+44\s?7\d{3}|\(?07\d{3}\)?)\s?\d{3}\s?\d{3}$" 
                        title="Enter a valid UK phone number" 
                        required>
                </div>

                <div class="signUp-button">
                    <button type="submit" class="submit-button" name="signup">Submit</button>
                </div>
            </form>
        </div>

        <table id="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Phone Number</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                    $sql = "SELECT * FROM users WHERE userType = 'admin'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                ?>
                            <tr>
                                <td>
                                    <p><?php echo htmlspecialchars($row['userId']); ?></p>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($row['fullName']); ?></p>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($row['email']); ?></p>
                                </td>
                                <td>
                                    <input id="password" name="password" type="password" value="<?php echo htmlspecialchars($row['password']); ?>" readonly>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($row['phoneNumber']); ?></p>
                                </td>
                                <td>
                                    <button id="remove" class="remove-button" onclick="removeCustomer(<?php echo $row['userId']; ?>); reloadPage();">Remove</button>
                                </td>
                            </tr>
                <?php
                        }
                    } else {
                        echo "<tr><td colspan='6'>No Users</td></tr>";
                    }
                ?>               
            </tbody>
        </table>
        <div class="summary">
            <h2>Total Customers: <?php echo mysqli_num_rows($result); ?></h2>
        </div>
    </div>

    <script>
        function toggleNav() {
            if (document.getElementById("mySidenav").style.width === "20rem") {
                document.getElementById("mySidenav").style.width = "0";
                document.getElementById("open-button").style.marginLeft = "0";
                document.getElementById("open-nav").style.rotate = "0deg";
                document.getElementById("navbar").style.width = "100%";
                document.getElementById("navbar").style.marginLeft = "0";
                document.getElementById("navbar").style.paddingRight = "0";
                document.getElementById("main").style.marginLeft = "0";
                document.getElementById("signUp-container").style.height = "15rem";
            } else {
                document.getElementById("mySidenav").style.width = "20rem";
                document.getElementById("open-button").style.marginLeft = "20rem";
                document.getElementById("open-nav").style.rotate = "180deg";
                document.getElementById("navbar").style.width = "85%";
                document.getElementById("navbar").style.marginLeft = "20rem";
                document.getElementById("navbar").style.paddingRight = "20rem";
                document.getElementById("main").style.marginLeft = "20rem";
                document.getElementById("signUp-container").style.height = "25rem";
            }
        }

        function addAdmin() {
            if (document.getElementById("signUp-container").style.height === "15rem") {
                document.getElementById("signUp-container").style.height = "0";
                document.getElementById("table").style.marginBottom = "2rem";
            } else {
                document.getElementById("signUp-container").style.height = "15rem";
                document.getElementById("table").style.marginBottom = "2rem";
            }
        }
    </script>
</body>

</html>