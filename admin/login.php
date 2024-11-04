<?php
include 'db.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $admin_email = $_POST['email'];
    $admin_password = $_POST['password'];

    $query = "SELECT * FROM admins WHERE admin_email='$admin_email' AND admin_password='$admin_password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['admin'] = $admin_email;
        header("Location: dashboard.php");
    } else {
        $error_message = "Invalid login details";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="login-container">
        <h2>Admin Login</h2>
        <?php if (isset($error_message)) { ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php } ?>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>