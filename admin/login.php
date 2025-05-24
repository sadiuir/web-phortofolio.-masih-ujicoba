<?php
// admin.portofolio_anda.com/login.php
session_start();
require_once __DIR__ . '/../config/koneksi_db.php'; // Sesuaikan path

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Ambil data admin dari tabel 'admin_users'
    // Anda perlu membuat tabel 'admin_users' dan memasukkan satu user secara manual
    // CREATE TABLE admin_users (
    //     id INT AUTO_INCREMENT PRIMARY KEY,
    //     username VARCHAR(50) NOT NULL UNIQUE,
    //     password VARCHAR(255) NOT NULL
    // );
    // INSERT INTO admin_users (username, password) VALUES ('admin', '$2y$10$HASH_PASSWORD_ANDA'); // Gunakan password_hash() untuk membuat hash

    try {
        $stmt = $pdo->prepare("SELECT id, username, password FROM admin_users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $user['username'];
            header("Location: dashboard.php");
            exit();
        } else {
            $message = '<div class="message error">Username atau password salah.</div>';
        }
    } catch (PDOException $e) {
        $message = '<div class="message error">Terjadi kesalahan pada server.</div>';
        // Log error $e->getMessage()
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="css/admin_style.css">
</head>
<body>
    <div class="login-container">
        <h2>Login Admin</h2>
        <?php echo $message; ?>
        <form action="login.php" method="POST">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>
    </div>
</body>
</html>