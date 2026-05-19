<?php

require_once '../PHP/connectdb.php';
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
    <title>CHAMPION GEAR - HOME</title>
    <link rel="stylesheet" href="../CSS/product_page.css">
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
            <a href="../PHP/basketball.php"><i class="fa fa-fw fa-basketball"></i>Basketball</a>
            <a href="../PHP/cricket.php"><i class="fa-regular fa-cricket-bat-ball"></i>Cricket</a>
            <a href="../PHP/tennis.php"><i class="fa-regular fa-racquet"></i>Tennis</a>
        </div>
    </nav>

    <div class="product-section">
        <div class="product-container">
            <?php
                if (isset($_POST['search-button'])) {
                    $input = $_POST['input'];
                    if (!empty($input)) {
                        $sql = "SELECT * FROM products WHERE name LIKE '%$input%' OR category LIKE '%$input%' OR brand LIKE '%$input%' OR description LIKE '%$input%'";
                        $result = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                                <div class="product-card" data-id="<?php echo $row['productId']; ?>">
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($row['image']); ?>" alt="Product Image">
                                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                                    <p class="price">£<?php echo htmlspecialchars($row['price']); ?></p>
                                    <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                                    <div class="quantity-control">
                                        <button type="button" class="minus">-</button>
                                        <input type="hidden" name="quantity" class="quantity-input" value="1"> <!-- Hidden input for form submission -->
                                        <span class="quantity-display">1</span> <!-- Visual display -->
                                        <button type="button" class="plus">+</button>
                                    </div>
                                    <form action="../PHP/addCartProduct.php" method="POST" class="cart-form">
                                        <input type="hidden" name="productId" value="<?php echo $row['productId']; ?>">
                                        <input type="hidden" name="quantity" class="cart-quantity" value="1">
                                        <button type="submit" name="cart" class="add-to-cart">Add to Cart</button>
                                    </form>
                                    <form action="../PHP/addWishlistProduct.php" method="POST" class="wishlist-form">
                                        <input type="hidden" name="productId" value="<?php echo $row['productId']; ?>">
                                        <button type="submit" name="wishlist" class="add-to-wishlist">Add to Wishlist</button>
                                    </form>
                                </div>
            <?php
                            }
                        }
                    }
                } else {
                    echo '<h2>No Match Found</h2>';
                }
            ?>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.quantity-control').forEach(control => {
            const minusBtn = control.querySelector('.minus');
            const plusBtn = control.querySelector('.plus');
            const quantityInput = control.querySelector('.quantity-input');
            const quantityDisplay = control.querySelector('.quantity-display');
            
            minusBtn.addEventListener('click', () => {
                let qty = parseInt(quantityInput.value);
                if (qty > 1) {
                    qty--;
                    quantityInput.value = qty;
                    quantityDisplay.textContent = qty;
                }
            });
            
            plusBtn.addEventListener('click', () => {
                let qty = parseInt(quantityInput.value);
                qty++;
                quantityInput.value = qty;
                quantityDisplay.textContent = qty;
            });
        });

        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const productId = this.getAttribute('data-product-id');
                const quantity = this.closest('.product-card')
                                .querySelector('.quantity-input').value;
                
                fetch('../PHP/addCartProduct.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `cart=1&productId=${productId}&quantity=${quantity}`
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success) {
                        const cartCounter = document.querySelector('.shopping-cart .quantity');
                        cartCounter.textContent = parseInt(cartCounter.textContent) + parseInt(quantity);
                        
                        const feedback = document.createElement('div');
                        feedback.className = 'cart-feedback';
                        feedback.textContent = 'Added to cart!';
                        this.parentElement.appendChild(feedback);
                        setTimeout(() => feedback.remove(), 2000);
                    } else if(data.redirect) {
                        window.location.href = data.redirect;
                    }
                });
            });
        });
    });
    </script>

</body>

</html>