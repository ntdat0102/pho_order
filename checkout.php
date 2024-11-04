<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('server/connection.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (isset($_SESSION['cart']) && !empty($_SESSION['cart']) && isset($_POST['checkout'])) {
    $total_amount = $_SESSION['total'];
} else {
    header('Location: index.php');
    exit();
}
?>

<?php include('layouts/header.php') ?>

<section class="my-4 py-4"></section>
<div class="container text-center mt-3">
    <h2 class="font-weight-bold">Thanh toán</h2>
    <p class="text-muted">Vui lòng nhập thông tin thanh toán của bạn bên dưới</p>
</div>

<div class="mx-auto container shadow p-4 mb-5 bg-body rounded" style="max-width: 600px;">
    <form id="checkout-form" method="POST" action="server/place_order.php">
        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="checkout-name" name="name" placeholder="Tên" required />
            </div>
            <div class="col-md-6 mb-3">
                <input type="email" class="form-control" id="checkout-email" name="email" placeholder="Email" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <input type="tel" class="form-control" id="checkout-phone" name="phone" placeholder="Số điện thoại" required />
            </div>
            <div class="col-md-6 mb-3">
                <input type="text" class="form-control" id="checkout-city" name="city" placeholder="Thành phố" required />
            </div>
        </div>

        <div class="mb-3">
            <input type="text" class="form-control" id="checkout-address" name="address" placeholder="Địa chỉ" required />
        </div>

        <div class="mb-4">
            <label for="shipping_method" class="form-label">Phương thức giao hàng:</label>
            <div class="btn-group d-flex justify-content-center" role="group" aria-label="Shipping method">
                <button type="button" class="btn btn-outline-primary shipping-option" data-cost="20000" data-method="standard">Giao hàng tiêu chuẩn:
                    20.000 VNĐ</button>
                <button type="button" class="btn btn-outline-primary shipping-option" data-cost="35000" data-method="express">Giao hàng nhanh:
                    35.000 VNĐ</button>
            </div>
        </div>

        <input type="hidden" name="shipping_method" id="shipping_method" value="standard">
        <input type="hidden" name="shipping_cost" id="shipping_cost" value="20000">
        <input type="hidden" name="total_amount" id="total_amount" value="<?php echo $_SESSION['total']; ?>">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <p id="total_amount_display" class="h5">Tổng tiền: <?php echo number_format($_SESSION['total'], 0, ',', '.'); ?> VNĐ</p>
            <input type="submit" class="btn btn-primary px-4 py-2" name="place_order" id="checkout-btn" value="Đặt hàng" />
        </div>
    </form>
</div>

<script>
    const totalAmount = <?php echo $_SESSION['total']; ?>;
    const shippingButtons = document.querySelectorAll('.shipping-option');
    const shippingCostInput = document.getElementById('shipping_cost');
    const shippingMethodInput = document.getElementById('shipping_method');
    const totalAmountInput = document.getElementById('total_amount');
    const totalAmountDisplay = document.getElementById('total_amount_display');

    function updateTotal(cost, method) {
        const newTotal = totalAmount + parseFloat(cost);
        shippingCostInput.value = cost;
        shippingMethodInput.value = method;
        totalAmountInput.value = newTotal;
        totalAmountDisplay.innerHTML = `Tổng tiền: ${newTotal.toLocaleString('vi-VN')} VNĐ`;
    }

    shippingButtons.forEach(button => {
        button.addEventListener('click', function() {
            shippingButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const cost = this.getAttribute('data-cost');
            const method = this.getAttribute('data-method');
            updateTotal(cost, method);
        });
    });

    shippingButtons[0].classList.add('active');
</script>

<style>
    .shipping-option.active {
        background-color: #007bff;
        color: white;
    }

    .shipping-option {
        min-width: 180px;
        transition: background-color 0.3s ease;
    }

    .shipping-option:hover {
        background-color: #0056b3;
        color: white;
    }
</style>

<?php include('layouts/footer.php') ?>