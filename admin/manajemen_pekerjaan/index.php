<?php
// admin.portofolio_anda.com/manajemen_pekerjaan/index.php
$base_admin_url = "../";
include '../includes/admin_header.php';

$message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'added') {
        $message = '<div class="message success">Pekerjaan berhasil ditambahkan.</div>';
    } elseif ($_GET['status'] == 'updated') {
        $message = '<div class="message success">Pekerjaan berhasil diperbarui.</div>';
    } elseif ($_GET['status'] == 'deleted') {
        $message = '<div class="message success">Pekerjaan berhasil dihapus.</div>';
    } elseif ($_GET['status'] == 'error') {
        $message = '<div class="message error">Terjadi kesalahan saat operasi.</div>';
    }
}

$work_experiences = [];
try {
    $stmt = $pdo->query("SELECT * FROM work_experiences ORDER BY tanggal_mulai DESC, id DESC");
    $work_experiences = $stmt->fetchAll();
} catch (PDOException $e) {
    $message = '<div class="message error">Gagal mengambil data pekerjaan: ' . $e->getMessage() . '</div>';
}
?>

    <h2>Manajemen Pekerjaan</h2>
    <?php echo $message; ?>
    <p><a href="tambah_pekerjaan.php" class="btn">Tambah Pekerjaan Baru</a></p>

    <?php if (!empty($work_experiences)): ?>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Posisi</th>
                <th>Perusahaan</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($work_experiences as $work): ?>
            <tr>
                <td><?php echo htmlspecialchars($work['id']); ?></td>
                <td><?php echo htmlspecialchars($work['posisi']); ?></td>
                <td><?php echo htmlspecialchars($work['perusahaan']); ?></td>
                <td><?php echo htmlspecialchars($work['tanggal_mulai']); ?></td>
                <td><?php echo htmlspecialchars($work['tanggal_selesai']); ?></td>
                <td class="actions">
                    <a href="edit_pekerjaan.php?id=<?php echo htmlspecialchars($work['id']); ?>">Edit</a>
                    <a href="hapus_pekerjaan.php?id=<?php echo htmlspecialchars($work['id']); ?>" class="btn-delete-confirm delete">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Belum ada riwayat pekerjaan yang ditambahkan.</p>
    <?php endif; ?>

<?php
include '../includes/admin_footer.php';
?>