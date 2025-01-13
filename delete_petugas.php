<?php
session_start();
include 'includes/db.php';

// Pastikan hanya admin yang dapat mengakses halaman ini
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$id_petugas = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM petugas WHERE id_petugas = ?");
$stmt->execute([$id_petugas]);

header('Location: data_petugas.php');
exit();
?>
