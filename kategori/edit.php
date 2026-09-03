<?php
require_once '../includes/cek_login.php';
require_once '../config/koneksi.php';

$id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_kategori']);
    $keterangan = trim($_POST['keterangan']);
    $id = $_POST['id'];

    $stmt = mysqli_prepare($koneksi, "UPDATE kategori SET nama_kategori = ?, keterangan = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssi", $nama, $keterangan, $id);
    mysqli_stmt_execute($stmt);

    header("Location: index.php?sukses=Kategori berhasil diperbarui");
    exit;
}

$stmt = mysqli_prepare($koneksi, "SELECT * FROM kategori WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$kategori = mysqli_stmt_get_result($stmt)->fetch_assoc();

if (!$kategori) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Kategori</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<?php require_once '../includes/header.php'; ?>
<main class="container">
    <h1>Edit Kategori</h1>
    <form method="POST" class="form-card">
        <input type="hidden" name="id" value="<?= $kategori['id'] ?>">
        <div class="form-group">
            <label>Nama Kategori</label>
            <input type="text" name="nama_kategori" value="<?= htmlspecialchars($kategori['nama_kategori']) ?>" required>
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea name="keterangan" rows="3"><?= htmlspecialchars($kategori['keterangan']) ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="index.php" class="btn">Batal</a>
    </form>
</main>
</body>
</html>
