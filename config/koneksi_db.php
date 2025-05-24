<?php
// config/koneksi_db.php

$host = 'localhost'; // Sesuaikan jika database server Anda berbeda
$db = 'nama_database_anda'; // GANTI dengan nama database Anda
$user = 'user_database_anda'; // GANTI dengan username database Anda
$pass = 'password_database_anda'; // GANTI dengan password database Anda
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    // Untuk pengembangan, tampilkan error. Untuk produksi, log error dan tampilkan pesan umum.
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
    // Atau: die("Koneksi database gagal. Silakan coba lagi nanti.");
}
?>