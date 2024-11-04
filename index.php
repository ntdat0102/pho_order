<?php include('layouts/header.php') ?>
<?php if (session_status() == PHP_SESSION_NONE) {
    session_start();
} ?>
<section id="home">
    <div class="container">
        <h5>Phở ngon chuẩn vị - Chạm đến tâm hồn người Việt!</h5>
        <h1><span>Đậm vị nước dùng</span> – Nồng nàn hương phở!</h1>
        <p>Thưởng thức phở – Nếm trọn tinh hoa ẩm thực Việt!</p>
        <button>Đặt ngay</button>
    </div>
</section>

<section id="featured" class="my-5 pb-5">
    <div class="container text-center mt-5 py-5">
        <h3>Best Seller</h3>
        <hr>
        <p>Các món được đặt nhiều</p>
    </div>
    <div class="row mx-auto container-fluid">

        <?php include('server/get_featured_products.php'); ?>
        <?php include('server/get_items.php'); ?>

        <?php while ($row = $get_featured_products->fetch_assoc()) { ?>
            <div class="product text-center col-lg-3 col-md-4 col-sm-12">
                <img class="img-fluid mb-3" src="assets/imgs/<?php echo $row['product_image']; ?>" />
                <h5 class="p-name"><?php echo $row['product_name']; ?></h5>
                <h4 class="p-price"><?php echo $row['product_price']; ?> VNĐ</h4>
                <a href="<?php echo "product.php?product_id=" . $row['product_id']; ?>"> <button class="buy-btn">Đặt ngay</button></a>
            </div>
        <?php } ?>
    </div>
</section>

<?php include('layouts/footer.php') ?>