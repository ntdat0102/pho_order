<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$products = $conn->query("SELECT * FROM products");
?>

<?php include 'header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products</title>
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
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Danh sách sản phẩm</h2>

        <div class="text-center mb-4">
            <a href="edit-function/add_product.php" class="btn btn-success">Thêm sản phẩm</a>
            <a href="edit-function/reset_product_id.php" class="btn btn-warning">Tải lại trang</a>

        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã sản phẩm</th>
                    <th>Tên sản phẩm</th>
                    <th>Loại</th>
                    <th>Mô tả</th>
                    <th>Ảnh</th>
                    <th>Giá</th>
                    <th>Khuyến mãi</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $products->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_category']); ?></td>
                        <td><?php echo htmlspecialchars($row['product_description']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['product_image']); ?>" alt="Product Image" style="width: 50px;"></td>
                        <td><?php echo htmlspecialchars($row['product_price']); ?> VNĐ</td>
                        <td><?php echo htmlspecialchars($row['product_special_offer']); ?>%</td>
                        <td>
                            <a href="edit-function/edit_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="edit-function/delete_product.php?id=<?php echo $row['product_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Xoá</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Trở về trang chủ</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>