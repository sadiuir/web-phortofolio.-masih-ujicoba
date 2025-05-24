<?php
// admin.portofolio_anda.com/manajemen_proyek/index.php
$base_admin_url = "../"; // Karena di dalam subfolder manajemen_proyek
include '../includes/admin_header.php'; // Path relatif dari folder ini ke admin_header.php

$message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'added') {
        $message = '<div class="message success">Proyek berhasil ditambahkan.</div>';
    } elseif ($_GET['status'] == 'updated') {
        $message = '<div class="message success">Proyek berhasil diperbarui.</div>';
    } elseif ($_GET['status'] == 'deleted') {
        $message = '<div class="message success">Proyek berhasil dihapus.</div>';
    } elseif ($_GET['status'] == 'error') {
        $message = '<div class="message error">Terjadi kesalahan saat operasi.</div>';
    }
}

$projects = [];
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY tahun_proyek DESC, id DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = '<div class="message error">Gagal mengambil data proyek: ' . $e->getMessage() . '</div>';
}
?>

    <h2>Manajemen Proyek</h2>
    <?php echo $message; ?>
    <p><a href="tambah_proyek.php" class="btn">Tambah Proyek Baru</a></p>

    <?php if (!empty($projects)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Proyek</th>
                <th>Tahun</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($projects as $project): ?>
            <tr>
                <td><?php echo htmlspecialchars($project['id']); ?></td>
                <td><?php echo htmlspecialchars($project['judul_proyek']); ?></td>
                <td><?php echo htmlspecialchars($project['tahun_proyek']); ?></td>
                <td>
                    <?php if (!empty($project['gambar_url'])): ?>
                        <img src="../../portofolio_anda.com/uploads/proyek/<?php echo htmlspecialchars($project['gambar_url']); ?>" alt="Gambar Proyek" width="50">
                    <?php else: ?>
                        -
                    <?php endif; ?>
                </td>
                <td class="actions">
                    <a href="edit_proyek.php?id=<?php echo htmlspecialchars($project['id']); ?>">Edit</a>
                    <a href="hapus_proyek.php?id=<?php echo htmlspecialchars($project['id']); ?>" class="btn-delete-confirm delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Belum ada proyek yang ditambahkan.</p>
    <?php endif; ?>

<?php
include '../includes/admin_footer.php';
?>