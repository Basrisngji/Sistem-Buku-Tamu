<?php
session_start();
include 'includes/db.php';

$today = $pdo->query("SELECT COUNT(*) FROM buku_tamu WHERE tanggal_kunjungan = CURDATE()")->fetchColumn();
$week = $pdo->query("SELECT COUNT(*) FROM buku_tamu WHERE YEARWEEK(tanggal_kunjungan, 1) = YEARWEEK(CURDATE(), 1)")->fetchColumn();
$month = $pdo->query("SELECT COUNT(*) FROM buku_tamu WHERE MONTH(tanggal_kunjungan) = MONTH(CURDATE())")->fetchColumn();
$total = $pdo->query("SELECT COUNT(*) FROM buku_tamu")->fetchColumn();
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>
<head>
    <style>
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
        }
        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 220px;
            text-align: center;
            color: #fff;
            font-size: 18px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }
        .card h3 {
            margin: 0;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .card p {
            margin: 0;
            font-size: 14px;
        }
        .card-red { background-color: #e74c3c; }
        .card-orange { background-color: #f39c12; }
        .card-teal { background-color: #1abc9c; }
        .card-blue { background-color: #3498db; }
    </style>
</head>
<body>
    <?php include 'includes/sidebar.php'; ?>
    <div id="main">
        <h2>Dashboard</h2>
        <div class="cards">
            <div class="card card-red">
                <h3>Tamu Hari Ini</h3>
                <p><?= $today ?></p>
            </div>
            <div class="card card-orange">
                <h3>Tamu Minggu Ini</h3>
                <p><?= $week ?></p>
            </div>
            <div class="card card-teal">
                <h3>Tamu Bulan Ini</h3>
                <p><?= $month ?></p>
            </div>
            <div class="card card-blue">
                <h3>Total Tamu</h3>
                <p><?= $total ?></p>
            </div>
        </div>
    </div>
</body>
</html>
