<?php
// admin.portofolio_anda.com/manajemen_proyek/edit_proyek.php
$base_admin_url = "../";
include '../includes/admin_header.php';

$message = '';
$project_id = $_GET['id'] ?? null;
$project = null;
$upload_dir_proyek = '../../portofolio_anda.com/uploads/proyek/'; // Direktori upload di sisi portofolio

if ($project_id) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$project_id]);
        $project = $stmt->fetch();

        if (!$project) {
            $message = '<div class="message error">Proyek tidak ditemukan.</div>';
        }
    } catch (PDOException $e) {
        $message = '<div class="message error">Gagal mengambil data proyek: ' . $e->getMessage() . '</div>';
    }
} else {
    $message = '<div class="message error">ID proyek tidak diberikan.</div>';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $project) {
    $judul_proyek = htmlspecialchars(trim($_POST['judul_proyek'] ?? ''));
    $deskripsi_singkat = htmlspecialchars(trim($_POST['deskripsi_singkat'] ?? ''));
    $tautan_github_url = htmlspecialchars(trim($_POST['tautan_github_url'] ?? ''));
    $tautan_demo_url = htmlspecialchars(trim($_POST['tautan_demo_url'] ?? ''));
    $tahun_proyek = htmlspecialchars(trim($_POST['tahun_proyek'] ?? ''));
    $teknologi_digunakan = htmlspecialchars(trim($_POST['teknologi_digunakan'] ?? ''));
    $gambar_url = $project['gambar_url']; // Pertahankan gambar lama secara default

    if (!empty($judul_proyek) && !empty($deskripsi_singkat) && !empty($tahun_proyek)) {
        // Handle file upload jika ada gambar baru
        if (isset($_FILES['gambar_url']) && $_FILES['gambar_url']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['gambar_url']['tmp_name'];
            $fileName = $_FILES['gambar_url']['name'];
            $fileSize = $_FILES['gambar_url']['size'];
            $fileType = $_FILES['gambar_url']['type'];
            $fileNameCmps = explode(".", $fileName);
            $fileExtension = strtolower(end($fileNameCmps));

            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
            $dest_path = $upload_dir_proyek . $newFileName;

            $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
            if (in_array($fileExtension, $allowedfileExtensions)) {
                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    // Hapus gambar lama jika ada
                    if (!empty($project['gambar_url']) && file_exists($upload_dir_proyek . $project['gambar_url'])) {
                        unlink($upload_dir_proyek . $project['gambar_url']);
                    }
                    $gambar_url = $newFileName;
                } else {
                    $message = '<div class="message error">Gagal mengunggah gambar baru.</div>';
                }
            } else {
                $message = '<div class="message error">Ekstensi file gambar baru tidak diizinkan.</div>';
            }
        }

        if (empty($message)) { // Lanjutkan jika tidak ada error upload
            try {
                $stmt = $pdo->prepare("UPDATE projects SET judul_proyek = ?, deskripsi_singkat = ?, gambar_url = ?, tautan_github_url = ?, tautan_demo_url = ?, tahun_proyek = ?, teknologi_digunakan = ? WHERE id = ?");
                $stmt->execute([$judul_proyek, $deskripsi_singkat, $gambar_url, $tautan_github_url, $tautan_demo_url, $tahun_proyek, $teknologi_digunakan, $project_id]);
                header("Location: index.php?status=updated");
                exit();
            } catch (PDOException $e) {
                $message = '<div class="message error">Gagal memperbarui proyek: ' . $e->getMessage() . '</div>';
            }
        }
    } else {
        $message = '<div class="message error">Semua kolom wajib diisi (Judul, Deskripsi, Tahun).</div>';
    }
}
?>

    <h2>Edit Proyek</h2>
    <?php echo $message; ?>

    <?php if ($project): ?>
    <form action="edit_proyek.php?id=<?php echo htmlspecialchars($project_id); ?>" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul_proyek">Judul Proyek:</label>
            <input type="text" id="judul_proyek" name="judul_proyek" value="<?php echo htmlspecialchars($project['judul_proyek']); ?>" required>
        </div>
        <div class="form-group">
            <label for="deskripsi_singkat">Deskripsi Singkat:</label>
            <textarea id="deskripsi_singkat" name="deskripsi_singkat" required><?php echo htmlspecialchars($project['deskripsi_singkat']); ?></textarea>
        </div>
        <div class="form-group">
            <label for="gambar_url">Gambar Proyek Saat Ini:</label>
            <?php if (!empty($project['gambar_url'])): ?>
                <img src="../../portofolio_anda.com/uploads/proyek/<?php echo htmlspecialchars($project['gambar_url']); ?>" alt="Gambar Saat Ini" width="150"><br>
            <?php else: ?>
                <p>Tidak ada gambar.</p>
            <?php endif; ?>
            <label for="gambar_url_new">Ganti Gambar Proyek (Biarkan kosong jika tidak ingin mengubah):</label>
            <input type="file" id="gambar_url_new" name="gambar_url" accept="image/*">
        </div>
        <div class="form-group">
            <label for="tautan_github_url">Tautan GitHub (URL):</label>
            <input type="text" id="tautan_github_url" name="tautan_github_url" value="<?php echo htmlspecialchars($project['tautan_github_url']); ?>">
        </div>
        <div class="form-group">
            <label for="tautan_demo_url">Tautan Demo (URL):</label>
            <input type="text" id="tautan_demo_url" name="tautan_demo_url" value="<?php echo htmlspecialchars($project['tautan_demo_url']); ?>">
        </div>
        <div class="form-group">
            <label for="tahun_proyek">Tahun Proyek:</label>
            <input type="text" id="tahun_proyek" name="tahun_proyek" value="<?php echo htmlspecialchars($project['tahun_proyek']); ?>" required placeholder="YYYY">
        </div>
        <div class="form-group">
            <label for="teknologi_digunakan">Teknologi Digunakan (Pisahkan dengan koma):</label>
            <input type="text" id="teknologi_digunakan" name="teknologi_digunakan" value="<?php echo htmlspecialchars($project['teknologi_digunakan']); ?>">
        </div>
        <button type="submit" class="btn">Perbarui Proyek</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>
    <?php endif; ?>

<?php
include '../includes/admin_footer.php';
?>