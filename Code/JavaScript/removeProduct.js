function removeFromWishlist(productId, $userId) {
    fetch("../PHP/removeProduct.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({productId: productId, userId: userId})
    })
}

function reloadPage() {
    location.reload();
}