<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';

$orders = $conn->query("SELECT * FROM orders");
?>

<?php include 'header.php' ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn {
            font-size: 0.9rem;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center mb-4">Danh sách đơn hàng</h2>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Giá</th>
                    <th>Trạng thái đơn hàng</th>
                    <th>SĐT</th>
                    <th>Thành phố</th>
                    <th>Địa chỉ</th>
                    <th>Thời gian</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $orders->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['order_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_cost']); ?></td>
                        <td>
                            <?php
                            if ($row['order_status'] == 'Đã thanh toán') {
                                echo '<span class="badge bg-success">Đã thanh toán</span>';
                            } elseif ($row['order_status'] == 'Chưa thanh toán') {
                                echo '<span class="badge bg-warning">Chưa thanh toán</span>';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['user_phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_city']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_address']); ?></td>
                        <td><?php echo htmlspecialchars($row['order_date']); ?></td>
                        <td>
                            <a href="edit-function/edit_order.php?id=<?php echo $row['order_id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="edit-function/delete_order.php?id=<?php echo $row['order_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Xoá</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Trở về trang chủ</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>