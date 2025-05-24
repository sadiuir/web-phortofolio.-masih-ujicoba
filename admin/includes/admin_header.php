<?php
// admin.portofolio_anda.com/includes/admin_header.php

// PATH KONEKSI DATABASE - SESUAIKAN DENGAN STRUKTUR!
// Jika file ini di `admin.portofolio_anda.com/includes/`, dan `koneksi_db.php` di `/www/wwwroot/config/`
// Maka kita perlu naik 2 level dari `includes/` ke `/www/wwwroot/` lalu masuk ke `config/`
require_once __DIR__ . '/../../config/koneksi_db.php';

// Jika Anda ingin menggunakan sesi untuk login, aktifkan session_start()
// session_start();
// if (!isset($_SESSION['admin_logged_in'])) {
//     header("Location: login.php");
//     exit();
// }

// Variabel untuk menyesuaikan path relatif di header/footer
// Sesuaikan $base_admin_url ini tergantung lokasi file yang meng-include header ini
// Contoh:
// Jika file yang meng-include ada di root admin (dashboard.php), maka $base_admin_url = "./";
// Jika file yang meng-include ada di subfolder (manajemen_proyek/index.php), maka $base_admin_url = "../";
// Jika ada di subfolder lain (manajemen_proyek/tambah_proyek.php), maka $base_admin_url = "../";
$base_admin_url = "./"; // Default, asumsikan di root admin
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Portofolio</title>
    <link rel="stylesheet" href="<?php echo $base_admin_url; ?>css/admin_style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header class="admin-header">
        <h1><a href="<?php echo $base_admin_url; ?>dashboard.php">Admin Portofolio</a></h1>
        <nav class="admin-nav">
            <ul>
                <li><a href="<?php echo $base_admin_url; ?>dashboard.php">Dashboard</a></li>
                <li><a href="<?php echo $base_admin_url; ?>manajemen_proyek/index.php">Manajemen Proyek</a></li>
                <li><a href="<?php echo $base_admin_url; ?>manajemen_pekerjaan/index.php">Manajemen Pekerjaan</a></li>
                <li><a href="<?php echo $base_admin_url; ?>logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <main class="container">