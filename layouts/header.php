<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-success py-5 fixed-top">
        <div class="container">
            <img src="assets/imgs/logo.png" alt="Logo" class="logo" style="width: 150px; height: 150px;">
            <div style="display: flex; align-items: center;">
                <span style="margin-left: 10px; font-size: 20px;">PHỞ LÂM HƯƠNG</span>
            </div>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item d-flex align-items-center">
                        <a href="index.php" class="nav-link">
                            <i class="fa-solid fa-house"></i>
                        </a>
                        <a href="menu.php" class="nav-link">
                            <i class="fa-solid fa-bowl-food"></i>
                        </a>
                        <a href="cart.php" class="nav-link">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <?php if (isset($_SESSION['total_quantity']) && $_SESSION['total_quantity'] > 0) { ?>
                                <span> <?php echo $_SESSION['total_quantity']; ?></span>
                            <?php } ?>
                        </a>
                        <a href="account.php" class="nav-link">
                            <i class="fa-solid fa-user"></i>
                        </a>
                        <a href="admin/dashboard.php" class="nav-link">
                            <i class="fa-solid fa-user-tie"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>