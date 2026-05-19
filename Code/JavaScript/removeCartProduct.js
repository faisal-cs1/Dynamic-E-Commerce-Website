function removeItem(productId) {
    fetch("../PHP/removeCartProduct.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({productId: productId})
    })
}

function reloadPage() {
    location.reload();
}