<?php
session_start();

include 'includes/db.php';

$error_message = '';
$error_username = '';
$error_password = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi panjang username
    if (strlen($username) < 3) {
        $error_username = "Username terlalu pendek.";
    } elseif (strlen($username) > 100) {
        $error_username = "Username terlalu panjang.";
    }
    // Validasi panjang password
    if (strlen($password) < 3) {
        $error_password = "Password terlalu pendek.";
    } elseif (strlen($password) > 100) {
        $error_password = "Password terlalu panjang.";
    }

    if (empty($error_username) && empty($error_password)) {
        // Query untuk mendapatkan data user berdasarkan username
        $stmt = $pdo->prepare("SELECT * FROM petugas WHERE username = :username");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika user tidak ditemukan
        if (!$user) {
            $error_username = "Username tidak ditemukan.";
        } else {
            // Cek apakah password sesuai dengan yang ada di database
            if (password_verify($password, $user['password'])) {
                // Menyimpan username dan role ke session
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role']; // Role admin atau petugas
                header('Location: dashboard.php');
                exit();
            } else {
                $error_password = "Password salah.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
            margin-bottom: 0;
            text-align:left;
        }
        .input-container {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-container">
            <h2>Aplikasi Buku Tamu</h2>
            <form method="POST" action="">
                <div class="input-container">
                <input type="text" name="username" placeholder="Username" required value="">
                    <?php if ($error_username): ?>
                        <p class="error"><?php echo htmlspecialchars($error_username); ?></p>
                    <?php endif; ?>
                </div>
                <div class="input-container">
                <input type="password" name="password" placeholder="Password" required value="">
                    <?php if ($error_password): ?>
                        <p class="error"><?php echo htmlspecialchars($error_password); ?></p>
                    <?php endif; ?>
                </div>
                <button type="submit">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
