<?php
include('server/connection.php');
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['logged_in'])) {
    header('location: account.php');
    exit;
}

if (isset($_POST['register'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];

    if ($password !== $cfpassword) {
        header('location: register.php?error=2 mật khẩu không khớp');
        exit;
    } else if (strlen($password) < 6) {
        header('location: register.php?error=1 mật khẩu phải có ít nhất 6 kí tự');
        exit;
    } else {
        $stmt1 = $conn->prepare("SELECT count(*) FROM users WHERE user_email = ?");
        $stmt1->bind_param('s', $email);
        $stmt1->execute();
        $stmt1->store_result();
        $stmt1->bind_result($num_rows);
        $stmt1->fetch();

        if ($num_rows != 0) {
            header('location: register.php?error=email đã tồn tại');
            exit;
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
            $stmt->bind_param('sss', $name, $email, $hashed_password);



            if ($stmt->execute()) {
                session_start();
                $user_id = $conn->insert_id;
                $_SESSION['user_id'] = $user_id;
                $_SESSION['user_email'] = $email;
                $_SESSION['user_name'] = $name;
                $_SESSION['logged_in'] = true;
                header('Location: account.php?register=Bạn đã đăng ký thành công');
                exit;
            } else {
                header('location: register.php?error=Đã xảy ra lỗi');
                exit;
            }
        }
    }
}
?>

<?php include('layouts/header.php') ?>

<section class="my-5 py-5">
    <div class="container text-center mt-3 pt-5">
        <h2 class="font-weight-bold">Đăng ký</h2>
    </div>
    <div class="mx-auto container">
        <form id="register-form" method="POST" action="register.php">
            <p style="color: red;"><?php if (isset($_GET['error'])) {
                                        echo $_GET['error'];
                                    } ?> </p>
            <div class="form-group">
                <input type="text" class="form-control" id="register-name" name="name" placeholder="Tên" required />
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="register-email" name="email" placeholder="Email"
                    required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="register-password" name="password"
                    placeholder="Mật khẩu" required />
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="register-cfpassword" name="cfpassword"
                    placeholder="Nhập lại mật khẩu" required />
            </div>
            <div class="form-group">
                <input type="submit" class="btn" id="register-btn" name="register" value="Register" />
            </div>
            <div class="form-group">
                <a id="login-url" href="login.php" class="btn">Bạn có có tài khoản? Đăng nhập ở đây</a>
            </div>
        </form>
    </div>
</section>

<?php include('layouts/footer.php') ?>

zxncbmnbzxcnbxbcmnxbczxnbcnzbcmnbxznmb