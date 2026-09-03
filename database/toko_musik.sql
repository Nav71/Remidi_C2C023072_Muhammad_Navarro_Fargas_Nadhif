-- =====================================================
-- Database: toko_musik
-- Sistem Inventaris Barang Toko Musik
-- =====================================================

CREATE DATABASE IF NOT EXISTS toko_musik;
USE toko_musik;

-- Tabel users (admin/karyawan)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    level ENUM('admin','staff') NOT NULL DEFAULT 'staff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel kategori barang
CREATE TABLE kategori (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    keterangan VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabel barang
CREATE TABLE barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode_barang VARCHAR(20) NOT NULL UNIQUE,
    nama_barang VARCHAR(150) NOT NULL,
    kategori_id INT NOT NULL,
    stok INT NOT NULL DEFAULT 0,
    harga_beli DECIMAL(12,2) NOT NULL DEFAULT 0,
    harga_jual DECIMAL(12,2) NOT NULL DEFAULT 0,
    kondisi ENUM('Baru','Bekas') NOT NULL DEFAULT 'Baru',
    deskripsi TEXT DEFAULT NULL,
    tanggal_masuk DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(id) ON DELETE CASCADE
);

-- Data awal user (password: admin123, di-hash dengan password_hash PHP)
INSERT INTO users (username, password, nama_lengkap, level) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin');

-- Data awal kategori
INSERT INTO kategori (nama_kategori, keterangan) VALUES
('Gitar', 'Gitar akustik, elektrik, dan bass'),
('Drum', 'Drum set dan perkusi'),
('Keyboard', 'Keyboard dan piano digital'),
('Alat Tiup', 'Saxophone, trompet, seruling, dll'),
('Aksesoris', 'Senar, stik drum, kabel, tas, dll');

-- Data awal barang (contoh)
INSERT INTO barang (kode_barang, nama_barang, kategori_id, stok, harga_beli, harga_jual, kondisi, deskripsi, tanggal_masuk) VALUES
('BRG001', 'Gitar Akustik Yamaha F310', 1, 10, 1200000, 1500000, 'Baru', 'Gitar akustik populer untuk pemula', '2025-01-10'),
('BRG002', 'Drum Set Pearl Export', 2, 3, 8000000, 9500000, 'Baru', 'Drum set 5 piece', '2025-01-15'),
('BRG003', 'Keyboard Yamaha PSR-E373', 3, 5, 2500000, 3000000, 'Baru', 'Keyboard 61 keys', '2025-02-01');
