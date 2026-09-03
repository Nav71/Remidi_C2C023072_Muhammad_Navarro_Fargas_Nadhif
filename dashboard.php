<?php
require_once 'includes/cek_login.php';
require_once 'config/koneksi.php';

$totalBarang = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM barang"))['jumlah'];
$totalKategori = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM kategori"))['jumlah'];
$totalStok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(stok) AS jumlah FROM barang"))['jumlah'] ?? 0;
$stokMenipis = mysqli_query($koneksi, "SELECT * FROM barang WHERE stok <= 3 ORDER BY stok ASC");
$totalNilaiStok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT SUM(stok * harga_beli) AS total FROM barang"))['total'] ?? 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Inventaris Toko Musik</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<?php require_once 'includes/header.php'; ?>

<main class="container">
    <h1>Dashboard</h1>
    <p style="color:#888; margin-bottom:20px;">Selamat datang, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?> 👋</p>

    <div class="stat-cards">
        <div class="stat-card">
            <h3><?= $totalBarang ?></h3>
            <p>Jenis Barang</p>
        </div>
        <div class="stat-card">
            <h3><?= $totalKategori ?></h3>
            <p>Kategori</p>
        </div>
        <div class="stat-card">
            <h3><?= $totalStok ?></h3>
            <p>Total Stok Unit</p>
        </div>
        <div class="stat-card">
            <h3>Rp <?= number_format($totalNilaiStok, 0, ',', '.') ?></h3>
            <p>Estimasi Nilai Stok</p>
        </div>
    </div>

    <h2 style="margin-bottom:15px;">⚠️ Barang dengan Stok Menipis (≤ 3)</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if (mysqli_num_rows($stokMenipis) === 0): ?>
                <tr><td colspan="4">Tidak ada barang dengan stok menipis.</td></tr>
            <?php else: ?>
                <?php while ($row = mysqli_fetch_assoc($stokMenipis)): ?>
                <tr>
                    <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                    <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                    <td><span class="badge badge-low"><?= $row['stok'] ?></span></td>
                    <td><a href="barang/edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Update Stok</a></td>
                </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</main>
</body>
</html>
