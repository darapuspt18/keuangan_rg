<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
$current_user_id = $_SESSION['user_id'];
$nama_user = $_SESSION['nama_lengkap'];

$q_in  = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM transaksi WHERE jenis='pemasukan' AND user_id='$current_user_id'");
$total_masuk = mysqli_fetch_assoc($q_in)['total'] ?? 0;

$q_out = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM transaksi WHERE jenis='pengeluaran' AND user_id='$current_user_id'");
$total_keluar = mysqli_fetch_assoc($q_out)['total'] ?? 0;
$saldo_akhir = $total_masuk - $total_keluar;

$query_masuk = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE jenis='pemasukan' AND user_id='$current_user_id' ORDER BY tanggal ASC, id ASC");
$query_keluar = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE jenis='pengeluaran' AND user_id='$current_user_id' ORDER BY tanggal ASC, id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekapitulasi Pemasukan & Pengeluaran - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@500&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="admin-wrapper">
        
        <aside class="sidebar no-print">
            <div class="sidebar-brand">
                <i class="fa-solid fa-wallet"></i> <span>DompetKu</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                <li class="active"><a href="rekap.php"><i class="fa-solid fa-file-invoice-dollar"></i> Rekap Masuk & Keluar</a></li>
                <li><a href="create.php"><i class="fa-solid fa-circle-plus"></i> Tambah Transaksi</a></li>
                <li><a href="ganti_password.php"><i class="fa-solid fa-key"></i> Ganti Password</a></li>
                <li><a href="export_excel.php" target="_blank"><i class="fa-solid fa-file-excel"></i> Export Excel</a></li>
                <li><a href="#" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> Export PDF</a></li>
                <li style="margin-top: 20px;"><a href="logout.php" style="color: #ff8080;" onclick="return confirm('Yakin ingin keluar dari akun?')"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
            </ul>
        </aside>

        <main class="main-content">
            
            <header class="topbar no-print">
                <div class="topbar-title">Halaman Rekapitulasi Jumlah Keuangan</div>
                <div class="user-profile">
                    <i class="fa-solid fa-user-shield"></i> <span><?= htmlspecialchars($nama_user); ?></span>
                </div>
            </header>

            <div class="container">
                
                <div class="action-bar no-print" style="justify-content: flex-start; margin-bottom: 20px;">
                    <a href="index.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
                </div>

                <h2><i class="fa-solid fa-chart-line"></i> Rincian Jumlah Pemasukan & Pengeluaran</h2>

                <div class="cards" style="margin-top: 10px; margin-bottom: 25px;">
                    <div class="card card-in">
                        <h3><i class="fa-solid fa-arrow-down-long"></i> Total Keseluruhan Pemasukan</h3>
                        <p>Rp <?= number_format($total_masuk, 0, ',', '.'); ?></p>
                    </div>
                    <div class="card card-out">
                        <h3><i class="fa-solid fa-arrow-up-long"></i> Total Keseluruhan Pengeluaran</h3>
                        <p>Rp <?= number_format($total_keluar, 0, ',', '.'); ?></p>
                    </div>
                    <div class="card card-balance">
                        <h3><i class="fa-solid fa-wallet"></i> Saldo Bersih Akhir</h3>
                        <p>Rp <?= number_format($saldo_akhir, 0, ',', '.'); ?></p>
                    </div>
                </div>

                <h3 style="color: #27ae60; margin-bottom: 10px;"><i class="fa-solid fa-circle-down"></i> Daftar Rinci Jumlah Pemasukan</h3>
                <table style="margin-bottom: 30px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jumlah Pemasukan</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no_in = 1;
                        $ada_in = false;
                        while($row_in = mysqli_fetch_assoc($query_masuk)): 
                            $ada_in = true;
                        ?>
                        <tr>
                            <td><?= $no_in++; ?></td>
                            <td><?= date('d-m-Y', strtotime($row_in['tanggal'])); ?></td>
                            <td><?= htmlspecialchars($row_in['kategori']); ?></td>
                            <td style="color: #27ae60; font-weight: bold;">Rp <?= number_format($row_in['jumlah'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($row_in['keterangan']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if(!$ada_in): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888;">Belum ada data pemasukan.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <h3 style="color: #8a253c; margin-bottom: 10px;"><i class="fa-solid fa-circle-up"></i> Daftar Rinci Jumlah Pengeluaran</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jumlah Pengeluaran</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no_out = 1;
                        $ada_out = false;
                        while($row_out = mysqli_fetch_assoc($query_keluar)): 
                            $ada_out = true;
                        ?>
                        <tr>
                            <td><?= $no_out++; ?></td>
                            <td><?= date('d-m-Y', strtotime($row_out['tanggal'])); ?></td>
                            <td><?= htmlspecialchars($row_out['kategori']); ?></td>
                            <td style="color: #e74c3c; font-weight: bold;">Rp <?= number_format($row_out['jumlah'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($row_out['keterangan']); ?></td>
                        </tr>
                        <?php endwhile; ?>
                        <?php if(!$ada_out): ?>
                        <tr>
                            <td colspan="5" style="text-align: center; color: #888;">Belum ada data pengeluaran.</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="footer-signature">
                    <p class="signature-title">Created with elegance by:</p>
                    <p class="signature-name">Dara Puspita Sari</p>
                </div>
            </div>
        </main>
    </div>

</body>
</html>