<?php
include 'koneksi.php';

// Ambil data transaksi khusus yang berkategori atau berelemen Transfer
$query_transfer = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE kategori LIKE '%transfer%' OR keterangan LIKE '%transfer%' OR keterangan LIKE '%tf%' ORDER BY tanggal DESC, id DESC");

// Jika data transfer kosong, kita sediakan array simulasi transferan agar tabel tidak kosong
$count_tf = mysqli_num_rows($query_transfer);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Bank & Transfer Digital - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@500&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="sidebar no-print">
            <div class="sidebar-brand">
                <i class="fa-solid fa-wallet"></i> <span>DompetKu</span>
            </div>
            <ul class="sidebar-menu">
                <li><a href="index.php"><i class="fa-solid fa-chart-pie"></i> Dashboard</a></li>
                <li class="active"><a href="bank.php"><i class="fa-solid fa-building-columns"></i> Halaman Bank</a></li>
                <li><a href="create.php"><i class="fa-solid fa-circle-plus"></i> Tambah Transaksi</a></li>
                <li><a href="export_excel.php" target="_blank"><i class="fa-solid fa-file-excel"></i> Export Excel</a></li>
                <li><a href="#" onclick="window.print()"><i class="fa-solid fa-file-pdf"></i> Export PDF</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <header class="topbar no-print">
                <div class="topbar-title">Layanan Transfer & QRIS Digital Bank</div>
                <div class="user-profile">
                    <i class="fa-solid fa-user-shield"></i> <span>Dara Puspita Sari</span>
                </div>
            </header>

            <div class="container">
                <div class="action-bar no-print" style="justify-content: flex-start; margin-bottom: 20px;">
                    <a href="index.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard</a>
                </div>

                <h2><i class="fa-solid fa-building-columns"></i> Bank & Layanan Transfer Digital</h2>

                <!-- BANNER UTAMA REKENING & QR CODE -->
                <div class="bank-grid">
                    <!-- Kartu Rekening -->
                    <div class="ewallet-card" style="margin-bottom: 0;">
                        <div class="ewallet-header">
                            <span><i class="fa-solid fa-building-columns"></i> BANK CENTRAL DIGITAL</span>
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <div class="ewallet-body">
                            <small>Nomor Rekening Anda</small>
                            <h3 style="font-size: 24px; letter-spacing: 2px;">1234-5678-9010</h3>
                            <p class="account-holder">Pemilik: Dara Puspita Sari</p>
                            <p class="account-number">Status Akun: <strong style="color: #2ecc71;">Aktif / Verified</strong></p>
                        </div>
                    </div>

                    <!-- Tampilan QR Code untuk Terima Transferan -->
                    <div class="qr-card">
                        <h3><i class="fa-solid fa-qrcode"></i> QRIS Terima Transfer</h3>
                        <div class="qr-image-box">
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=130x130&data=DaraPuspitaSari-123456789010" alt="QR Code Bank">
                        </div>
                        <small>Scan QR ini untuk Menerima Transferan</small>
                    </div>
                </div>

                <!-- FORM SIMULASI KIRIM TRANSFER DANA -->
                <div class="transfer-form-box">
                    <h3><i class="fa-solid fa-paper-plane"></i> Form Kirim Transfer Dana</h3>
                    <form onsubmit="simulasiTransfer(event)">
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-building"></i> Bank Tujuan</label>
                                <select required id="bank_tujuan">
                                    <option value="BCA">BCA</option>
                                    <option value="BRI">BRI</option>
                                    <option value="BNI">BNI</option>
                                    <option value="Mandiri">Mandiri</option>
                                    <option value="DANA">DANA / Wallet</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-credit-card"></i> No. Rekening Tujuan</label>
                                <input type="number" id="rekening_tujuan" placeholder="Contoh: 987654321" required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label><i class="fa-solid fa-money-bill-wave"></i> Jumlah Nominal (Rp)</label>
                                <input type="number" id="nominal_transfer" placeholder="Contoh: 100000" required>
                            </div>
                            <div class="form-group">
                                <label><i class="fa-solid fa-comment-dots"></i> Catatan Transfer</label>
                                <input type="text" id="catatan_transfer" placeholder="Contoh: Bayar Hutang / Belanja">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-add" style="width: 100%; justify-content: center;"><i class="fa-solid fa-paper-plane"></i> Kirim Transfer Sekarang</button>
                    </form>
                </div>

                <!-- TABEL KHUSUS RIWAYAT TRANSFERAN -->
                <h3 style="margin-top: 35px; margin-bottom: 15px; color: #f3d1d1;"><i class="fa-solid fa-money-bill-transfer"></i> Tabel Riwayat Transfer (Masuk & Keluar)</h3>
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Pengirim / Penerima</th>
                            <th>Bank & No. Rekening</th>
                            <th>Tipe Transfer</th>
                            <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if($count_tf > 0): ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($query_transfer)): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['keterangan']); ?></td>
                                <td><?= htmlspecialchars($row['kategori']); ?></td>
                                <td>
                                    <span class="badge <?= $row['jenis']; ?>">
                                        <?= ($row['jenis'] == 'pemasukan') ? 'Transfer Masuk' : 'Transfer Keluar'; ?>
                                    </span>
                                </td>
                                <td>Rp <?= number_format($row['jumlah'], 0, ',', '.'); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <!-- Contoh Contoh Data Transfer jika belum ada input transfer -->
                            <tr>
                                <td>1</td>
                                <td><?= date('d-m-Y'); ?></td>
                                <td>Transfer ke Budi Santoso</td>
                                <td>BCA - 88301923</td>
                                <td><span class="badge pengeluaran">Transfer Keluar</span></td>
                                <td>Rp 150.000</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td><?= date('d-m-Y'); ?></td>
                                <td>Transfer Masuk dari Siti Nurhaliza</td>
                                <td>Mandiri - 142000123</td>
                                <td><span class="badge pemasukan">Transfer Masuk</span></td>
                                <td>Rp 500.000</td>
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

    <script>
    function simulasiTransfer(e) {
        e.preventDefault();
        const bank = document.getElementById('bank_tujuan').value;
        const rek = document.getElementById('rekening_tujuan').value;
        const nominal = parseInt(document.getElementById('nominal_transfer').value).toLocaleString('id-ID');
        
        alert('BERHASIL!\n\nTransfer sejumlah Rp ' + nominal + ' ke ' + bank + ' (' + rek + ') telah berhasil dikirim!');
    }
    </script>
</body>
</html>