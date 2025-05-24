<?php
// portofolio/index.php
include 'partials/header.php';

// Ambil data "Tentang Saya"
$about_me = [];
try {
    $stmt = $pdo->query("SELECT * FROM about_me LIMIT 1");
    $about_me = $stmt->fetch();
} catch (PDOException $e) {
    // Tangani error, misalnya:
    // echo "Error: " . $e->getMessage();
    // Untuk produksi, tampilkan pesan ramah pengguna atau log error
}
?>

<section id="about" class="container">
    <h2>Tentang Saya</h2>
    <?php if ($about_me): ?>
    <div class="about-content">
        <?php if (!empty($about_me['foto_profil_url'])): ?>
            <div class="about-image">
                <img src="uploads/profil/<?php echo htmlspecialchars($about_me['foto_profil_url']); ?>" alt="<?php echo htmlspecialchars($about_me['nama']); ?>">
            </div>
        <?php endif; ?>
        <div class="about-text">
            <h3>Halo, saya <?php echo htmlspecialchars($about_me['nama']); ?>!</h3>
            <p><?php echo nl2br(htmlspecialchars($about_me['bio_singkat'])); ?></p>
            <p><?php echo nl2br(htmlspecialchars($about_me['deskripsi_lengkap'])); ?></p>
            <?php if (!empty($about_me['keahlian_utama'])): ?>
                <p class="skills">Keahlian Utama:
                    <?php
                    $keahlian = explode(',', $about_me['keahlian_utama']);
                    foreach ($keahlian as $skill) {
                        echo '<span>' . htmlspecialchars(trim($skill)) . '</span>';
                    }
                    ?>
                </p>
            <?php endif; ?>
        </div>
    </div>
    <?php else: ?>
        <p style="text-align: center;">Informasi tentang saya belum tersedia.</p>
    <?php endif; ?>
</section>

<?php
include 'partials/footer.php';
?>