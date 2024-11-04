<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('server/connection.php');

if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, user_name, user_email, user_password FROM users WHERE user_email=? LIMIT 1");
    $stmt->bind_param('s', $email);

    if ($stmt->execute()) {
        $stmt->store_result();
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($user_id, $user_name, $user_email, $user_password);
            $stmt->fetch();
            var_dump($password, $user_password);
            if (password_verify($password, $user_password)) {
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_name'] = $user_name;
                $_SESSION['user_email'] = $user_email;
                $_SESSION['logged_in'] = true;

                echo "<script>
                    alert('Đăng nhập thành công!');
                    window.location.href = 'account.php';
                </script>";
                exit();
            } else {
                header('Location: login.php?error=Sai mật khẩu');
                exit();
            }
        } else {
            header('Location: login.php?error=Email không tồn tại');
            exit();
        }
    } else {
        header('Location: login.php?error=Có lỗi khi đăng nhập');
        exit();
    }
}
?>

<?php include('layouts/header.php') ?>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Đăng nhập</h2>
    </div>
    <div class="mx-auto container">
        <form id="login-form" method="POST" action="login.php">
            <p style="color: red" class="text-center"><?php if (isset($_GET['error'])) {
                                                            echo $_GET['error'];
                                                        } ?> </p>
            <div class="form-group">
                <input type="text" class="form-control" id="login-email" name="email" placeholder="Email"
                    required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="login-password" name="password"
                    placeholder="Mật khẩu" required />
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="login-btn" name="login" value="Login" />
            </div>
            <div class="form-group">
                <a id="register-url" href="register.php" class="btn">Bạn chưa có tài khoản? Đăng ký ở đây</a>
            </div>
        </form>
    </div>
</section>

<?php include('layouts/footer.php') ?>