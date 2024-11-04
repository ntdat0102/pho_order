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
    $orderId = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        die("Order not found.");
    }

    $order = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cost = $_POST['order_cost'];
    $status = $_POST['order_status'];
    $updateStmt = $conn->prepare("UPDATE orders SET order_cost = ?, order_status = ? WHERE order_id = ?");
    $updateStmt->bind_param("ssi", $cost, $status, $orderId);
    $updateStmt->execute();
    header("Location: ../manage_orders.php?message=Đơn hàng cập nhật thành công.");
    exit();
}
?>

<?php include '../header.php' ?>


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2>Edit Order</h2>
        <form method="post">
            <div class="mb-3">
                <label for="order_cost" class="form-label">Cost</label>
                <input type="text" name="order_cost" class="form-control" id="order_cost" value="<?php echo htmlspecialchars($order['order_cost']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="order_status" class="form-label">Status</label>
                <select name="order_status" class="form-select" id="order_status" required>
                    <option value="Chưa thanh toán" <?php echo ($order['order_status'] == 'Chưa thanh toán') ? 'selected' : ''; ?>>Chưa thanh toán</option>
                    <option value="Đã thanh toán" <?php echo ($order['order_status'] == 'Đã thanh toán') ? 'selected' : ''; ?>>Đã thanh toán</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
            <a href="../manage_orders.php" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>