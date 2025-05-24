<?php
// portofolio/proyek.php
include 'partials/header.php';

$projects = [];
try {
    $stmt = $pdo->query("SELECT * FROM projects ORDER BY tahun_proyek DESC, id DESC");
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    // Tangani error
}
?>

<section id="projects" class="container">
    <h2>Proyek & Tugas Besar</h2>
    <?php if (!empty($projects)): ?>
    <div class="card-grid">
        <?php foreach ($projects as $project): ?>
        <div class="card">
            <?php if (!empty($project['gambar_url'])): ?>
                <img src="uploads/proyek/<?php echo htmlspecialchars($project['gambar_url']); ?>" alt="<?php echo htmlspecialchars($project['judul_proyek']); ?>" class="card-image">
            <?php endif; ?>
            <div class="card-content">
                <h3 class="card-title"><?php echo htmlspecialchars($project['judul_proyek']); ?></h3>
                <p class="card-description"><?php echo nl2br(htmlspecialchars($project['deskripsi_singkat'])); ?></p>
                <?php if (!empty($project['teknologi_digunakan'])): ?>
                    <p class="card-meta">Teknologi: <?php echo htmlspecialchars($project['teknologi_digunakan']); ?></p>
                <?php endif; ?>
                <p class="card-meta">Tahun: <?php echo htmlspecialchars($project['tahun_proyek']); ?></p>
                <div class="card-links">
                    <?php if (!empty($project['tautan_github_url'])): ?>
                        <a href="<?php echo htmlspecialchars($project['tautan_github_url']); ?>" target="_blank"><i class="fab fa-github"></i> GitHub</a>
                    <?php endif; ?>
                    <?php if (!empty($project['tautan_demo_url'])): ?>
                        <a href="<?php echo htmlspecialchars($project['tautan_demo_url']); ?>" target="_blank"><i class="fas fa-external-link-alt"></i> Demo</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
        <p style="text-align: center;">Belum ada proyek yang ditampilkan.</p>
    <?php endif; ?>
</section>

<?php
include 'partials/footer.php';
?>