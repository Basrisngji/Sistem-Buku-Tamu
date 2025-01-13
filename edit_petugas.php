<?php
session_start();
include 'includes/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id_petugas = $_GET['id'];

// Ambil data petugas dari database
$stmt = $pdo->prepare("SELECT * FROM petugas WHERE id_petugas = ?");
$stmt->execute([$id_petugas]);
$petugas = $stmt->fetch();

$errors = [
    'nama_petugas' => '',
    'username' => '',
    'password' => '',
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_petugas = trim($_POST['nama_petugas']);
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $role = $_POST['role'];

    // Validasi panjang nama petugas
    if (strlen($nama_petugas) < 3) {
        $errors['nama_petugas'] = 'Nama petugas minimal 3 karakter.';
    } elseif (strlen($nama_petugas) > 100) {
        $errors['nama_petugas'] = 'Nama petugas maksimal 100 karakter.';
    }

    // Validasi panjang username
    if (strlen($username) < 3) {
        $errors['username'] = 'Username minimal 3 karakter.';
    } elseif (strlen($username) > 100) {
        $errors['username'] = 'Username maksimal 100 karakter.';
    }

    // Validasi panjang password (jika diisi)
    if (!empty($password) && strlen($password) < 3) {
        $errors['password'] = 'Password minimal 3 karakter.';
    } elseif (!empty($password) && strlen($password) > 100) {
        $errors['password'] = 'Password maksimal 100 karakter.';
    }

    // Jika tidak ada kesalahan, simpan perubahan
    if (!array_filter($errors)) {
        $sql = "UPDATE petugas SET nama_petugas = ?, username = ?, role = ? WHERE id_petugas = ?";
        $params = [$nama_petugas, $username, $role, $id_petugas];

        // Jika password diisi, tambahkan update password
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $sql = "UPDATE petugas SET nama_petugas = ?, username = ?, password = ?, role = ? WHERE id_petugas = ?";
            $params = [$nama_petugas, $username, $hashed_password, $role, $id_petugas];
        }

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);

        header('Location: data_petugas.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Petugas</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script>
        function validateForm() {
            let valid = true;

            // Ambil elemen input
            const namaPetugas = document.getElementById('nama_petugas');
            const username = document.getElementById('username');
            const password = document.getElementById('password');

            // Ambil elemen pesan kesalahan
            const errorNamaPetugas = document.getElementById('error_nama_petugas');
            const errorUsername = document.getElementById('error_username');
            const errorPassword = document.getElementById('error_password');

            // Validasi nama petugas
            if (namaPetugas.value.length < 3) {
                errorNamaPetugas.textContent = 'Nama petugas minimal 3 karakter.';
                valid = false;
            } else if (namaPetugas.value.length > 100) {
                errorNamaPetugas.textContent = 'Nama petugas maksimal 100 karakter.';
                valid = false;
            } else {
                errorNamaPetugas.textContent = '';
            }

            // Validasi username
            if (username.value.length < 3) {
                errorUsername.textContent = 'Username minimal 3 karakter.';
                valid = false;
            } else if (username.value.length > 100) {
                errorUsername.textContent = 'Username maksimal 100 karakter.';
                valid = false;
            } else {
                errorUsername.textContent = '';
            }

            // Validasi password (jika diisi)
            if (password.value && password.value.length < 3) {
                errorPassword.textContent = 'Password minimal 3 karakter.';
                valid = false;
            } else if (password.value && password.value.length > 100) {
                errorPassword.textContent = 'Password maksimal 100 karakter.';
                valid = false;
            } else {
                errorPassword.textContent = '';
            }

            return valid;
        }
    </script>
</head>
<style>
    .btn.btn-back {
    background-color: #E1AD01;
    color: #FFFFFF;
    border: 1px solid #ccc;
    padding: 10px 20px;
    text-decoration: none;
    margin-left: 10px;
}

.btn.btn-back:hover {
    background-color: #E1AD01;
}

</style>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div id="main">
        <h2>Edit Petugas</h2>
        <form method="POST" action="" onsubmit="return validateForm()">
            <input type="text" id="nama_petugas" name="nama_petugas" value="<?= htmlspecialchars($petugas['nama_petugas']) ?>" placeholder="Nama Petugas" required>
            <div id="error_nama_petugas" style="color: red;"><?= $errors['nama_petugas'] ?></div>

            <input type="text" id="username" name="username" value="<?= htmlspecialchars($petugas['username']) ?>" required>
            <div id="error_username" style="color: red;"><?= $errors['username'] ?></div>

            <input type="password" id="password" name="password" placeholder="New Password (Leave empty if not changing)">
            <div id="error_password" style="color: red;"><?= $errors['password'] ?></div>

            <select name="role" required>
                <option value="admin" <?= $petugas['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="petugas" <?= $petugas['role'] == 'petugas' ? 'selected' : '' ?>>Petugas</option>
            </select>
            <button type="submit">Update</button>
            <a href="data_petugas.php" class="btn btn-back">Kembali</a>
        </form>
    </div>
</body>
</html>
