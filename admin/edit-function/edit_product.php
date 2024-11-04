<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $product_category = $_POST['product_category'];
    $product_description = $_POST['product_description'];
    $product_image = $_POST['product_image'];
    $product_price = $_POST['product_price'];
    $product_special_offer = $_POST['product_special_offer'];

    $stmt = $conn->prepare("UPDATE products SET product_name = ?, product_category = ?, product_description = ?, product_image = ?, product_price = ?, product_special_offer = ? WHERE product_id = ?");
    $stmt->bind_param("ssssdii", $product_name, $product_category, $product_description, $product_image, $product_price, $product_special_offer, $product_id);

    if ($stmt->execute()) {
        header("Location: ../manage_products.php?message=Cập nhật sản phẩm thành công.");
        exit();
    } else {
        header("Location: ../manage_products.php?error=Lỗi không thể cập nhật.");
        exit();
    }
}
?>

<?php include '../header.php' ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Chỉnh sửa sản phẩm</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="edit_product.php?id=<?php echo $product_id; ?>">
            <div class="mb-3">
                <label for="product_name" class="form-label">Tên sản phẩm</label>
                <input type="text" class="form-control" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_category" class="form-label">Loại sản phẩm</label>
                <input type="text" class="form-control" id="product_category" name="product_category" value="<?php echo htmlspecialchars($product['product_category']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">Mô tả sản phẩm</label>
                <textarea class="form-control" id="product_description" name="product_description" required><?php echo htmlspecialchars($product['product_description']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="product_image" class="form-label">Tên file của ảnh VD: phobovien.png (ảnh phải lưu trong assets/imgs/)</label>
                <input type="text" class="form-control" id="product_image" name="product_image" value="<?php echo htmlspecialchars($product['product_image']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Giá sản phẩm</label>
                <input type="number" class="form-control" id="product_price" name="product_price" value="<?php echo htmlspecialchars($product['product_price']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="product_special_offer" class="form-label">Khuyến mãi (%)</label>
                <input type="number" class="form-control" id="product_special_offer" name="product_special_offer" value="<?php echo htmlspecialchars($product['product_special_offer']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật sản phẩm</button>
            <a href="../manage_products.php" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>