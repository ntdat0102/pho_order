<?php
require 'vendor/autoload.php';
\Stripe\Stripe::setApiKey('sk_test_51QAYxMHrNgqGbGdlI2S6QtX0tTeTt1r5WTl1lawJxPJoRapgvth1giCUk2vOigvObm1qK2ZE6OLXbJkQYusWU5Wx005Peos3cW');
?>
<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$order_total_price = null;
$order_id = null;
$order_status = null;

if (isset($_POST['checkout'])) {
    $order_total_price = $_POST['total_amount'] ?? 0;
    $order_id = null;
    $order_status = 'Chưa thanh toán';
} elseif (isset($_POST['order_pay_btn'])) {
    $order_id = $_POST['order_id'] ?? null;
    $order_total_price = $_POST['order_total_price'] ?? 0;
    $order_status = $_POST['order_status'] ?? null;
}

if (!isset($order_total_price) && isset($_SESSION['total'])) {
    $order_total_price = $_SESSION['total'];
}

if (!isset($order_total_price) || $order_total_price <= 0) {
    die('Đi đến tài khoản của bạn');
}

?>

<?php include('layouts/header.php'); ?>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Thanh toán</h2>
    </div>
    <div class="mx-auto container text-center">
        <?php
        if (isset($_SESSION['total']) && $_SESSION['total'] != 0) { ?>
            <?php $amount = strval($_SESSION['total']);
            $exchange_rate = 24000;
            $amount_in_usd = round($amount / $exchange_rate, 2); ?>
            <?php $order_id = $_SESSION['order_id'] ?? null; ?>
            <p>Tổng tiền: <?php echo $_SESSION['total']; ?></p>
            <div id="paypal-button-container"></div>
        <?php
        } elseif (isset($order_status) && $order_status == "Chưa thanh toán") { ?>
            <?php $amount = strval($order_total_price);
            $exchange_rate = 24000;
            $amount_in_usd = round($amount / $exchange_rate, 2); ?>
            <?php

            echo "<p>Phương thức giao hàng: " . htmlspecialchars($order['shipping_method']) . "</p>";
            echo "<p>Phí vận chuyển: " . number_format($order['shipping_cost'], 0, ',', '.') . "₫</p>";
            ?>
            <p>Tổng tiền: <?php echo $order_total_price; ?></p>
            <div id="paypal-button-container"></div>
            <button id="checkout-button" class="btn btn-primary">Pay with Stripe</button>
        <?php
        } else { ?>
            <p>Không có thông tin thanh toán.</p>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php'); ?>
<script src="https://js.stripe.com/v3/"></script>

<script src="https://www.paypal.com/sdk/js?client-id=AZl0zO8KttpEtvwLMlO4pnuqHIRcFfKG38rtZ1s3cT0dYoTMV-guaY95AwPNKhxzFo_uMcP8cbFUBjRq&currency=USD"></script>
<script>
    alert('PayPal script loaded');

    paypal.Buttons({
        createOrder: function(data, actions) {
            console.log('Creating order');
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?php echo $amount_in_usd; ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(orderData) {
                console.log('Capture result:', orderData);

                try {
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nOK to continue.');
                    window.location.href = "server/complete_payment.php?transaction_id=" + transaction.id + "&order_id=" + <?php echo json_encode($order_id); ?>;
                } catch (error) {
                    console.error('Error retrieving transaction details:', error);
                    alert('Giao dịch đã hoàn tất nhưng không thể lấy chi tiết giao dịch.');
                }
            }).catch(function(error) {
                console.error('Capture failed:', error);
                alert('Có lỗi xảy ra khi hoàn tất giao dịch. Vui lòng thử lại.');
            });
        }
    }).render('#paypal-button-container');

    console.log('PayPal buttons rendered');

    var stripe = Stripe('pk_test_51QAYxMHrNgqGbGdlDXL16XLMoxlffYm7yfvbDtodskLVAWLHDlcM5BLb1cAycD8hxmgq59nk4vzal9tJBrRauHMh00thuacaCl');

    document.getElementById('checkout-button').addEventListener('click', function(e) {
        e.preventDefault();
        fetch('/create_checkout_session.php', {
                method: 'POST',
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(session) {
                return stripe.redirectToCheckout({
                    sessionId: session.id
                });
            })
            .then(function(result) {
                if (result.error) {
                    alert(result.error.message);
                }
            })
            .catch(function(error) {
                console.error('Error:', error);
            });
    });
</script>

<style>
    #paypal-button-container {
        width: 300px;
        margin: 0 auto;
    }

    .paypal-button-container iframe {
        transform: scale(0.8);
        transform-origin: center center;
    }
</style>