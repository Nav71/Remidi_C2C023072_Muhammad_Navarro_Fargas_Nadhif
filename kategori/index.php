<?php
require_once '../includes/cek_login.php';
require_once '../config/koneksi.php';

$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : '';
$result = mysqli_query($koneksi, "SELECT k.*, (SELECT COUNT(*) FROM barang b WHERE b.kategori_id = k.id) AS jumlah_barang FROM kategori k ORDER BY k.nama_kategori ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kategori - Inventaris Toko Musik</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>

<main class="container">
    <div class="page-header">
        <h1>Data Kategori Barang</h1>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Kategori</a>
    </div>

    <?php if ($sukses): ?>
        <div class="alert alert-success"><?= htmlspecialchars($sukses) ?></div>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Keterangan</th>
                <th>Jumlah Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td><?= htmlspecialchars($row['keterangan']) ?></td>
                <td><?= $row['jumlah_barang'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus kategori ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
</body>
</html>
