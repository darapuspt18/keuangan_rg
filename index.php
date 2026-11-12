<?php
include 'koneksi.php';

// Menghitung Total Pemasukan & Pengeluaran
$q_in  = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM transaksi WHERE jenis='pemasukan'");
$total_masuk = mysqli_fetch_assoc($q_in)['total'] ?? 0;

$q_out = mysqli_query($koneksi, "SELECT SUM(jumlah) AS total FROM transaksi WHERE jenis='pengeluaran'");
$total_keluar = mysqli_fetch_assoc($q_out)['total'] ?? 0;

$saldo_total = $total_masuk - $total_keluar;

// Ambil Data Transaksi
$query = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY tanggal ASC, id ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Keuangan Rumah Tangga</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@500&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="admin-wrapper">
        
        <!-- Sidebar Menu -->
        <aside class="sidebar no-print">
            <div class="sidebar-brand">
                <i class="fa-solid fa-wallet"></i> <span>DompetKu</span>
            </div>
            <ul class="sidebar-menu">
                <li class="active"><a href="index.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                <li><a href="rekap.php"><i class="fa-solid fa-file-invoice-dollar"></i> Rekap Masuk & Keluar</a></li>
                <li><a href="create.php"><i class="fa-solid fa-circle-plus"></i> Tambah Transaksi</a></li>
                <li><a href="export_excel.php" target="_blank"><i class="fa-solid fa-file-excel"></i> Export Excel</a></li>
                <li><a href="#" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> Export PDF</a></li>
            </ul>
        </aside>

        <!-- Main Content Area -->
        <main class="main-content">
            
            <header class="topbar no-print">
                <div class="topbar-title">Sistem Keuangan Rumah Tangga</div>
                <div class="user-profile">
                    <i class="fa-solid fa-user-shield"></i> <span>Dara Puspita Sari</span>
                </div>
            </header>

            <div class="container">
                
                <!-- BANNER PINTASAN KE HALAMAN REKAP -->
                <div class="dashboard-shortcut-banner no-print">
                    <div class="shortcut-info">
                        <h3><i class="fa-solid fa-file-invoice-dollar"></i> Halaman Jumlah Pemasukan & Pengeluaran</h3>
                        <p>Analisis rekapitulasi total nominal uang masuk dan keluar secara terperinci.</p>
                    </div>
                    <a href="rekap.php" class="btn btn-bank-nav"><i class="fa-solid fa-arrow-right-to-bracket"></i> Lihat Rekapitulasi</a>
                </div>

                <h2><i class="fa-solid fa-table-list"></i> Riwayat Transaksi Keuangan</h2>

                <div class="action-bar no-print">
                    <a href="create.php" class="btn btn-add"><i class="fa-solid fa-plus"></i> Tambah Transaksi</a>
                    <div class="export-group">
                        <a href="export_excel.php" target="_blank" class="btn btn-excel"><i class="fa-solid fa-file-excel"></i> Excel</a>
                        <button onclick="window.print()" class="btn btn-print"><i class="fa-solid fa-file-pdf"></i> PDF / Cetak</button>
                    </div>
                </div>

                <!-- Tabel Data -->
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Kategori</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th class="no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($data = mysqli_fetch_assoc($query)): 
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                            <td><?= htmlspecialchars($data['kategori']); ?></td>
                            <td>
                                <span class="badge <?= $data['jenis']; ?>">
                                    <?= ucfirst($data['jenis']); ?>
                                </span>
                            </td>
                            <td>Rp <?= number_format($data['jumlah'], 0, ',', '.'); ?></td>
                            <td><?= htmlspecialchars($data['keterangan']); ?></td>
                            <td class="no-print action-btns">
                                <a href="edit.php?id=<?= $data['id']; ?>" class="btn-icon btn-edit" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                <a href="delate.php?id=<?= $data['id']; ?>" class="btn-icon btn-delete" title="Hapus" onclick="return confirm('Yakin ingin menghapus data ini?')"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>

                <!-- Ringkasan Keuangan di Bawah -->
                <div class="cards">
                    <div class="card card-in">
                        <h3><i class="fa-solid fa-arrow-down-long"></i> Total Pemasukan</h3>
                        <p>Rp <?= number_format($total_masuk, 0, ',', '.'); ?></p>
                    </div>
                    <div class="card card-out">
                        <h3><i class="fa-solid fa-arrow-up-long"></i> Total Pengeluaran</h3>
                        <p>Rp <?= number_format($total_keluar, 0, ',', '.'); ?></p>
                    </div>
                    <div class="card card-balance">
                        <h3><i class="fa-solid fa-wallet"></i> Sisa Saldo</h3>
                        <p>Rp <?= number_format($saldo_total, 0, ',', '.'); ?></p>
                    </div>
                </div>

                <div class="footer-signature">
                    <p class="signature-title">Created with elegance by:</p>
                    <p class="signature-name">Dara Puspita Sari</p>
                </div>
            </div>

        </main>
    </div>

</body>
</html>