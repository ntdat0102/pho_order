<?php
session_start();
include('connection.php');

if (!isset($_SESSION['logged_in'])) {
    header("Location: ../checkout.php?message=Vui lòng đăng nhập/đăng ký");
    exit();
}

if (isset($_POST['place_order'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $city = htmlspecialchars($_POST['city']);
    $address = htmlspecialchars($_POST['address']);


    $shipping_method = htmlspecialchars($_POST['shipping_method']);
    $shipping_cost = floatval($_POST['shipping_cost']);

    if (isset($_SESSION['total']) && $_SESSION['total'] > 0) {
        $order_cost = $_SESSION['total'] + (int)$shipping_cost;
    } else {
        echo 'Tổng số tiền không hợp lệ';
        exit();
    }

    $order_status = "Chưa thanh toán";
    $user_id = $_SESSION['user_id'];
    $order_date = date('Y-m-d H:i:s');

    $stmt = $conn->prepare("INSERT INTO orders (order_cost, order_status, user_id, user_phone, user_city, user_address, order_date, shipping_method, shipping_cost) VALUES (?,?,?,?,?,?,?,?,?);");
    $stmt->bind_param('isiissssi', $order_cost, $order_status, $user_id, $phone, $city, $address, $order_date, $_POST['shipping_method'], $shipping_cost);


    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        $_SESSION['order_id'] = $order_id;
        $_SESSION['total'] = $order_cost;
        foreach ($_SESSION['cart'] as $key => $product) {
            $product_id = $product['product_id'];
            $product_name = htmlspecialchars($product['product_name']);
            $product_image = htmlspecialchars($product['product_image']);
            $product_price = $product['product_price'];
            $product_quantity = $product['product_quantity'];

            $stmt1 = $conn->prepare("INSERT INTO order_items(order_id, product_id, product_name, product_image, product_price, product_quantity, user_id, order_date) 
                                    VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt1->bind_param("iissiiis", $order_id, $product_id, $product_name, $product_image, $product_price, $product_quantity, $user_id, $order_date);
            $stmt1->execute();
        }

        $_SESSION['order_id'] = $order_id;

        header('Location: ../payment.php?order_status=Đặt hàng thành công!');
        exit();
    } else {
        echo "Đã xảy ra lỗi khi đặt hàng. Vui lòng thử lại.";
    }
} else {
    header("Location: ../checkout.php");
    exit();
}
