<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$conn = new mysqli("localhost", "root", "", "pho_order");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
