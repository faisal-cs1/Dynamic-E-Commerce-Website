<?php

require_once "connectdb.php";
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: ../HTML/login_page.html");
    exit();
}

$userId = $_SESSION['userId'];
$userData = "SELECT fullName, email, password, phoneNumber FROM users WHERE userId = $userId";
$result = mysqli_query($conn, $userData);

if ($result && mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $fullName = htmlspecialchars($user['fullName']);
    $email = htmlspecialchars($user['email']);
    $password = htmlspecialchars($user['password']);
    $phoneNumber = htmlspecialchars($user['phoneNumber']);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../CSS/profile_page.css">
</head>

<body>
    <nav class="navbar">
        <div class="logo-slogan">
            <img src="../Assets/logo.png" alt="Logo image">
            <h1>GEAR UP FOR GREATNESS</h1>
        </div>

        <div class="search-container">
            <form method="POST" action="../PHP/search.php" class="search-bar">
                <input type="text" placeholder="Search.." name="input">
                <button type="submit" class="search-button" name="search-button"><i class="fas fa-search"></i></button>
            </form>
        </div>

        <div class="navbar-links">
            <a href="../PHP/home.php"><i class="fa fa-fw fa-home"></i></a>
            <a href="../PHP/wishlist.php"><i class="fa fa-fw fa-heart"></i></a>
            <div class="shopping-cart">
                <a href="../PHP/cart.php"><i class="fa fa-fw fa-shopping-cart"></i></a>
                <span class="quantity">0</span>
            </div>
            
            <div class="profile-menu">
                <button class="profile-button"><i class="fa fa-fw fa-user"></i></button>
                <div class="menu-content">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true): ?>
                        <a href="../PHP/profile.php">Profile</a>
                        <a href="../PHP/logout.php">Logout</a>
                    <?php else: ?>
                        <a href="../HTML/signup_page.html">Sign Up</a>
                        <a href="../HTML/login_page.html">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <nav class="sports-bar">
        <div class="sports">
            <a href="#"><i class="fa fa-fw fa-soccer-ball"></i>Football</a>
            <a href="#"><i class="fa fa-fw fa-basketball"></i>Basketball</a>
            <a href="#"><i class="fa-regular fa-cricket-bat-ball"></i></i>Cricket</a>
            <a href="tennis.html"><i class="fa-regular fa-racquet"></i>Tennis</a>
        </div>
    </nav>

    <div class="profile">
        <img src="../Assets/profile.png" alt="Profile image">
        
        <div>
            <label for="fullName">Full Name:</label>
            <input id="fullName" name="fullName" type="text" value="<?php echo $fullName; ?>" readonly>
        </div>
        
        <div>
            <label for="email">Email:</label>
            <input id="email" name="email" type="email" value="<?php echo $email; ?>" readonly>
        </div>
        
        <div>
            <label for="password">Password:</label>
            <input id="password" name="password" type="password" value="<?php echo $password; ?>" readonly>
        </div>
        
        <div>
            <label for="phoneNumber">Contact number:</label>
            <input id="phoneNumber" name="phoneNumber" type="tel" value="<?php echo $phoneNumber; ?>" readonly>
        </div>
    </div>

    <div class="footer">
        <div class="footer-column">
            <h2>Contact Us</h2>
            <hr>
            <div class="contact-details">
                <a href="#"><i class="fa-solid fa-location-dot"></i>PO BOX 147, Bradford, BD7 1AY</a>
                <br>
                <a href="#"><i class="fa-solid fa-phone"></i>01274 247 247</a>
                <br>
                <a href="#"><i class="fa-solid fa-envelope"></i>championsgear@online.uk</a>
            </div>
        </div>

        <div class="footer-column">
            <h2>About Us</h2>
            <hr>
            <div class="about-us">
                <a href="Page2.html">Our History</a>
            </div>
        </div>

        <div class="footer-column">
            <h2>Terms & Conditions</h2>
            <hr>
            <div class="T&C">
                <a href="tcr.html">Returns</a>
            </div>
        </div>

        <div class="footer-column">
            <h2>Social Media</h2>
            <hr>
            <div class="social-media">
                <a href="#"><i class="fa-brands fa-facebook"></i>Facebook</a>
                <br>
                <a href="#"><i class="fa-brands fa-instagram"></i>Instagram</a>
                <br>
                <a href="#"><i class="fa-brands fa-x-twitter"></i>Twitter</a>
                <br>
                <a href="#"><i class="fa-brands fa-tiktok"></i>TikTok</a>
            </div>
        </div>

        <div class="footer-copyright">
            <p>Champions Gear - University of Bradford 2025, All Rights Reserved ©</p>
        </div>
    </div>

</body>

</html>