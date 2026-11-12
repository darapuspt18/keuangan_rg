<?php
include 'koneksi.php';

if (isset($_POST['submit'])) {
    $tanggal    = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $kategori   = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $jenis      = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $jumlah     = (int) $_POST['jumlah'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $sql = "INSERT INTO transaksi (tanggal, kategori, jenis, jumlah, keterangan) 
            VALUES ('$tanggal', '$kategori', '$jenis', '$jumlah', '$keterangan')";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menambahkan data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Transaksi - Admin</title>
    <!-- Pastikan file style.css berada di folder yang sama -->
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@500&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="form-body">

    <div class="form-card-container">
        <div class="form-header">
            <h2><i class="fa-solid fa-circle-plus"></i> Tambah Transaksi Baru</h2>
            <p>Masukkan rincian keuangan dengan benar</p>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label><i class="fa-solid fa-calendar"></i> Tanggal Transaksi</label>
                <input type="date" name="tanggal" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-tag"></i> Kategori</label>
                <input type="text" name="kategori" placeholder="Contoh: Belanja Bulanan / Gaji" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-right-left"></i> Jenis Transaksi</label>
                <select name="jenis" required>
                    <option value="pemasukan">Pemasukan</option>
                    <option value="pengeluaran">Pengeluaran</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-rupiah-sign"></i> Jumlah (Rp)</label>
                <input type="number" name="jumlah" placeholder="Contoh: 50000" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-note-sticky"></i> Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" placeholder="Catatan tambahan..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn btn-add"><i class="fa-solid fa-floppy-disk"></i> Simpan Data</button>
                <a href="index.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Batal</a>
            </div>
        </form>

        <div class="footer-signature" style="margin-top: 20px;">
            <p class="signature-name" style="font-size: 24px;">Dara Puspita Sari</p>
        </div>
    </div>

</body>
</html>