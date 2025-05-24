<?php
// admin.portofolio_anda.com/manajemen_proyek/hapus_proyek.php
require_once __DIR__ . '/../../config/koneksi_db.php'; // Sesuaikan path

$project_id = $_GET['id'] ?? null;
$upload_dir_proyek = '../../portofolio_anda.com/uploads/proyek/'; // Direktori upload di sisi portofolio

if ($project_id) {
    try {
        // Ambil nama file gambar terlebih dahulu untuk dihapus dari server
        $stmt_gambar = $pdo->prepare("SELECT gambar_url FROM projects WHERE id = ?");
        $stmt_gambar->execute([$project_id]);
        $project_gambar = $stmt_gambar->fetchColumn();

        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
        $stmt->execute([$project_id]);

        if ($stmt->rowCount() > 0) {
            // Hapus file gambar dari server jika ada
            if (!empty($project_gambar) && file_exists($upload_dir_proyek . $project_gambar)) {
                unlink($upload_dir_proyek . $project_gambar);
            }
            header("Location: index.php?status=deleted");
            exit();
        } else {
            header("Location: index.php?status=error&msg=notfound");
            exit();
        }
    } catch (PDOException $e) {
        header("Location: index.php?status=error&msg=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    header("Location: index.php?status=error&msg=no_id");
    exit();
}
?>