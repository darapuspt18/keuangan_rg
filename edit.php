<?php
include 'koneksi.php';

$id = $_GET['id'] ?? '';
$query = mysqli_query($koneksi, "SELECT * FROM transaksi WHERE id='$id'");
$data  = mysqli_fetch_assoc($query);

if (!$data) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['update'])) {
    $tanggal    = mysqli_real_escape_string($koneksi, $_POST['tanggal']);
    $kategori   = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $jenis      = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $jumlah     = (int) $_POST['jumlah'];
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);

    $sql = "UPDATE transaksi SET 
            tanggal='$tanggal', 
            kategori='$kategori', 
            jenis='$jenis', 
            jumlah='$jumlah', 
            keterangan='$keterangan' 
            WHERE id='$id'";

    if (mysqli_query($koneksi, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal mengubah data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Cinzel:wght@500&family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="form-body">

    <div class="form-card-container">
        <div class="form-header">
            <h2><i class="fa-solid fa-pen-to-square"></i> Edit Transaksi</h2>
            <p>Perbarui rincian keuangan Anda</p>
        </div>

        <form method="POST" action="">
            <div class="form-group">
                <label><i class="fa-solid fa-calendar"></i> Tanggal Transaksi</label>
                <input type="date" name="tanggal" value="<?= $data['tanggal']; ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-tag"></i> Kategori</label>
                <input type="text" name="kategori" value="<?= htmlspecialchars($data['kategori']); ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-right-left"></i> Jenis Transaksi</label>
                <select name="jenis" required>
                    <option value="pemasukan" <?= $data['jenis'] == 'pemasukan' ? 'selected' : ''; ?>>Pemasukan</option>
                    <option value="pengeluaran" <?= $data['jenis'] == 'pengeluaran' ? 'selected' : ''; ?>>Pengeluaran</option>
                </select>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-rupiah-sign"></i> Jumlah (Rp)</label>
                <input type="number" name="jumlah" value="<?= $data['jumlah']; ?>" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-note-sticky"></i> Keterangan</label>
                <textarea name="keterangan" rows="3"><?= htmlspecialchars($data['keterangan']); ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="update" class="btn btn-add"><i class="fa-solid fa-check"></i> Update Data</button>
                <a href="index.php" class="btn btn-back"><i class="fa-solid fa-arrow-left"></i> Batal</a>
            </div>
        </form>

        <div class="footer-signature" style="margin-top: 20px;">
            <p class="signature-name" style="font-size: 24px;">Dara Puspita Sari</p>
        </div>
    </div>

</body>
</html>