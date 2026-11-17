<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include 'koneksi.php';
$current_user_id = $_SESSION['user_id'];

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);
    mysqli_query($koneksi, "DELETE FROM transaksi WHERE id='$id' AND user_id='$current_user_id'");
}

header("Location: index.php");
exit();
?>