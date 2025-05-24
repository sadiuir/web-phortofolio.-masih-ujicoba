<?php
// portofolio_anda.com/partials/header.php
// Sesuaikan path koneksi_db.php jika struktur folder berubah
require_once __DIR__ . '/../config/koneksi_db.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio [Nama Anda]</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <a href="index.php" class="logo">Portofolio Saya</a>
        <nav>
            <ul>
                <li><a href="index.php#about">Tentang Saya</a></li>
                <li><a href="pekerjaan.php">Pengalaman</a></li>
                <li><a href="proyek.php">Proyek</a></li>
                <li><a href="kontak.php">Kontak</a></li>
            </ul>
        </nav>
        <div id="digital-clock"></div> </header>
    <main>