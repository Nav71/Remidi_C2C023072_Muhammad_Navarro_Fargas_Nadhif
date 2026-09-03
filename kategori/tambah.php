<?php
require_once '../includes/cek_login.php';
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_kategori']);
    $keterangan = trim($_POST['keterangan']);

    $stmt = mysqli_prepare($koneksi, "INSERT INTO kategori (nama_kategori, keterangan) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nama, $keterangan);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?sukses=Kategori berhasil ditambahkan");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>
<main class="container">
    <h1>Tambah Kategori Baru</h1>
    <form method="POST" class="form-card">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn">Batal</a>
    </form>
</main>
</body>
</html>
