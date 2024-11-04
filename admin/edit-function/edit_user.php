<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        header("Location: ../manage_users.php?error=Không tìm thấy user");
        exit();
    }

    $user = $result->fetch_assoc();
} else {
    header("Location: ../manage_users.php?error=Yêu cầu không hợp lệ");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userName = $_POST['user_name'];
    $userEmail = $_POST['user_email'];
    $userPassword = $_POST['user_password'];
    $confirmPassword = $_POST['confirm_password'];

    if (!empty($userPassword)) {
        if ($userPassword !== $confirmPassword) {
            $error = "Passwords do not match.";
        } else {
            $hashedPassword = password_hash($userPassword, PASSWORD_DEFAULT);

            $updateStmt = $conn->prepare("UPDATE users SET user_name = ?, user_email = ?, user_password = ? WHERE user_id = ?");
            $updateStmt->bind_param("sssi", $userName, $userEmail, $hashedPassword, $userId);
        }
    } else {
        $updateStmt = $conn->prepare("UPDATE users SET user_name = ?, user_email = ? WHERE user_id = ?");
        $updateStmt->bind_param("ssi", $userName, $userEmail, $userId);
    }

    if (isset($updateStmt) && $updateStmt->execute()) {
        header("Location: ../manage_users.php?message=Cập nhật user thành công");
        exit();
    } else {
        $error = isset($error) ? $error : "Error updating user: " . $conn->error;
    }
}

?>

<?php include '../header.php' ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center mb-4">Chỉnh sửa User</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <div class="mb-3">
                <label for="user_name" class="form-label">Tên user</label>
                <input type="text" class="form-control" id="user_name" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="user_email" class="form-label">Email user</label>
                <input type="email" class="form-control" id="user_email" name="user_email" value="<?php echo htmlspecialchars($user['user_email']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="user_password" class="form-label">Mật khẩu mới</label>
                <input type="password" class="form-control" id="user_password" name="user_password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Nhập lại mật khẩu mới</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
            <button type="submit" class="btn btn-primary">Cập nhật user</button>
            <a href="../manage_users.php" class="btn btn-secondary">huỷ</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>