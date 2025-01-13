<?php
session_start();
include 'includes/db.php';

// Query untuk mengambil data petugas
$petugas_stmt = $pdo->query("SELECT id_petugas, nama_petugas FROM petugas");
$petugas_data = $petugas_stmt->fetchAll();

$errors = [];
$input_values = []; // Untuk menyimpan input pengguna agar tetap tampil

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil input dari pengguna
    $input_values['nama_tamu'] = $_POST['nama_tamu'];
    $input_values['instansi'] = $_POST['instansi'];
    $input_values['alamat'] = $_POST['alamat'];
    $input_values['no_telepon'] = $_POST['no_telepon'];
    $input_values['keperluan'] = $_POST['keperluan'];
    $input_values['tanggal_kunjungan'] = $_POST['tanggal_kunjungan'];

    // Validasi data
    if (strlen($input_values['nama_tamu']) < 3) {
        $errors['nama_tamu'] = 'Nama Tamu terlalu pendek, minimum 3 karakter.';
    } elseif (strlen($input_values['nama_tamu']) > 50) {
        $errors['nama_tamu'] = 'Nama Tamu terlalu panjang, maksimum 50 karakter.';
    }

    if (strlen($input_values['instansi']) < 3) {
        $errors['instansi'] = 'Instansi terlalu pendek, minimum 3 karakter.';
    } elseif (strlen($input_values['instansi']) > 100) {
        $errors['instansi'] = 'Instansi terlalu panjang, maksimum 100 karakter.';
    }

    if (strlen($input_values['alamat']) < 5) {
        $errors['alamat'] = 'Alamat terlalu pendek, minimum 5 karakter.';
    } elseif (strlen($input_values['alamat']) > 100) {
        $errors['alamat'] = 'Alamat terlalu panjang, maksimum 100 karakter.';
    }

    if (strlen($input_values['no_telepon']) < 10) {
        $errors['no_telepon'] = 'No. Telepon terlalu pendek, minimum 10 digit.';
    } elseif (strlen($input_values['no_telepon']) > 12) {
        $errors['no_telepon'] = 'No. Telepon terlalu panjang, maksimum 12 digit.';
    } elseif (!ctype_digit($input_values['no_telepon'])) {
        $errors['no_telepon'] = 'No. Telepon hanya boleh berisi angka.';
    }

    if (strlen($input_values['keperluan']) < 5) {
        $errors['keperluan'] = 'Keperluan terlalu pendek, minimum 5 karakter.';
    } elseif (strlen($input_values['keperluan']) > 100) {
        $errors['keperluan'] = 'Keperluan terlalu panjang, maksimum 100 karakter.';
    }

    if (empty($input_values['tanggal_kunjungan'])) {
        $errors['tanggal_kunjungan'] = 'Tanggal Kunjungan harus diisi.';
    }

    // Jika tidak ada error, simpan data
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO buku_tamu (nama_tamu, instansi, alamat, no_telepon, keperluan, tanggal_kunjungan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $input_values['nama_tamu'], 
            $input_values['instansi'], 
            $input_values['alamat'], 
            $input_values['no_telepon'], 
            $input_values['keperluan'], 
            $input_values['tanggal_kunjungan']
        ]);
        header('Location: data_buku_tamu.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
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
        <h2>Tambah Buku Tamu</h2>
        <form method="POST" action="">
            <div>
                <input type="text" name="nama_tamu" placeholder="Nama Tamu" value="<?= htmlspecialchars($input_values['nama_tamu'] ?? '') ?>" required>
                <?php if (!empty($errors['nama_tamu'])): ?>
                    <small style="color: red;"><?= $errors['nama_tamu'] ?></small>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="instansi" placeholder="Instansi" value="<?= htmlspecialchars($input_values['instansi'] ?? '') ?>" required>
                <?php if (!empty($errors['instansi'])): ?>
                    <small style="color: red;"><?= $errors['instansi'] ?></small>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="alamat" placeholder="Alamat" value="<?= htmlspecialchars($input_values['alamat'] ?? '') ?>" required>
                <?php if (!empty($errors['alamat'])): ?>
                    <small style="color: red;"><?= $errors['alamat'] ?></small>
                <?php endif; ?>
            </div>
            <div>
                <input type="text" name="no_telepon" placeholder="No Telepon" value="<?= htmlspecialchars($input_values['no_telepon'] ?? '') ?>" required>
                <?php if (!empty($errors['no_telepon'])): ?>
                    <small style="color: red;"><?= $errors['no_telepon'] ?></small>
                <?php endif; ?>
            </div>
            <div>
                <textarea name="keperluan" placeholder="Keperluan" required><?= htmlspecialchars($input_values['keperluan'] ?? '') ?></textarea>
                <?php if (!empty($errors['keperluan'])): ?>
                    <small style="color: red;"><?= $errors['keperluan'] ?></small>
                <?php endif; ?>
            </div>
            <div>
                <input type="date" name="tanggal_kunjungan" value="<?= htmlspecialchars($input_values['tanggal_kunjungan'] ?? '') ?>" required>
                <?php if (!empty($errors['tanggal_kunjungan'])): ?>
                    <small style="color: red;"><?= $errors['tanggal_kunjungan'] ?></small>
                <?php endif; ?>
            </div>
            <button type="submit">Simpan</button>
            <a href="data_buku_tamu.php" class="btn btn-back">Kembali</a>
        </form>
    </div>
</body>
</html>
