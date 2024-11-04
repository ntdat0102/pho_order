<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'db.php';

$orders = $conn->query("SELECT COUNT(*) as count, SUM(order_cost) as total_cost FROM orders")->fetch_assoc();
$products = $conn->query("SELECT COUNT(*) as count FROM products")->fetch_assoc();
$users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc();

$order_stats = $conn->query("SELECT DATE(order_date) as order_date, SUM(order_cost) as total_cost FROM orders GROUP BY DATE(order_date) ORDER BY order_date ASC")->fetch_all(MYSQLI_ASSOC);

$dates = [];
$totals = [];
foreach ($order_stats as $row) {
    $dates[] = $row['order_date'];
    $totals[] = $row['total_cost'];
}
$product_stats = $conn->query("SELECT product_name, SUM(product_quantity) as total_quantity FROM order_items GROUP BY product_name")->fetch_all(MYSQLI_ASSOC);

$product_names = [];
$product_quantities = [];
foreach ($product_stats as $row) {
    $product_names[] = $row['product_name'];
    $product_quantities[] = $row['total_quantity'];
}
?>

<?php include 'header.php' ?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Tổng đơn hàng </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $orders['count']; ?></h5>
                    <p class="card-text">Tổng đơn hàng nhận được</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Tổng sản phẩm </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $products['count']; ?></h5>
                    <p class="card-text">Số sản phẩm đang bán</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Tổng tài khoản người dùng </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $users['count']; ?></h5>
                    <p class="card-text">Số tài khoản người dùng đã đăng ký</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-4">
            <a href="manage_orders.php" class="btn btn-primary w-100">Quản lý Đơn hàng</a>
        </div>
        <div class="col-md-4">
            <a href="manage_products.php" class="btn btn-primary w-100">Quản lý Sản phẩm</a>
        </div>
        <div class="col-md-4">
            <a href="manage_users.php" class="btn btn-primary w-100">Quản lý Tài khoản người dùng</a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    Tổng doanh thu </div>
                <div class="card-body">
                    <h5 class="card-title"><?php echo number_format($orders['total_cost'], 0, ',', '.'); ?> VNĐ</h5>
                    <p class="card-text">Tổng doanh thu</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Doanh thu theo ngày</h2>
            <canvas id="orderChart" width="400" height="200"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <canvas id="productChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    var ctx = document.getElementById('orderChart').getContext('2d');
    var orderChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo json_encode($dates); ?>,
            datasets: [{
                label: 'Tổng doanh thu (VNĐ)',
                data: <?php echo json_encode($totals); ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value, index, values) {
                            return value.toLocaleString() + ' VNĐ';
                        }
                    }
                }
            }
        }
    });
</script>

<script>
    var ctx = document.getElementById('productChart').getContext('2d');
    var productChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: <?php echo json_encode($product_names); ?>,
            datasets: [{
                label: 'Product Quantity',
                data: <?php echo json_encode($product_quantities); ?>,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
</script>