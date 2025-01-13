<?php
session_start();
include 'includes/db.php';

$id_tamu = $_GET['id'];

// Ambil data buku tamu berdasarkan id_tamu
$stmt = $pdo->prepare("SELECT * FROM buku_tamu WHERE id_tamu = ?");
$stmt->execute([$id_tamu]);
$tamu = $stmt->fetch();

// Ambil daftar petugas untuk dropdown
$stmt_petugas = $pdo->query("SELECT id_petugas, nama_petugas FROM petugas");
$petugas_list = $stmt_petugas->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_tamu = $_POST['nama_tamu'];
    $instansi = $_POST['instansi'];
    $alamat = $_POST['alamat'];
    $no_telepon = $_POST['no_telepon'];
    $keperluan = $_POST['keperluan'];
    $tanggal_kunjungan = $_POST['tanggal_kunjungan'];
    $id_petugas = $_POST['id_petugas']; // Ambil id_petugas dari form

    // Update data buku tamu termasuk petugas yang bertanggung jawab
    $stmt = $pdo->prepare("UPDATE buku_tamu SET nama_tamu = ?, instansi = ?, alamat = ?, no_telepon = ?, keperluan = ?, tanggal_kunjungan = ?, id_petugas = ? WHERE id_tamu = ?");
    $stmt->execute([$nama_tamu, $instansi, $alamat, $no_telepon, $keperluan, $tanggal_kunjungan, $id_petugas, $id_tamu]);

    header('Location: data_buku_tamu.php');
    exit();
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
        <h2>Edit Buku Tamu</h2>
        <form method="POST" action="">
            <input type="text" name="nama_tamu" value="<?= htmlspecialchars($tamu['nama_tamu']) ?>" required>
            <input type="text" name="instansi" value="<?= htmlspecialchars($tamu['instansi']) ?>" required>
            <input type="text" name="alamat" value="<?= htmlspecialchars($tamu['alamat']) ?>" required>
            <input type="text" name="no_telepon" value="<?= htmlspecialchars($tamu['no_telepon']) ?>" required>
            <textarea name="keperluan" required><?= htmlspecialchars($tamu['keperluan']) ?></textarea>
            <input type="date" name="tanggal_kunjungan" value="<?= htmlspecialchars($tamu['tanggal_kunjungan']) ?>" required>

            <!-- Dropdown untuk memilih Nama Petugas -->
            <label for="id_petugas">Nama Petugas</label>
            <select name="id_petugas" required>
                <?php foreach ($petugas_list as $petugas): ?>
                    <option value="<?= $petugas['id_petugas'] ?>" <?= $tamu['id_petugas'] == $petugas['id_petugas'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($petugas['nama_petugas']) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Update</button>
            <a href="data_buku_tamu.php" class="btn btn-back">Kembali</a>
        </form>
    </div>
</body>
</html>
