<?php
include('server/connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_GET['product_id'])) {

    $product_id = $_GET['product_id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE product_id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();

    $product = $stmt->get_result();
} else {
    header('location: index.php');
}

?>

<?php include('layouts/header.php') ?>

<section class="single-product my-5 pt-5">
    <div class="row mt-5 d-flex align-items-center">


        <?php while ($row = $product->fetch_assoc()) { ?>

            <div class="col-lg-5 col-md-6 col-sm-12">
                <img class="img-fluid w-100 pb-1" src="assets/imgs/<?php echo $row['product_image'];  ?>" alt="Product Image" />
            </div>
            <div class="col-lg-7 col-md-6 col-sm-12">
                <div class="product-details">
                    <h6>Món dạng: <?php echo $row['product_category'];  ?></h6>
                    <h3 class="py-4"><?php echo $row['product_name'];  ?></h3>
                    <h2><?php echo $row['product_price'];  ?> VNĐ</h2>
                    <form method="POST" action="cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $row['product_id'];  ?>" />
                        <input type="hidden" name="product_image" value="<?php echo $row['product_image'];  ?>" />
                        <input type="hidden" name="product_name" value="<?php echo $row['product_name'];  ?>" />
                        <input type="hidden" name="product_price" value="<?php echo $row['product_price'];  ?>" />
                        <input type="number" name="product_quantity" value="1" class="quantity-input" />
                        <button class="buy-btn" type="submit" name="add_to_cart">Thêm vào giỏ hàng</button>

                    </form>
                    <h4 class="mt-5 mb-5">Chi tiết món ăn</h4>
                    <span><?php echo $row['product_description'];  ?></span>
                </div>
            </div>
        <?php  } ?>

    </div>
</section>

<?php include('layouts/footer.php') ?>