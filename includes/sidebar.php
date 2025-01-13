<?php
// Cek apakah session sudah dimulai, jika belum baru jalankan session_start()
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah session 'role' sudah diset, jika belum set ke null
$role = isset($_SESSION['role']) ? $_SESSION['role'] : null;
?>
<div id="sidebar">
    <div class="logo">
        <img src="img/logo.png" alt="Logo" style="width: 75%; padding: 3px;">
    </div>
    <ul>
        <!-- Menu Dashboard untuk Admin dan Petugas -->
        <li><a href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>

        <!-- Menu untuk Admin saja -->
        <?php if ($role == 'admin') { ?>
            <li><a href="data_petugas.php"><i class="fas fa-users"></i> Data Petugas</a></li>
        <?php } ?>

        <!-- Menu untuk Admin dan Petugas -->
        <li><a href="data_buku_tamu.php"><i class="fas fa-book"></i> Data Buku Tamu</a></li>
        <li><a href="rekap_buku_tamu.php"><i class="fas fa-chart-line"></i> Rekapitulasi Buku Tamu</a></li>

        <!-- Menu Logout untuk Admin dan Petugas -->
        <li><a href="logout.php" onclick="return confirmLogout();"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</div>

<script>
function confirmLogout() {
    return confirm("Apakah Anda yakin ingin logout?");
}
</script>
