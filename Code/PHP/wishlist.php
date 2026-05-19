<?php

require_once '../PHP/connectdb.php'; // Ensures that the database is connected using the connectdb.php which has already created a connection with the database.
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: ../HTML/login_page.html");
    exit();
}

$userId = $_SESSION['userId'];

$wishlistTable = "SELECT * FROM wishlist_products WHERE customerId = $userId";
$wishlistData = mysqli_query($conn, $wishlistTable);
$wishlistTotalItems = 0;if (mysqli_num_rows($wishlistData) > 0) {
    while ($item = mysqli_fetch_assoc($wishlistData)) {
        $wishlistTotalItems ++;
    }
}

$sql = "SELECT * FROM cart_products WHERE customerId = $userId";
$cartData = mysqli_query($conn, $sql);
$cartTotalItems = 0;
if (mysqli_num_rows($cartData) > 0) {
    while ($item = mysqli_fetch_assoc($cartData)) {
        $cartTotalItems += $item['productQuantity'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link rel="stylesheet" href="../CSS/wishlist_page.css">
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
            <div class="wishlist">
                <a href="../PHP/wishlist.php"><i class="fa fa-fw fa-heart"></i></a>
                <span class="quantity"><?php echo $wishlistTotalItems; ?></span>
            </div>
            <div class="shopping-cart">
                <a href="../PHP/cart.php"><i class="fa fa-fw fa-shopping-cart"></i></a>
                <span class="quantity"><?php echo $cartTotalItems; ?></span>
            </div>

            <div class="profile-menu">
                <button class="profile-button"><i class="fa fa-fw fa-user"></i></button>
                <div class="menu-content">
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) { ?>
                    <a href="../PHP/profile.php">Profile</a>
                    <a href="../PHP/logout.php">Logout</a>
                    <?php } else { ?>
                    <a href="../HTML/signup_page.html">Sign Up</a>
                    <a href="../HTML/login_page.html">Login</a>
                    <?php } ?>
                </div>
            </div>
        </div>
    </nav>

    <nav class="sports-bar">
        <div class="sports">
            <a href="../PHP/football.php"><i class="fa fa-fw fa-soccer-ball"></i>Football</a>
            <a href="#"><i class="fa fa-fw fa-basketball"></i>Basketball</a>
            <a href="#"><i class="fa-regular fa-cricket-bat-ball"></i></i>Cricket</a>
            <a href="tennis.html"><i class="fa-regular fa-racquet"></i>Tennis</a>
        </div>
    </nav>

    <div class="wishlist-container">
        <h2>Your Wishlist</h2>

        <table>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Remove/Add to Cart</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $wishlistTotal = 0;
                $totalItems = 0;
                $wishlistTable = "SELECT * FROM wishlist_products WHERE customerId = $userId";
                $wishlistData = mysqli_query($conn, $wishlistTable);
                if (mysqli_num_rows($wishlistData) > 0) {
                    while ($item = mysqli_fetch_assoc($wishlistData)) {
                        $wishlistTotalItems ++;
                    
                ?>
                        <tr>
                            <td>
                                <img src="data:image/jpeg;base64,<?php echo base64_encode($item['productImage']); ?>" alt="Product Image">
                            </td>
                            <td>
                                <p><?php echo htmlspecialchars($item['productName']); ?></p>
                            </td>
                            <td>
                                <p class="price">£<?php echo htmlspecialchars($item['productPrice']); ?></p>
                            </td>
                            <td class="buttons">
                                <form action="../PHP/removeWishlist.php" method="POST" class="remove-form">
                                    <input type="hidden" name="productId" value="<?php echo $item['productId']; ?>">
                                    <button type="submit" class="remove-button">Remove</button>
                                </form>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4'>Your wishlist is empty.</td></tr>";
                }
                ?>               
            </tbody>
        </table>
        <div class="summary">
            <h2>Total Items: <?php echo $totalItems; ?></h2>
            <h2>Wishlist Total: £<?php echo number_format($wishlistTotal, 2); ?></h2>
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

</body>

</html>