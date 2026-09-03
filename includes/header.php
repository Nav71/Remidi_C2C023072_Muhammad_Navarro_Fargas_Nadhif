<header class="navbar">
    <div class="navbar-brand">Inventaris Toko Musik</div>
    <nav class="navbar-menu">
        <a href="/inventaris-toko-musik/dashboard.php">Dashboard</a>
        <a href="/inventaris-toko-musik/kategori/index.php">Kategori</a>
        <a href="/inventaris-toko-musik/barang/index.php">Barang</a>
    </nav>
    <div class="navbar-user">
        <span>👤 <?= htmlspecialchars($_SESSION['nama_lengkap'] ?? '') ?></span>
        <a href="/inventaris-toko-musik/auth/logout.php" class="btn btn-danger btn-sm">Logout</a>
    </div>
</header>
