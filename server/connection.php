<?php
$server = "localhost";
$username = "root";
$password = "";
$database = "pho_order";

$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
