<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products LIMIT 4");
$stmt->execute();
$get_featured_products = $stmt->get_result();

$stmt->close();
$conn->close();
