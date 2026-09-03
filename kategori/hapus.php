<?php
require_once '../includes/cek_login.php';
require_once '../config/koneksi.php';

$id = $_GET['id'] ?? 0;

$stmt = mysqli_prepare($koneksi, "DELETE FROM kategori WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: index.php?sukses=Kategori berhasil dihapus");
exit;
?>
