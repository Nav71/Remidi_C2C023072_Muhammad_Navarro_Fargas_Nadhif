<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit;
}
$error = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
unset($_SESSION['login_error']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Inventaris Toko Musik</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="login-body">
    <div class="login-box">
        <h2>🎸 Inventaris Toko Musik</h2>
        <p class="subtitle">Silakan login untuk melanjutkan</p>

        <?php if ($error): ?>
            <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="proses_login.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Login</button>
        </form>

        <p class="hint">Default: admin / admin123</p>
    </div>
</body>
</html>
