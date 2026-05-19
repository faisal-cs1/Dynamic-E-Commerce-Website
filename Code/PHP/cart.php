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
    <link rel="stylesheet" href="../CSS/cart_page.css">
    <script src="../JavaScript/removeCartProduct.js"></script>
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
                <span id="cartTotalItems" class="quantity"><?php echo $cartTotalItems; ?></span>
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
            <a href="../PHP/cricket.php"><i class="fa-regular fa-cricket-bat-ball"></i></i>Cricket</a>
            <a href="tennis.html"><i class="fa-regular fa-racquet"></i>Tennis</a>
        </div>
    </nav>

    <div class="cart-container">
        <h2>Your Shopping Cart</h2>

        <table>
            <thead>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                $sql = "SELECT * FROM cart_products WHERE customerId = $userId";
                $cartData = mysqli_query($conn, $sql);
                $cartTotal = 0;
                if (mysqli_num_rows($cartData) > 0) {
                    while ($item = mysqli_fetch_assoc($cartData)) {
                        $itemTotal  = $item['productPrice'] * $item['productQuantity'];
                        $cartTotal += $itemTotal;
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
                            <td class="quantity-control">
                            <div class="quantity-control">
                                <span class="quantity-display"><?php echo htmlspecialchars($item['productQuantity']); ?></span>
                            </td>
                            <td>
                                <p class="price">£<?php echo number_format($itemTotal, 2); ?></p>
                            </td>
                            <td>
                                <button id="remove" class="remove-button" onclick="removeItem(<?php echo $item['productId']; ?>); reloadPage();">Remove</button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>Your cart is empty.</td></tr>";
                }
                ?>               
            </tbody>
        </table>
        <div class="summary">
            <h2 id="cartTotalItems">Total Items: <?php echo $cartTotalItems; ?></h2>
            <h2>Cart Total: £<?php echo number_format($cartTotal, 2); ?></h2>
        </div>

        <div class="checkout">
            <button id="checkout-button" class="checkout-button" onclick="openPayment()">Proceed to Checkout</button>
        </div>
        <div id="payment-container" class="payment-container">
            <form action="../PHP/addOrder.php" method="POST" class="payment-form" id="payment-form">
                <?php
                    $sql = "SELECT * FROM cart_products WHERE customerId = $userId";
                    $cartData = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($cartData)) {
                        while ($item = mysqli_fetch_assoc($cartData)) {
                ?>
                        <input type="hidden" name="productId" value="<?php echo $item['productId']; ?>">
                        <input type="hidden" name="productName" value="<?php echo htmlspecialchars($item['productName']); ?>">
                        <input type="hidden" name="productCategory" value="<?php echo htmlspecialchars($item['productCategory']); ?>">
                        <input type="hidden" name="productPrice" value="<?php echo $item['productPrice']; ?>">
                        <input type="hidden" name="productQuantity" value="<?php echo $item['productQuantity']; ?>">
                        <input type="hidden" name="productImage" value="<?php echo base64_encode($item['productImage']); ?>">
                <?php
                    }
                }
                ?>
                    <div class="columns-container">
                        <div class="left-column">
                            <div class="form-group">
                                <label for="title">Title</label>
                                    <select id="title" name="title" required>
                                        <option value="" disabled selected>Select Title</option>
                                        <option value="Mr">Mr</option>
                                        <option value="Miss">Miss</option>
                                        <option value="Ms">Ms</option>
                                        <option value="Mrs">Mrs</option>
                                        <option value="Dr">Dr</option>
                                        <option value="Prof">Prof</option>
                                    </select>
                            </div>
                            <div class="form-group">
                                <label for="forename">Forename</label>
                                <input type="text" id="forename" name="forename" placeholder="Enter your Forename" required>   
                            </div>
                            <div class="form-group">
                                <label for="surname">Surname</label>
                                <input type="text" id="surname" name="surname" placeholder="Enter your Surname" required>
                            </div>
                            <div class="form-group">
                                <label for="door-number">Door Number</label>
                                <input type="text" id="door-number" name="door-number" placeholder="Enter your Door Number" required>
                            </div>
                            <div class="form-group">
                                <label for="street">Street/Road</label>
                                <input type="text" id="street" name="street" placeholder="Enter your Street/Road" required>
                            </div>
                        </div>

                        <div class="right-column">
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" id="city" name="city" placeholder="Enter your City" required>
                            </div>
                            <div class="form-group">
                                    <label for="postcode">Postcode</label>
                                    <input type="text" id="postcode" name="postcode" placeholder="Enter your Postcode" required>
                            </div>            
                            <div class="form-group">
                                <label for="card-number">Card Number</label>
                                <input type="text" id="card-number" name="card-number" placeholder="Enter your 16-digit card number" maxlength="16" pattern="\d{16}" required title="Please enter a valid 16-digit card number">
                            </div>
                            <div class="form-group">
                                <label for="expiry-date">Expiry Date (MM/YY)</label>
                                <input type="text" id="expiry-date" name="expiry-date" placeholder="MM/YY" maxlength="5" pattern="(0[1-9]|1[0-2])\/\d{2}" required title="Please enter a valid expiry date (MM/YY)">
                            </div>
                            <div class="form-group">
                                <label for="cvv">CVV</label>
                                <input type="text" id="cvv" name="cvv" placeholder="Enter 3-digit CVV" maxlength="3" pattern="\d{3}" required title="Please enter a valid 3-digit CVV">
                            </div>    
                        </div>    
                    </div>


                    <div class="payment-footer">
                        <button type="submit" id="proceed-button" class="proceed-button" name="proceed-button">Proceed to Payment</button>
                    </div>       
            </form>
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

        <div class="footer-copyright">
            <p>Champions Gear - University of Bradford 2025, All Rights Reserved ©</p>
        </div>
    </div>

    <script>
        function openPayment() {
            if (document.getElementById("payment-container").style.height === "40rem") {
                document.getElementById("payment-container").style.height = "0";
            } else {
                document.getElementById("payment-container").style.height = "40rem";
            }
        }
    </script>
</body>


</html>