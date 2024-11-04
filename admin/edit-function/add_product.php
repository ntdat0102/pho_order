<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $product_image = $_POST['product_image'];
    $product_price = $_POST['product_price'];
    $product_special_offer = $_POST['product_special_offer'];

    if (!empty($product_name) && !empty($product_price)) {
        $stmt = $conn->prepare("INSERT INTO products (product_name, product_category, product_description, product_image, product_price, product_special_offer) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssdi", $product_name, $product_category, $product_description, $product_image, $product_price, $product_special_offer);

        if ($stmt->execute()) {
            header("Location: ../manage_products.php?message=Sản phẩm thêm thành công.");
            exit();
        } else {
            header("Location: ../manage_products.php?error=Lỗi khi thêm sản phẩm.");
            exit();
        }
    } else {
        header("Location: ../manage_products.php?error=Vui lòng điền đủ thông tin.");
        exit();
    }
}
?>

<?php include '../header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Thêm sản phẩm</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="add_product.php">
            <div class="mb-3">
                <label for="product_name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
            <div class="mb-3">
                <label for="product_category" class="form-label">Loại sản phẩm</label>
                <input type="text" class="form-control" id="product_category" name="product_category" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">Mô tả sản phẩm</label>
                <textarea class="form-control" id="product_description" name="product_description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="product_image" class="form-label">Tên file của ảnh VD: phobovien.png (ảnh phải lưu trong assets/imgs/)</label>
                <input type="text" class="form-control" id="product_image" name="product_image" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Giá sản phẩm</label>
                <input type="number" class="form-control" id="product_price" name="product_price" required>
            </div>
            <div class="mb-3">
                <label for="product_special_offer" class="form-label">Khuyến mãi (%)</label>
                <input type="number" class="form-control" id="product_special_offer" name="product_special_offer" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            <a href="../manage_products.php" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>