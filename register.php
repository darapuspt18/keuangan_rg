<?php
include 'koneksi.php';
$pesan = "";
$error = "";

if (isset($_POST['register'])) {
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password     = mysqli_real_escape_string($koneksi, $_POST['password']);
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);

    // Cek apakah username sudah ada
    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        $error = "Username sudah digunakan, silakan pilih yang lain!";
    } else {
        $sql = "INSERT INTO users (username, password, nama_lengkap) VALUES ('$username', '$password', '$nama_lengkap')";
        if (mysqli_query($koneksi, $sql)) {
            $pesan = "Akun berhasil dibuat! Silakan <a href='login.php' style='color: #f3d1d1;'>Login di sini</a>.";
        } else {
            $error = "Gagal mendaftarkan akun.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Akun / Register</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="form-body">

    <div class="form-card-container" style="max-width: 400px;">
        <div class="form-header">
            <h2><i class="fa-solid fa-user-plus"></i> Tambah Akun Baru</h2>
            <p>Daftarkan profil pengguna baru</p>
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
                <label><i class="fa-solid fa-id-card"></i> Nama Lengkap</label>
                <input type="text" name="nama_lengkap" placeholder="Contoh: Budi Santoso" required autocomplete="off">
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Username</label>
                <input type="text" name="username" placeholder="Contoh: budi123" required autocomplete="off">
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-key"></i> Password</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" name="register" class="btn btn-add" style="width: 100%; justify-content: center; margin-top: 10px;">
                <i class="fa-solid fa-user-check"></i> Buat Akun
            </button>
        </form>

        <div style="margin-top: 20px; text-align: center; font-size: 13px; color: #888;">
            Sudah punya akun? <a href="login.php" style="color: #f3d1d1; text-decoration: none;">Login di sini</a>
        </div>
    </div>

</body>
</html>