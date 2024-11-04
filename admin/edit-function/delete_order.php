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
    $orderId = intval($_GET['id']);
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);

    if ($stmt->execute()) {
        header("Location: ../manage_orders.php?message=Xoá đơn hàng thành công");
        exit();
    } else {
        header("Location: ../manage_orders.php?error=Không thể xoá đơn hàng.");
        exit();
    }
}
