<?php
session_start();
include 'includes/db.php';

$id_tamu = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM buku_tamu WHERE id_tamu = ?");
$stmt->execute([$id_tamu]);

header('Location: data_buku_tamu.php');
?>
