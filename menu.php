<?php include('layouts/header.php') ?>
<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<a href="product.html">
    <div class="container">
        <div class="row">
            <?php include('server/get_items.php'); ?>
            <?php while ($row = $get_items->fetch_assoc()) { ?>
                <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                    <a href="<?php echo "product.php?product_id=" . $row['product_id']; ?>" class="product-link">
                        <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" />
                        <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                    </a>
                    <h4 class="p-price"><?php echo $row['product_price']; ?><span> VNĐ</span></h4>
                    <a href="<?php echo "product.php?product_id=" . $row['product_id']; ?>">
                        <button class="buy-btn">Đặt ngay</button>
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</a>

<?php include('layouts/footer.php') ?>