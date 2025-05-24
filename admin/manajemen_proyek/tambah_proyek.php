<?php
// admin.portofolio_anda.com/manajemen_proyek/tambah_proyek.php
$base_admin_url = "../";
include '../includes/admin_header.php';

$message = '';
$upload_dir_proyek = '../../portofolio_anda.com/uploads/proyek/'; // Direktori upload di sisi portofolio

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul_proyek = htmlspecialchars(trim($_POST['judul_proyek'] ?? ''));
    $deskripsi_singkat = htmlspecialchars(trim($_POST['deskripsi_singkat'] ?? ''));
    $tautan_github_url = htmlspecialchars(trim($_POST['tautan_github_url'] ?? ''));
    $tautan_demo_url = htmlspecialchars(trim($_POST['tautan_demo_url'] ?? ''));
    $tahun_proyek = htmlspecialchars(trim($_POST['tahun_proyek'] ?? ''));
    $teknologi_digunakan = htmlspecialchars(trim($_POST['teknologi_digunakan'] ?? ''));
    $gambar_url = '';

    if (!empty($judul_proyek) && !empty($deskripsi_singkat) && !empty($tahun_proyek)) {
        // Handle file upload
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
                    $gambar_url = $newFileName;
                } else {
                    $message = '<div class="message error">Gagal mengunggah gambar.</div>';
                }
            } else {
                $message = '<div class="message error">Ekstensi file tidak diizinkan. Hanya JPG, JPEG, PNG, GIF.</div>';
            }
        }

        if (empty($message)) { // Lanjutkan jika tidak ada error upload
            try {
                $stmt = $pdo->prepare("INSERT INTO projects (judul_proyek, deskripsi_singkat, gambar_url, tautan_github_url, tautan_demo_url, tahun_proyek, teknologi_digunakan) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$judul_proyek, $deskripsi_singkat, $gambar_url, $tautan_github_url, $tautan_demo_url, $tahun_proyek, $teknologi_digunakan]);
                header("Location: index.php?status=added");
                exit();
            } catch (PDOException $e) {
                $message = '<div class="message error">Gagal menambahkan proyek: ' . $e->getMessage() . '</div>';
            }
        }
    } else {
        $message = '<div class="message error">Semua kolom wajib diisi (Judul, Deskripsi, Tahun).</div>';
    }
}
?>

    <h2>Tambah Proyek Baru</h2>
    <?php echo $message; ?>
    <form action="tambah_proyek.php" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="judul_proyek">Judul Proyek:</label>
            <input type="text" id="judul_proyek" name="judul_proyek" required>
        </div>
        <div class="form-group">
            <label for="deskripsi_singkat">Deskripsi Singkat:</label>
            <textarea id="deskripsi_singkat" name="deskripsi_singkat" required></textarea>
        </div>
        <div class="form-group">
            <label for="gambar_url">Gambar Proyek:</label>
            <input type="file" id="gambar_url" name="gambar_url" accept="image/*">
        </div>
        <div class="form-group">
            <label for="tautan_github_url">Tautan GitHub (URL):</label>
            <input type="text" id="tautan_github_url" name="tautan_github_url">
        </div>
        <div class="form-group">
            <label for="tautan_demo_url">Tautan Demo (URL):</label>
            <input type="text" id="tautan_demo_url" name="tautan_demo_url">
        </div>
        <div class="form-group">
            <label for="tahun_proyek">Tahun Proyek:</label>
            <input type="text" id="tahun_proyek" name="tahun_proyek" required placeholder="YYYY">
        </div>
        <div class="form-group">
            <label for="teknologi_digunakan">Teknologi Digunakan (Pisahkan dengan koma):</label>
            <input type="text" id="teknologi_digunakan" name="teknologi_digunakan">
        </div>
        <button type="submit" class="btn">Tambah Proyek</button>
        <a href="index.php" class="btn btn-secondary">Batal</a>
    </form>

<?php
include '../includes/admin_footer.php';
?>