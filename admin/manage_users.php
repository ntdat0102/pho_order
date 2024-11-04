<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

$users = $conn->query("SELECT * FROM users");
?>

<?php include 'header.php' ?>



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý tài khoản người dùng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 30px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .btn {
            font-size: 0.9rem;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="text-center mb-4">Danh sách người dùng</h2>

        <?php if (isset($_GET['message'])): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($_GET['message']); ?></div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Mã user</th>
                    <th>Tên user</th>
                    <th>Email user</th>
                    <th></th>
                </tr>
                <div class="text-center mb-4">
                    <a href="edit-function/add_user.php" class="btn btn-success">Thêm User</a>
                </div>
            </thead>
            <tbody>
                <?php while ($row = $users->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['user_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                        <td>

                            <a href="edit-function/edit_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-primary">Sửa</a>
                            <a href="edit-function/delete_user.php?id=<?php echo $row['user_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Xoá</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="dashboard.php" class="btn btn-secondary">Trở về trang chủ</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>