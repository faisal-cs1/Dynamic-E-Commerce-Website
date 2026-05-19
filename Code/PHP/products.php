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
    <script src="../JavaScript/removeProduct.js"></script>

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
        <h2>Products</h2>

        <div class="add-button">
            <button id="add-customer" class="add-customer" onclick="addProduct()">Add Product</button>
        </div>
        <div id="signUp-container" class="signUp-container">
            <form action="../PHP/addProduct.php" method="POST" class="signUpForm" id="signUpForm" enctype="multipart/form-data">

                <div class="input_container">
                    <label for="name">Product Name: * </label>
                    <input 
                        id="name"
                        name="name"
                        placeholder="Enter product name"
                        type="text"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="category">Product Category: * </label>
                    <select name="category" id="category" class="form_input">
                        <option value="Football">Football</option>
                        <option value="Basketball">Basketball</option>
                        <option value="Cricket">Cricket</option>
                        <option value="Tennis">Tennis</option>
                    </select>
                </div>

                <div class="input_container">
                    <label for="brand">Product Brand: * </label>
                    <input 
                        id="brand"
                        name="brand"
                        placeholder="Enter product brand"
                        type="text"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="description">Product Description: * </label>
                    <input 
                        id="description"
                        name="description"
                        placeholder="Enter product description"
                        type="text"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="price">Product Price: * </label>
                    <input 
                        id="price"
                        name="price"
                        placeholder="Enter product price"
                        type="currency"
                        class="form_input"
                        required>
                </div>

                <div class="input_container">
                    <label for="image">Product Image: * </label>
                    <input 
                        id="image"
                        name="image"
                        type="file"
                        class="form_input"
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
                    <th>Product ID</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Brand</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Remove</th>
                </tr>
            </thead>
            <tbody class="table-body">
                <?php
                    $sql = "SELECT * FROM products";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($item = mysqli_fetch_assoc($result)) {
                ?>
                            <tr>
                                <td>
                                    <p><?php echo htmlspecialchars($item['productId']); ?></p>
                                </td>
                                <td>
                                    <img src="data:image/jpeg;base64,<?php echo base64_encode($item['image']); ?>" alt="Product Image">
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($item['category']); ?></p>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($item['brand']); ?></p>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($item['name']); ?></p>
                                </td>
                                <td>
                                    <p><?php echo htmlspecialchars($item['description']); ?></p>
                                </td>
                                <td>
                                    <p class="price">£<?php echo htmlspecialchars($item['price']); ?></p>
                                </td>
                                <td>
                                    <button id="remove" class="remove-button" onclick="removeProduct(<?php echo $item['productId']; ?>); reloadPage();">Remove</button>
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
            <h2>Total Products: <?php echo mysqli_num_rows($result); ?></h2>
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
                document.getElementById("signUp-container").style.height = "25rem";
            } else {
                document.getElementById("mySidenav").style.width = "20rem";
                document.getElementById("open-button").style.marginLeft = "20rem";
                document.getElementById("open-nav").style.rotate = "180deg";
                document.getElementById("navbar").style.width = "85%";
                document.getElementById("navbar").style.marginLeft = "20rem";
                document.getElementById("navbar").style.paddingRight = "20rem";
                document.getElementById("main").style.marginLeft = "20rem";
                document.getElementById("signUp-container").style.height = "35rem";
            }
        }

        function addProduct() {
            if (document.getElementById("signUp-container").style.height === "25rem") {
                document.getElementById("signUp-container").style.height = "0";
                document.getElementById("table").style.marginBottom = "2rem";
            } else {
                document.getElementById("signUp-container").style.height = "25rem";
                document.getElementById("table").style.marginBottom = "2rem";
            }
        }
    </script>
</body>

</html>