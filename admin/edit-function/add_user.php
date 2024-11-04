<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = $_POST['user_name'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];

    if (!empty($user_name) && !empty($user_email) && !empty($user_password)) {
        $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (user_name, user_email, user_password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $user_name, $user_email, $hashed_password);

        if ($stmt->execute()) {
            header("Location: ../manage_users.php?message=Thêm user thành công.");
            exit();
        } else {
            header("Location: ../manage_users.php?error=Lỗi khi thêm user.");
            exit();
        }
    } else {
        header("Location: ../manage_users.php?error=Vui lòng điền đủ thông tin.");
        exit();
    }
}
?>

<?php include '../header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Thêm user</h2>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <form method="POST" action="add_user.php">
            <div class="mb-3">
                <label for="user_name" class="form-label">Tên user</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="user_email" class="form-label">Email user</label>
                <input type="email" class="form-control" id="user_email" name="user_email" required>
            </div>
            <div class="mb-3">
                <label for="user_password" class="form-label">Mật khẩu user</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Thêm user</button>
            <a href="../manage_users.php" class="btn btn-secondary">Huỷ</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>