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
    $userId = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    if ($stmt->execute()) {
        header("Location: ../manage_users.php?message=Xoá user thành công");
        exit();
    } else {
        header("Location: ../manage_users.php?error=Không thể xoá user");
        exit();
    }
} else {
    header("Location: ../manage_users.php?error=No user ID provided");
    exit();
}
