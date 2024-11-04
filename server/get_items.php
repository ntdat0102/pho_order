<?php
include('connection.php');

$stmt = $conn->prepare("SELECT * FROM products");
$stmt->execute();
$get_items = $stmt->get_result();
$stmt->close();
$conn->close();
