<?php
require_once '../includes/cek_login.php';
require_once '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode = trim($_POST['kode_barang']);
    $nama = trim($_POST['nama_barang']);
    $kategori_id = $_POST['kategori_id'];
    $stok = $_POST['stok'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];
    $kondisi = $_POST['kondisi'];
    $deskripsi = trim($_POST['deskripsi']);
    $tanggal_masuk = $_POST['tanggal_masuk'];

    $stmt = mysqli_prepare($koneksi, "INSERT INTO barang
        (kode_barang, nama_barang, kategori_id, stok, harga_beli, harga_jual, kondisi, deskripsi, tanggal_masuk)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssiiddsss",
        $kode, $nama, $kategori_id, $stok, $harga_beli, $harga_jual, $kondisi, $deskripsi, $tanggal_masuk);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?sukses=Barang berhasil ditambahkan");
    exit;
}

$kategoriList = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Barang</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>
<main class="container">
    <h1>Tambah Barang Baru</h1>
    <form method="POST" class="form-card">
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" required>
        </div>
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori_id" required>
                <?php while ($k = mysqli_fetch_assoc($kategoriList)): ?>
                    <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Stok</label>
            <input type="number" name="stok" min="0" required>
        </div>
        <div class="form-group">
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" min="0" required>
        </div>
        <div class="form-group">
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" min="0" required>
        </div>
        <div class="form-group">
            <label>Kondisi</label>
            <select name="kondisi">
                <option value="Baru">Baru</option>
                <option value="Bekas">Bekas</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tanggal Masuk</label>
            <input type="date" name="tanggal_masuk" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="index.php" class="btn">Batal</a>
    </form>
</main>
</body>
</html>
