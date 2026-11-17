<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
$user_id = $_SESSION['user_id'];
$pesan = "";
$error = "";

if (isset($_POST['ubah'])) {
    $password_lama = mysqli_real_escape_string($koneksi, $_POST['password_lama']);
    $password_baru = mysqli_real_escape_string($koneksi, $_POST['password_baru']);

    // Cek password lama di database
    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE id='$user_id' AND password='$password_lama'");
    if (mysqli_num_rows($query) === 1) {
        // Update ke password baru
        mysqli_query($koneksi, "UPDATE users SET password='$password_baru' WHERE id='$user_id'");
        $pesan = "Password berhasil diubah!";
    } else {
        $error = "Password lama salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ganti Password - Admin</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="form-body">

    <div class="form-card-container" style="max-width: 400px;">
        <div class="form-header">
            <h2><i class="fa-solid fa-key"></i> Ganti Password</h2>
            <p>Perbarui keamanan akun Anda</p>
        </div>

        <?php if($error): ?>
            <div style="background: #5c1d1d; color: #ffcccc; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; text-align: center;">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <?php if($pesan): ?>
            <div style="background: #1b5e20; color: #ccffcc; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; text-align: center;">
                <?= $pesan; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label><i class="fa-solid fa-unlock"></i> Password Lama</label>
                <input type="password" name="password_lama" placeholder="********" required>
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-lock"></i> Password Baru</label>
                <input type="password" name="password_baru" placeholder="********" required>
            </div>

            <div class="form-actions" style="margin-top: 20px;">
                <button type="submit" name="ubah" class="btn btn-add" style="flex: 1; justify-content: center;"><i class="fa-solid fa-floppy-disk"></i> Simpan</button>
                <a href="index.php" class="btn btn-back" style="flex: 1; justify-content: center; text-align: center; text-decoration: none;"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>
        </form>
    </div>

</body>
</html>