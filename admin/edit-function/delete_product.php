<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("DELETE FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);

    if ($stmt->execute()) {
        header("Location: ../manage_products.php?message=Xoá sản phẩm thành công.");
    } else {
        header("Location: ../manage_products.php?error=Không thể xoá sản phẩm.");
    }
    exit();
} else {
    header("Location: ../manage_products.php?error=Invalid product ID.");
    exit();
}
