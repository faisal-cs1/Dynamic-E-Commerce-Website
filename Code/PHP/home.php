<?php
require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="../CSS/home_page.css">
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
            <a href="../PHP/cart.php"><i class="fa fa-fw fa-shopping-cart"></i></a>
            
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
            <a href="../PHP/football.php"><i class="fa fa-fw fa-soccer-ball"></i>Football</a>
            <a href="../PHP/cricket.php"><i class="fa-regular fa-cricket-bat-ball"></i></i>Cricket</a>
            <a href="../PHP/tennis.php"><i class="fa-regular fa-racquet"></i>Tennis</a>
        </div>
    </nav>

    <video autoplay loop muted>
        <source src="../Assets/video.mp4" type="video/mp4">
    </video>

    <main class="about-section" id="about-section">
        <section class="about-content">
            <h2>About Champions Gear</h2>
            <p>Welcome to Champions Gear — your ultimate destination for top-quality sports equipment and apparel. Whether you're on the pitch, the court, or the field, we’re here to help you perform at your peak.</p>

            <h3>Our Mission</h3>
            <p>We believe that every athlete deserves access to the best gear. Our mission is to empower athletes of all levels by providing reliable, affordable, and high-performance equipment that fuels their passion for the game.</p>

            <h3>What We Offer</h3>
            <p>From football boots and basketballs to cricket bats and tennis racquets, Champions Gear stocks premium sports products tailored for both amateurs and pros. Our catalog is constantly expanding to meet the evolving needs of our customers.</p>

            <h3>Our Journey</h3>
            <p>Founded in the heart of Bradford, Champions Gear is driven by a shared love for sport and innovation, we’ve built a community of champions from all walks of life.</p>

            <h3>Join the Movement</h3>
            <p>Whether you're training for a championship or just staying active, gear up with us and elevate your game. Explore our products, follow us on social media, and become part of the Champions Gear family.</p>
        </section>
    </main>

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
                <a href="#about-section">About Champions Gear</a>
            </div>
        </div>

        <div class="footer-column">
            <h2>Social Media</h2>
            <hr>
            <div class="social-media">
                <a href=""><i class="fa-brands fa-facebook"></i>Facebook</a>
                <br>
                <a href=""><i class="fa-brands fa-instagram"></i>Instagram</a>
                <br>
                <a href=""><i class="fa-brands fa-x-twitter"></i>Twitter</a>
                <br>
                <a href=""><i class="fa-brands fa-tiktok"></i>TikTok</a>
            </div>
        </div>

        <div class="footer-copyright">
            <p>Champions Gear - University of Bradford 2025, All Rights Reserved ©</p>
        </div>
    </div>

</body>

</html>