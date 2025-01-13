<?php
session_start();
include 'includes/db.php';

// Ambil tanggal mulai dan tanggal akhir dari query string atau kosong jika tidak ada
$start_date = $_GET['start_date'] ?? '';
$end_date = $_GET['end_date'] ?? '';

// Validasi dan format tanggal jika ada (pastikan formatnya adalah Y-m-d)
if ($start_date && $end_date) {
    // Pastikan tanggal dalam format yang benar (YYYY-MM-DD)
    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));
}

// Query untuk mengambil data buku_tamu (hilangkan nama_petugas)
$query = "SELECT * FROM buku_tamu";

if ($start_date && $end_date) {
    $query .= " WHERE tanggal_kunjungan BETWEEN :start_date AND :end_date";
}

$stmt = $pdo->prepare($query);

// Jika ada tanggal mulai dan tanggal akhir, binding parameter
if ($start_date && $end_date) {
    $stmt->bindParam(':start_date', $start_date);
    $stmt->bindParam(':end_date', $end_date);
}

// Eksekusi query
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'includes/header.php'; ?>

<body>
    <?php include 'includes/sidebar.php'; ?>
    <div id="main">
        <h2>Rekapitulasi Buku Tamu</h2>

        <!-- Formulir Pencarian -->
        <form method="GET" action="" class="search-form">
            <input type="date" name="start_date" value="<?= htmlspecialchars($start_date) ?>" required>
            <p>s/d</p>
            <input type="date" name="end_date" value="<?= htmlspecialchars($end_date) ?>" required>
            <button type="submit" class="btn btn-search">Cari</button>
        </form>

        <!-- Tombol Cetak -->
        <a href="#" onclick="printTable()" class="btn btn-print">Cetak</a>

        <table id="rekap-table">
            <thead>
                <tr>
                    <th>Nama Tamu</th>
                    <th>Instansi</th>
                    <th>Alamat</th>
                    <th>No Telepon</th>
                    <th>Keperluan</th>
                    <th>Tanggal Kunjungan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Tampilkan data buku_tamu berdasarkan query
                while ($row = $stmt->fetch()) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['nama_tamu']) . "</td>
                            <td>" . htmlspecialchars($row['instansi']) . "</td>
                            <td>" . htmlspecialchars($row['alamat']) . "</td>
                            <td>" . htmlspecialchars($row['no_telepon']) . "</td>
                            <td>" . htmlspecialchars($row['keperluan']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_kunjungan']) . "</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script>
        // Fungsi untuk mencetak tabel
        function printTable() {
            const originalContent = document.body.innerHTML;
            const tableContent = document.getElementById('rekap-table').outerHTML;
            const printWindow = window.open('', '', 'height=600,width=800');
            printWindow.document.write('<html><head><title>Cetak Data Buku Tamu</title>');
            printWindow.document.write('<style>table {width: 100%; border-collapse: collapse;} th, td {border: 1px solid #ddd; padding: 8px;} th {background-color: #3498db; color: white;}</style>');
            printWindow.document.write('</head><body>');
            printWindow.document.write('<h2>Rekapitulasi Buku Tamu</h2>');
            printWindow.document.write(tableContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>
