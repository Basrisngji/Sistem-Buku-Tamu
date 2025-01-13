<?php
session_start();
include 'includes/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Hapus data petugas
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM petugas WHERE id_petugas = :id");
    $stmt->execute([':id' => $id]);
    header('Location: data_petugas.php');
    exit();
}

// Ambil data petugas
$stmt = $pdo->query("SELECT * FROM petugas");
$petugas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Petugas</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>

    <div id="main">
        <h2>Data Petugas</h2>
        <a href="add_petugas.php" class="btn btn-add">Tambah Petugas</a>
        <table>
            <thead>
                <tr>
                    <th>Nama Petugas</th> <!-- Tambahkan kolom Nama Petugas -->
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($petugas as $p): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($p['nama_petugas']); ?></td> <!-- Tampilkan Nama Petugas -->
                        <td><?php echo htmlspecialchars($p['username']); ?></td>
                        <td><?php echo htmlspecialchars($p['role']); ?></td>
                        <td>
                            <a href="edit_petugas.php?id=<?php echo htmlspecialchars($p['id_petugas']); ?>" class="btn btn-edit">Edit</a>
                            <a href="?delete_id=<?php echo htmlspecialchars($p['id_petugas']); ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this item?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
