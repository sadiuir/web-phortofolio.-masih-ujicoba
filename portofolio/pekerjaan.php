<?php
// portofolio/pekerjaan.php
include 'partials/header.php';

$work_experiences = [];
try {
    $stmt = $pdo->query("SELECT * FROM work_experiences ORDER BY tanggal_mulai DESC, id DESC");
    $work_experiences = $stmt->fetchAll();
} catch (PDOException $e) {
    // Tangani error
}
?>

<section id="work" class="container">
    <h2>Riwayat Pekerjaan</h2>
    <?php if (!empty($work_experiences)): ?>
    <div class="card-grid">
        <?php foreach ($work_experiences as $work): ?>
        <div class="card">
            <?php if (!empty($work['logo_perusahaan_url'])): ?>
                <img src="uploads/logos_perusahaan/<?php echo htmlspecialchars($work['logo_perusahaan_url']); ?>" alt="<?php echo htmlspecialchars($work['perusahaan']); ?> Logo" class="card-image">
            <?php endif; ?>
            <div class="card-content">
                <h3 class="card-title"><?php echo htmlspecialchars($work['posisi']); ?></h3>
                <p class="card-meta"><?php echo htmlspecialchars($work['perusahaan']); ?></p>
                <p class="card-meta"><?php echo htmlspecialchars($work['tanggal_mulai']) . ' - ' . htmlspecialchars($work['tanggal_selesai']); ?></p>
                <p class="card-description"><?php echo nl2br(htmlspecialchars($work['deskripsi_pekerjaan_singkat'])); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p style="text-align: center;">Belum ada riwayat pekerjaan yang ditampilkan.</p>
    <?php endif; ?>

    <h2 style="margin-top: 60px;">Riwayat Pendidikan</h2>
    <?php
    $educations = [];
    try {
        $stmt = $pdo->query("SELECT * FROM educations ORDER BY tahun_lulus DESC, id DESC");
        $educations = $stmt->fetchAll();
    } catch (PDOException $e) { /* Tangani error */ }
    ?>
    <?php if (!empty($educations)): ?>
    <div class="card-grid">
        <?php foreach ($educations as $edu): ?>
        <div class="card">
            <?php if (!empty($edu['logo_institusi_url'])): ?>
                <img src="uploads/logos_institusi/<?php echo htmlspecialchars($edu['logo_institusi_url']); ?>" alt="<?php echo htmlspecialchars($edu['institusi']); ?> Logo" class="card-image">
            <?php endif; ?>
            <div class="card-content">
                <h3 class="card-title"><?php echo htmlspecialchars($edu['jurusan']); ?></h3>
                <p class="card-meta"><?php echo htmlspecialchars($edu['institusi']); ?></p>
                <p class="card-meta"><?php echo htmlspecialchars($edu['jenjang']); ?> - <?php echo htmlspecialchars($edu['tahun_lulus']); ?></p>
                <p class="card-description"><?php echo nl2br(htmlspecialchars($edu['deskripsi_singkat'])); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p style="text-align: center;">Belum ada riwayat pendidikan yang ditampilkan.</p>
    <?php endif; ?>

    <h2 style="margin-top: 60px;">Riwayat Sertifikasi</h2>
    <?php
    $certifications = [];
    try {
        $stmt = $pdo->query("SELECT * FROM certifications ORDER BY tanggal_terbit DESC, id DESC");
        $certifications = $stmt->fetchAll();
    } catch (PDOException $e) { /* Tangani error */ }
    ?>
    <?php if (!empty($certifications)): ?>
    <div class="card-grid">
        <?php foreach ($certifications as $cert): ?>
        <div class="card">
            <div class="card-content">
                <h3 class="card-title"><?php echo htmlspecialchars($cert['nama_sertifikasi']); ?></h3>
                <p class="card-meta">Penerbit: <?php echo htmlspecialchars($cert['penerbit']); ?></p>
                <p class="card-meta">Tanggal Terbit: <?php echo htmlspecialchars($cert['tanggal_terbit']); ?></p>
                <?php if (!empty($cert['tautan_sertifikasi_url'])): ?>
                    <div class="card-links" style="margin-top: 15px;">
                        <a href="<?php echo htmlspecialchars($cert['tautan_sertifikasi_url']); ?>" target="_blank"><i class="fas fa-award"></i> Lihat Sertifikat</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p style="text-align: center;">Belum ada riwayat sertifikasi yang ditampilkan.</p>
    <?php endif; ?>
</section>

<?php
include 'partials/footer.php';
?>