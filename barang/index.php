<?php
require_once '../includes/cek_login.php';
require_once '../config/koneksi.php';

$sukses = $_GET['sukses'] ?? '';
$cari = trim($_GET['cari'] ?? '');
$filter_kategori = $_GET['kategori_id'] ?? '';

$sql = "SELECT b.*, k.nama_kategori FROM barang b
        JOIN kategori k ON b.kategori_id = k.id WHERE 1=1";
$params = [];
$types = "";

if ($cari !== '') {
    $sql .= " AND (b.nama_barang LIKE ? OR b.kode_barang LIKE ?)";
    $like = "%$cari%";
    $params[] = $like; $params[] = $like;
    $types .= "ss";
}
if ($filter_kategori !== '') {
    $sql .= " AND b.kategori_id = ?";
    $params[] = $filter_kategori;
    $types .= "i";
}
$sql .= " ORDER BY b.nama_barang ASC";

$stmt = mysqli_prepare($koneksi, $sql);
if ($types) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$kategoriList = mysqli_query($koneksi, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Barang - Inventaris Toko Musik</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>

<main class="container">
    <div class="page-header">
        <h1>Data Barang</h1>
        <a href="tambah.php" class="btn btn-primary">+ Tambah Barang</a>
    </div>

    <?php if ($sukses): ?>
        <div class="alert alert-success"><?= htmlspecialchars($sukses) ?></div>
    <?php endif; ?>

    <form method="GET" class="filter-bar">
        <input type="text" name="cari" placeholder="Cari nama/kode barang..." value="<?= htmlspecialchars($cari) ?>">
        <select name="kategori_id">
            <option value="">Semua Kategori</option>
            <?php mysqli_data_seek($kategoriList, 0); while ($k = mysqli_fetch_assoc($kategoriList)): ?>
                <option value="<?= $k['id'] ?>" <?= $filter_kategori == $k['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($k['nama_kategori']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" class="btn btn-primary">Filter</button>
        <a href="index.php" class="btn">Reset</a>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Stok</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Kondisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?= htmlspecialchars($row['kode_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_barang']) ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']) ?></td>
                <td>
                    <?= $row['stok'] ?>
                    <?php if ($row['stok'] <= 3): ?>
                        <span class="badge badge-low">Menipis</span>
                    <?php else: ?>
                        <span class="badge badge-ok">Aman</span>
                    <?php endif; ?>
                </td>
                <td>Rp <?= number_format($row['harga_beli'], 0, ',', '.') ?></td>
                <td>Rp <?= number_format($row['harga_jual'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['kondisi']) ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                    <a href="hapus.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                       onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</main>
</body>
</html>
