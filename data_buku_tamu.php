<?php
session_start();
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Logika untuk menambah, mengedit, dan menghapus data buku tamu
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <div id="main">
        <h2>Data Buku Tamu</h2>
        <a href="add_buku_tamu.php" class="btn btn-add">Tambah Buku Tamu</a>
        <table>
            <thead>
                <tr>
                    <th>Nama Tamu</th>
                    <th>Instansi</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Keperluan</th>
                    <th>Tanggal Kunjungan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mendapatkan data buku tamu beserta nama petugas
                $stmt = $pdo->query("
                    SELECT buku_tamu.* FROM buku_tamu 
                ");

                while ($row = $stmt->fetch()) {
                    echo "<tr>
                            <td>{$row['nama_tamu']}</td>
                            <td>{$row['instansi']}</td>
                            <td>{$row['alamat']}</td>
                            <td>{$row['no_telepon']}</td>
                            <td>{$row['keperluan']}</td>
                            <td>{$row['tanggal_kunjungan']}</td>
                            <td>
                                <a href='edit_buku_tamu.php?id={$row['id_tamu']}' class='btn btn-edit'>Edit</a>
                                <a href='delete_buku_tamu.php?id={$row['id_tamu']}' class='btn btn-delete'>Hapus</a>
                            </td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
