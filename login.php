<?php
session_start();
include 'koneksi.php';

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND password='$password'");
    
    if (mysqli_num_rows($query) === 1) {
        $user = mysqli_fetch_assoc($query);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
        
        header("Location: index.php");
        exit();
    } else {
        $error = "Username atau Password salah!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Keuangan Rumah Tangga</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Segoe+UI:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="form-body">

    <div class="form-card-container" style="max-width: 400px;">
        <div class="form-header">
            <h2><i class="fa-solid fa-lock"></i> Login Akun</h2>
            <p>Silakan masuk untuk mengakses keuangan</p>
        </div>

        <?php if($error): ?>
            <div style="background: #5c1d1d; color: #ffcccc; padding: 10px; border-radius: 6px; margin-bottom: 15px; font-size: 13px; text-align: center;">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label><i class="fa-solid fa-user"></i> Username</label>
                <input type="text" name="username" placeholder="Contoh: dara" required autocomplete="off">
            </div>

            <div class="form-group">
                <label><i class="fa-solid fa-key"></i> Password</label>
                <input type="password" name="password" placeholder="********" required>
            </div>

            <button type="submit" name="login" class="btn btn-add" style="width: 100%; justify-content: center; margin-top: 10px;">
                <i class="fa-solid fa-right-to-bracket"></i> Masuk Sistem
            </button>
        </form>

        <div style="margin-top: 20px; text-align: center; font-size: 12px; color: #888;">
            Akun Default: Username: <strong>dara</strong> | Password: <strong>12345</strong>
        </div>
    </div>

</body>
</html>