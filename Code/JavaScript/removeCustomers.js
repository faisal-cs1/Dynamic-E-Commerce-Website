function removeCustomer(userId) {
    fetch("../PHP/removeCustomer.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({userId: userId})
    })
}

function removeProduct(productId) {
    fetch("../PHP/removeProduct.php", {
        method: "DELETE",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({productId: productId})
    })
}

function reloadPage() {
    location.reload();
}