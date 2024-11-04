<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: ../login.php");
    exit();
}

include '../db.php';

$conn->query("SET @count = 0;");
$conn->query("UPDATE products SET product_id = @count:=@count+1;");

if ($conn->affected_rows > 0) {
    header("Location: ../manage_products.php?message=Tải lại thành công.");
} else {
    header("Location: ../manage_products.php?error=Không thể tải lại.");
}
exit();
