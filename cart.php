<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

function calculateTotal()
{
    $total = 0;
    $total_quantity = 0;
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $product) {
            if (isset($product['product_price'], $product['product_quantity']) && is_numeric($product['product_price']) && is_numeric($product['product_quantity'])) {
                $total += floatval($product['product_price']) * intval($product['product_quantity']);
                $total_quantity = $total_quantity + $product['product_quantity'];
            }
        }
    }
    return $total;
    return $total_quantity;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_to_cart'])) {
        if (isset($_POST['product_id'], $_POST['product_name'], $_POST['product_price'], $_POST['product_image'], $_POST['product_quantity'])) {
            $product_array_ids = array_column($_SESSION['cart'], "product_id");

            if (!in_array($_POST['product_id'], $product_array_ids)) {
                $product_array = array(
                    'product_id' => $_POST['product_id'],
                    'product_name' => $_POST['product_name'],
                    'product_price' => $_POST['product_price'],
                    'product_image' => $_POST['product_image'],
                    'product_quantity' => $_POST['product_quantity']
                );
                $_SESSION['cart'][] = $product_array;
            } else {
                echo '<script>alert("Món này đã có trong giỏ hàng rồi");</script>';
            }
        } else {
            echo '<script>alert("Thiếu thông tin sản phẩm!");</script>';
        }
    } elseif (isset($_POST['remove_product'])) {
        $product_id = $_POST['product_id'];

        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_id'] == $product_id) {
                unset($_SESSION['cart'][$key]);
                $_SESSION['cart'] = array_values($_SESSION['cart']);
                break;
            }
        }
    } elseif (isset($_POST['edit_quantity'])) {
        $product_id = $_POST['product_id'];
        $product_quantity = $_POST['product_quantity'];

        foreach ($_SESSION['cart'] as $key => $product) {
            if ($product['product_id'] == $product_id) {
                $_SESSION['cart'][$key]['product_quantity'] = $product_quantity;
                break;
            }
        }
    }
    header("Location: cart.php");

    exit();
}

$_SESSION['total'] = calculateTotal();
?>

<?php include('layouts/header.php') ?>

<section class="cart container my-3 py-3">
    <div class="container">
        <h2 class="font-weight-bold">Giỏ hàng của bạn</h2>
        <hr>
    </div>

    <?php if (!empty($_SESSION['cart'])) { ?>
        <table class="mt-5 pt-5">
            <tr>
                <th>Tên đơn hàng</th>
                <th>Số lượng</th>
                <th>Giá</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="product-info">
                            <img src="assets/imgs/<?php echo $value['product_image']; ?>" alt="Product Image" />
                            <div>
                                <p><?php echo $value['product_name']; ?></p>
                                <small><span></span><?php echo $value['product_price']; ?> VNĐ</small>
                                <br>
                                <form method="POST" action="cart.php">
                                    <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                                    <input type="submit" name="remove_product" class="remove-btn" value="Xoá" />
                                </form>
                            </div>
                        </div>
                    </td>
                    <td>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?php echo $value['product_id']; ?>" />
                            <input type="number" name="product_quantity" value="<?php echo $value['product_quantity']; ?>" min="1" />
                            <input type="submit" class="edit-btn" value="edit" name="edit_quantity" />
                        </form>
                    </td>
                    <td><span></span><span class="product-price"><?php echo $value['product_quantity'] * $value['product_price']; ?> VNĐ</span></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>Giỏ hàng của bạn hiện đang trống.</p>
    <?php } ?>

    <div class="cart-total">
        <table>
            <tr>
                <td>Tổng tiền:</td>
                <td><span></span><?php echo calculateTotal(); ?> VNĐ</td>
            </tr>
        </table>
    </div>


    <div class="checkout-container">
        <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) { ?>
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) { ?>
                <form method="POST" action="checkout.php">
                    <input type="hidden" name="total_amount" value="<?php echo calculateTotal(); ?>">
                    <input type="submit" class="btn checkout-btn" value="Thanh toán" name="checkout">
                </form>
            <?php } else { ?>
                <button class="btn checkout-btn" onclick="checkLogin()">Thanh toán</button>
                <script>
                    function checkLogin() {
                        if (!confirm('Bạn cần đăng nhập để tiếp tục thanh toán. Bạn có muốn đăng nhập ngay bây giờ không?')) {
                            return false;
                        } else {
                            window.location.href = 'login.php';
                        }
                    }
                </script>
            <?php } ?>
        <?php } else { ?>
            <button class="btn checkout-btn" onclick="alert('Giỏ hàng của bạn hiện đang trống. Vui lòng thêm sản phẩm vào giỏ hàng trước khi thanh toán.')">Thanh toán</button>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php') ?>