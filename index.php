<?php
include 'koneksi.php';

$profile    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM profile LIMIT 1")) ?? [];
$about      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM about LIMIT 1")) ?? [];
$skills     = mysqli_query($conn, "SELECT * FROM skills");
$sertifikat = mysqli_query($conn, "SELECT * FROM sertifikat");
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio — <?= htmlspecialchars($profile['name'] ?? 'Portfolio') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top glass-navbar">
        <div class="container">
            <a class="navbar-brand" href="#home"><?= htmlspecialchars($profile['name'] ?? 'Portfolio') ?></a>

            <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto nav-spacing">
                    <li class="nav-item"><a class="nav-link" href="#home">Beranda</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="#sertifikat">Sertifikat</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Kontak</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center gy-5">

                <div class="col-md-6 text-center text-md-start">
                    <p class="hero-eyebrow">Perkenalkan, Saya</p>

                    <h1 class="hero-name">
                        <?php
                        $parts = explode(' ', trim($profile['name'] ?? 'Nama'), 2);
                        echo htmlspecialchars($parts[0]);
                        if (!empty($parts[1])) echo ' <em>' . htmlspecialchars($parts[1]) . '</em>';
                        ?>
                    </h1>

                    <p class="hero-desc"><?= htmlspecialchars($profile['description'] ?? '') ?></p>

                    <div class="d-flex gap-3 justify-content-center justify-content-md-start flex-wrap">
                        <a href="#about" class="btn-hero">
                            Tentang Saya&nbsp;<i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="#contact" class="btn-hero btn-outline">Kontak</a>
                    </div>
                </div>

                <div class="col-md-6 hero-image-wrapper">
                    <div class="hero-image-frame">
                        <img src="images/Profil1_.jpg"
                            alt="<?= htmlspecialchars($profile['name'] ?? '') ?>"
                            class="hero-image">

                        <div class="hero-badge">
                            <div class="hero-badge-icon"><i class="bi bi-mortarboard-fill"></i></div>
                            <div class="hero-badge-text">
                                <strong>Sistem Informasi</strong>
                                Universitas Mulawarman
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="about" class="about-section">
        <div class="container">

            <div class="text-center mb-5 reveal">
                <p class="section-tag" style="justify-content:center">Siapa Saya</p>
                <h2 class="section-title">Tentang Saya</h2>
            </div>

            <div class="row g-4 align-items-stretch">

                <div class="col-md-6 reveal">
                    <div class="about-card h-100 p-4 p-lg-5 text-center d-flex flex-column align-items-center justify-content-center">
                        <img src="<?= htmlspecialchars($about['image'] ?? '') ?>"
                            alt="Foto"
                            class="about-image mb-4">
                        <h4 class="card-title-serif mb-3"><?= htmlspecialchars($about['title'] ?? '') ?></h4>
                        <p style="font-size:.92rem;color:var(--ink-soft);margin:0">
                            <?= htmlspecialchars($about['description'] ?? '') ?>
                        </p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="row g-4 h-100">

                        <!-- Skills -->
                        <div class="col-12 reveal reveal-d1">
                            <div class="about-card p-4 p-lg-5" id="skills-card">
                                <p class="section-tag">Kemampuan</p>
                                <h5 class="card-title-serif mb-1">Skill</h5>
                                <div class="divider"></div>

                                <?php while ($skill = mysqli_fetch_assoc($skills)):
                                    $lvl = (int)($skill['level'] ?? 0);
                                ?>
                                    <div class="skill-row">
                                        <div class="skill-label">
                                            <span><?= htmlspecialchars($skill['name']) ?></span>
                                            <span class="skill-pct"><?= $lvl ?>%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="skill-bar" data-width="<?= $lvl ?>"></div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>

                            </div>
                        </div>

                        <div class="col-12 reveal reveal-d2">
                            <div class="about-card p-4 p-lg-5">
                                <div class="exp-chip"><i class="bi bi-briefcase-fill"></i>&nbsp;Pengalaman</div>
                                <h5 class="card-title-serif mb-1">Riwayat</h5>
                                <div class="divider"></div>
                                <p style="font-size:.92rem;color:var(--ink-soft);margin:0">
                                    <?= htmlspecialchars($profile['experience'] ?? '') ?>
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="sertifikat" class="cert-section">
        <div class="container">

            <div class="text-center mb-5 reveal">
                <p class="section-tag" style="justify-content:center">Pencapaian</p>
                <h2 class="section-title">Sertifikat</h2>
            </div>

            <?php
            $certData = [];
            $certRows = [];
            while ($cert = mysqli_fetch_assoc($sertifikat)) {
                $certRows[] = $cert;
            }
            ?>

            <div class="row g-4">
                <?php foreach ($certRows as $i => $cert): ?>
                    <div class="col-lg-4 col-md-6 reveal reveal-d<?= ($i % 3) + 1 ?>">
                        <div class="certificate-card"
                            onclick="openLightbox(<?= $i ?>)"
                            role="button"
                            tabindex="0"
                            onkeydown="if(event.key==='Enter'||event.key===' ')openLightbox(<?= $i ?>)">

                            <div class="cert-zoom-icon">
                                <i class="bi bi-zoom-in"></i>
                            </div>

                            <div class="certificate-image-wrap">
                                <img src="<?= htmlspecialchars($cert['image']) ?>"
                                    alt="<?= htmlspecialchars($cert['title']) ?>"
                                    class="certificate-image"
                                    loading="lazy">
                            </div>
                            <div class="cert-body">
                                <h6 class="cert-title"><?= htmlspecialchars($cert['title']) ?></h6>
                                <p class="cert-desc mb-0"><?= htmlspecialchars($cert['description']) ?></p>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        </div>
    </section>

    <div class="lightbox-overlay" id="lightbox" role="dialog" aria-modal="true" aria-label="Sertifikat Detail">
        <div class="lightbox-inner">
            <button class="lightbox-close" onclick="closeLightbox()" aria-label="Tutup">
                <i class="bi bi-x"></i>
            </button>
            <button class="lightbox-nav lightbox-prev" onclick="prevCert()" aria-label="Sebelumnya">
                <i class="bi bi-chevron-left"></i>
            </button>
            <button class="lightbox-nav lightbox-next" onclick="nextCert()" aria-label="Berikutnya">
                <i class="bi bi-chevron-right"></i>
            </button>
            <img src="" alt="" class="lightbox-img" id="lightboxImg">
            <div class="lightbox-caption">
                <h6 id="lightboxTitle"></h6>
                <p id="lightboxDesc"></p>
            </div>
        </div>
    </div>

    <section id="contact" class="contact-section text-center">
        <div class="container" style="position:relative;z-index:1">

            <p class="contact-tag reveal" style="justify-content:center;display:flex">Hubungi Saya</p>
            <h2 class="contact-title reveal">Mari Berkolaborasi</h2>
            <p class="contact-sub reveal">Terbuka untuk peluang, diskusi, atau sekadar menyapa.</p>

            <div class="social-grid reveal">
                <a href="https://wa.me/6285255509272" class="social-item" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp"></i><span>WhatsApp</span>
                </a>
                <a href="mailto:riniwulandari1205@email.com" class="social-item">
                    <i class="bi bi-envelope-fill"></i><span>Email</span>
                </a>
                <a href="https://github.com/RiniWu" target="_blank" rel="noopener" class="social-item">
                    <i class="bi bi-github"></i><span>GitHub</span>
                </a>
                <a href="https://www.instagram.com/riniwulan_dari_?igsh=MTNtOXNhbTVkbHc5MA==" target="_blank" rel="noopener" class="social-item">
                    <i class="bi bi-instagram"></i><span>Instagram</span>
                </a>
            </div>

        </div>
    </section>

    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">
                © <?= date('Y') ?> <?= htmlspecialchars($profile['name'] ?? '') ?> · Mahasiswa S1 Sistem Informasi Universitas Mulawarman
            </p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        /* ── Sertifikat data dari PHP ── */
        const certs = <?= json_encode(array_map(fn($c) => [
                            'image'       => htmlspecialchars($c['image'], ENT_QUOTES),
                            'title'       => htmlspecialchars($c['title'], ENT_QUOTES),
                            'description' => htmlspecialchars($c['description'], ENT_QUOTES),
                        ], $certRows), JSON_UNESCAPED_UNICODE) ?>;

        let currentCert = 0;

        /* ── Lightbox ── */
        function openLightbox(i) {
            currentCert = i;
            updateLightbox();
            document.getElementById('lightbox').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            document.getElementById('lightbox').classList.remove('active');
            document.body.style.overflow = '';
        }

        function updateLightbox() {
            const c = certs[currentCert];
            const img = document.getElementById('lightboxImg');
            img.style.opacity = '0';
            img.src = c.image;
            img.alt = c.title;
            img.onload = () => {
                img.style.transition = 'opacity .3s';
                img.style.opacity = '1';
            };
            document.getElementById('lightboxTitle').textContent = c.title;
            document.getElementById('lightboxDesc').textContent = c.description;
        }

        function prevCert() {
            currentCert = (currentCert - 1 + certs.length) % certs.length;
            updateLightbox();
        }

        function nextCert() {
            currentCert = (currentCert + 1) % certs.length;
            updateLightbox();
        }

        /* Close on overlay click */
        document.getElementById('lightbox').addEventListener('click', function(e) {
            if (e.target === this) closeLightbox();
        });

        /* Keyboard navigation */
        document.addEventListener('keydown', e => {
            const lb = document.getElementById('lightbox');
            if (!lb.classList.contains('active')) return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowLeft') prevCert();
            if (e.key === 'ArrowRight') nextCert();
        });

        /* ── Navbar scroll shadow ── */
        const navbar = document.querySelector('.glass-navbar');
        window.addEventListener('scroll', () => {
            navbar.classList.toggle('scrolled', window.scrollY > 30);
        });

        /* ── Scroll reveal ── */
        const revealObs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('visible');
                    revealObs.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.12
        });
        document.querySelectorAll('.reveal').forEach(el => revealObs.observe(el));

        /* ── Skill bar animate-on-scroll ── */
        const skillObs = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.querySelectorAll('.skill-bar').forEach(bar => {
                        bar.style.width = bar.getAttribute('data-width') + '%';
                    });
                    skillObs.unobserve(e.target);
                }
            });
        }, {
            threshold: 0.2
        });
        document.querySelectorAll('#skills-card').forEach(el => skillObs.observe(el));
    </script>

</body>

</html>