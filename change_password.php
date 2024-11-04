<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include('server/connection.php');

if (!isset($_SESSION['logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['password'], $_POST['cfpassword'])) {
    $password = $_POST['password'];
    $cfpassword = $_POST['cfpassword'];
    $user_email = $_SESSION['user_email'];

    if ($password !== $cfpassword) {
        header('Location: account.php?error=Hai mật khẩu không khớp');
        exit();
    } elseif (strlen($password) < 6) {
        header('Location: account.php?error=Mật khẩu phải có ít nhất 6 ký tự');
        exit();
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
        $stmt->bind_param('ss', $hashed_password, $user_email);

        if ($stmt->execute()) {
            header('Location: account.php?success=Đổi mật khẩu thành công');
        } else {
            header('Location: account.php?error=Có lỗi khi đổi mật khẩu');
        }
        exit();
    }
} else {
    header('Location: account.php?error=Vui lòng điền đầy đủ thông tin');
    exit();
}
?><?php
    session_start();
    include('server/connection.php');

    if (!isset($_SESSION['logged_in'])) {
        header("Location: login.php");
        exit();
    }

    if (isset($_POST['password'], $_POST['cfpassword'])) {
        $password = $_POST['password'];
        $cfpassword = $_POST['cfpassword'];
        $user_email = $_SESSION['user_email'];

        if ($password !== $cfpassword) {
            header('Location: account.php?error=Hai mật khẩu không khớp');
            exit();
        } elseif (strlen($password) < 6) {
            header('Location: account.php?error=Mật khẩu phải có ít nhất 6 ký tự');
            exit();
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("UPDATE users SET user_password=? WHERE user_email=?");
            $stmt->bind_param('ss', $hashed_password, $user_email);

            if ($stmt->execute()) {
                header('Location: account.php?success=Đổi mật khẩu thành công');
            } else {
                header('Location: account.php?error=Có lỗi khi đổi mật khẩu');
            }
            exit();
        }
    } else {
        header('Location: account.php?error=Vui lòng điền đầy đủ thông tin');
        exit();
    }
    ?>