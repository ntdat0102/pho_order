<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('server/connection.php');
if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['logged_in'])) {
    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("SELECT * FROM orders WHERE user_id =?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $orders = $stmt->get_result();
    $stmt->close();
    $conn->close();
}



?>

<?php include('layouts/header.php') ?>

<section class="my-5 py-5">
    <div class="row container mx-auto">

        <?php if (isset($_GET['payment_message'])) { ?>
            <p class="mt-5 text-center" style="color: green"><?php echo $_GET['payment_message']; ?></p>
        <?php } ?>
        <div class="text-center mt-3 pt-5 col-lg-6 col-md-12 col-sm-12">
            <h3 class="font-weight-bold">Thông tin tài khoản</h3>
            <hr class="mx-auto">
            <div class="account-info">
                <p>Tên: <span><?php if (isset($_SESSION['user_name'])) {
                                    echo $_SESSION['user_name'];
                                } ?></span></p>
                <p>Email: <span><?php if (isset($_SESSION['user_email'])) {
                                    echo $_SESSION['user_email'];
                                } ?></span></p>
                <p><a href="#orders" id="orders-btn">Đơn hàng của bạn</a></p>
                <p><a href="account.php?logout=1" id="logout-btn">Đăng xuất</a></p>
            </div>
        </div>

        <div class="col-lg-6 col-md-12 col-sm-12 ">
            <form id="account-form" action="change_password.php" method="POST">
                <h3>Đổi mật khẩu</h3>
                <hr class="mx-auto">
                <div class="form-group">
                    <input type="password" class="form-control" id="account-password" name="password" placeholder="Mật khẩu mới" required />
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="account-cfpassword" name="cfpassword" placeholder="Nhập lại mật khẩu" required />
                </div>
                <div class="form-group">
                    <input type="submit" class="btn" id="change-pass-btn" value="Xác nhận" />
                </div>
                <?php if (isset($_GET['success'])) { ?>
                    <div class="alert alert-success">
                        <?php echo $_GET['success']; ?>
                    </div>
                <?php } ?>

                <?php if (isset($_GET['error'])) { ?>
                    <div class="alert alert-danger">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php } ?>
            </form>
        </div>
    </div>
</section>

<section id="orders" class="orders container my-5 py-3">
    <div class="container mt-2">
        <h2 class="font-weight-bold text-center">Đơn hàng của bạn</h2>
        <hr class="mx-auto">
    </div>

    <table class="mt-5 pt-5">
        <tr>
            <th>Mã đơn hàng</th>
            <th>Giá đơn hàng</th>
            <th>Tình trạng đơn hàng</th>
            <th>Ngày thêm</th>
            <th>Chi tiết đơn hàng</th>

        </tr>
        <?php while ($row = $orders->fetch_assoc()) { ?>
            <tr>
                <td>
                    <span><?php echo $row['order_id']; ?></span>
                </td>

                <td>
                    <span><?php echo $row['order_cost']; ?> VNĐ</span>
                </td>

                <td>
                    <span><?php echo $row['order_status']; ?></span>
                </td>
                <td>
                    <span><?php echo $row['order_date']; ?></span>
                </td>
                <td>
                    <form method="POST" action="order_details.php">
                        <input type="hidden" value="<?php echo $row['order_status']; ?>" name="order_status" />
                        <input type="hidden" value="<?php echo $row['order_id']; ?>" name="order_id" />
                        <input class="btn order-details-btn" name="order_details_btn" type="submit" value="Chi tiết">
                    </form>
                </td>

            </tr>
        <?php } ?>
    </table>
</section>

<?php include('layouts/footer.php') ?>