<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Profil Perpustakaan</title>
<style>
  /* === Hero Section === */
  .hero-header {
    background-image: url('<?= base_url('assets/images/bg perpus.jpg'); ?>');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 85vh;
    width: 100vw;
    margin: 0;
    padding: 0;
    position: relative;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
  }

  .hero-header::before {
    content: "";
    position: absolute;
    inset: 0;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 1;
  }

  .hero-header .hero-content {
    position: relative;
    z-index: 2;
    padding: 0 20px;
    color: white;
  }

  .hero-header h1 {
    font-size: 3rem;
    font-weight: bold;
    margin-bottom: 1rem;
  }

  .hero-header p {
    font-size: 1.25rem;
  }

  @media (max-width: 768px) {
    .hero-header {
      height: 70vh;
    }

    .hero-header h1 {
      font-size: 2rem;
    }

    .hero-header p {
      font-size: 1rem;
    }
  }

  /* === Scroll Reveal === */
  .scroll-reveal {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease-out;
  }

  .scroll-reveal.show {
    opacity: 1;
    transform: translateY(0);
  }

  /* === Section Styling === */
  .section-bg {
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
  }

  .section-bg:nth-child(odd) {
    background-color: #f8fafc;
  }

  .section-bg:nth-child(even) {
    background-color: #ffffff;
  }

  .section-title {
    text-align: center;
    margin-bottom: 1.5rem;
  }

  .section-title h3 {
    font-weight: bold;
    color: #0d6efd;
  }

  .section-title .divider {
    width: 60px;
    height: 4px;
    background-color: #0d6efd;
    margin: 0.5rem auto;
    border-radius: 2px;
  }

  /* === Struktur Organisasi === */
  .card-img-top {
    border: 4px solid #0d6efd;
  }

  .cta-button {
    margin-top: 2rem;
  }

  @media (max-width: 768px) {
    .section-bg {
      padding: 1.5rem;
    }
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Header -->
<div class="hero-header scroll-reveal">
  <div class="hero-content">
    <h1 class="display-5">Profil Perpustakaan SMK AS-SHOFA</h1>
    <p class="lead">Informasi lengkap mengenai sejarah, visi misi, struktur, dan fasilitas perpustakaan.</p>
  </div>
</div>

<!-- Konten utama -->
<div class="container py-5">
<!-- Sejarah -->
<div class="section-bg scroll-reveal">
  <div class="section-title">
    <h3>Sejarah Perpustakaan</h3>
    <div class="divider"></div>
  </div>
  <div class="row align-items-center">
    <div class="col-md-6 mb-4 mb-md-0">
      <img src="<?= base_url('assets/images/logo-smk.png'); ?>" alt="Sejarah Perpustakaan" class="img-fluid rounded shadow-sm">
    </div>
    <div class="col-md-6">
      <p>Perpustakaan SMK AS-SHOFA didirikan pada tahun <strong>2010</strong> sebagai bagian dari upaya sekolah untuk meningkatkan budaya literasi di kalangan siswa dan guru. Awalnya hanya berupa ruang baca sederhana, kini telah berkembang menjadi pusat informasi digital yang mendukung pembelajaran modern.</p>
      <p>Transformasi ini mencakup digitalisasi katalog, sistem peminjaman berbasis web, dan integrasi teknologi informasi untuk memudahkan akses dan pengelolaan koleksi. Perpustakaan menjadi ruang yang inklusif, nyaman, dan inspiratif bagi seluruh warga sekolah.</p>
    </div>
  </div>
</div>


 <!-- Visi & Misi -->
<div class="section-bg scroll-reveal">
  <div class="section-title">
    <h3>Visi & Misi</h3>
    <div class="divider"></div>
  </div>
  <div class="row g-4">
    <!-- Visi -->
    <div class="col-md-4">
      <div class="p-4 border rounded bg-white shadow-sm text-center h-100">
        <i class="bi bi-eye-fill text-primary fs-2 mb-2"></i>
        <h5 class="fw-semibold">Visi</h5>
        <p class="text-muted">Menjadi pusat informasi dan literasi yang unggul dalam mendukung pendidikan karakter dan kompetensi siswa.</p>
      </div>
    </div>

    <!-- Misi -->
    <div class="col-md-8">
      <div class="p-4 border rounded bg-white shadow-sm h-100">
        <i class="bi bi-list-check text-primary fs-2 mb-2 d-block text-center"></i>
        <h5 class="fw-semibold text-center">Misi</h5>
        <ul class="mt-3">
          <li><i class="bi bi-check-circle-fill text-success me-2"></i> Menyediakan koleksi bahan pustaka yang relevan dan berkualitas.</li>
          <li><i class="bi bi-check-circle-fill text-success me-2"></i> Mendorong minat baca dan keterampilan literasi digital.</li>
          <li><i class="bi bi-check-circle-fill text-success me-2"></i> Mendukung proses pembelajaran dengan layanan informasi yang cepat dan akurat.</li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- 🧑‍💼 Struktur Organisasi -->
<div class="container my-5 py-4">
  <div class="text-center mb-5" data-aos="fade-up">
    <h3 class="fw-bold text-primary display-6">Struktur Organisasi</h3>
    <div class="divider mx-auto" style="width: 100px; height: 5px; background-color: #0d6efd; border-radius: 3px;"></div>
    <p class="text-muted mt-3 fs-5">Tim profesional yang mengelola dan mengembangkan layanan Perpustakaan SMK AS-SHOFA</p>
  </div>

  <div class="row g-4 justify-content-center">
    <?php
      $staff = [
        ['name' => 'Ibu Siti Nurhaliza', 'role' => 'Kepala Perpustakaan', 'img' => 'foto saya.png'],
        ['name' => 'Bapak Ahmad Fauzi', 'role' => 'Petugas Administrasi', 'img' => 'ahmad.jpg'],
        ['name' => 'Ibu Rina Kartika', 'role' => 'Petugas Koleksi', 'img' => 'rina.jpg'],
        ['name' => 'Bapak Dedi Saputra', 'role' => 'Petugas Teknologi Informasi', 'img' => 'dedi.jpg'],
      ];
      foreach ($staff as $index => $person):
    ?>
    <div class="col-lg-3 col-md-4 col-sm-6" data-aos="zoom-in" data-aos-delay="<?= $index * 100 ?>">
      <div class="staff-card text-center p-4 rounded-4 shadow-lg bg-light h-100">
        <div class="position-relative d-inline-block mb-3">
          <img src="<?= base_url('assets/images/staff/' . $person['img']); ?>"
               class="rounded-circle border border-4 border-primary shadow-lg"
               style="width: 160px; height: 160px; object-fit: cover;" 
               alt="<?= $person['role']; ?>">
          <div class="halo"></div>
        </div>
        <h5 class="fw-bold mb-1"><?= $person['name']; ?></h5>
        <p class="text-muted mb-2"><?= $person['role']; ?></p>
        <div class="social-links">
          <a href="#" class="text-primary me-2"><i class="bi bi-facebook"></i></a>
          <a href="#" class="text-info me-2"><i class="bi bi-twitter"></i></a>
          <a href="#" class="text-danger"><i class="bi bi-instagram"></i></a>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- 🌟 Style tambahan -->
<style>
  .staff-card {
    transition: all 0.4s ease;
    position: relative;
    overflow: hidden;
  }

  .staff-card:hover {
    transform: translateY(-10px);
    background: linear-gradient(180deg, #ffffff 0%, #f8f9fa 100%);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
  }

  .staff-card img {
    transition: transform 0.3s ease;
  }

  .staff-card:hover img {
    transform: scale(1.08);
  }

  .staff-card .halo {
    position: absolute;
    top: -8px;
    left: -8px;
    right: -8px;
    bottom: -8px;
    border-radius: 50%;
    box-shadow: 0 0 20px rgba(13, 110, 253, 0.4);
    opacity: 0;
    transition: opacity 0.4s ease;
  }

  .staff-card:hover .halo {
    opacity: 1;
  }

  .social-links a {
    font-size: 1.25rem;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .social-links a:hover {
    transform: scale(1.2);
    color: #0d6efd !important;
  }

  @media (max-width: 768px) {
    .staff-card img {
      width: 130px;
      height: 130px;
    }
  }
</style>


<!-- 🏫 Sarana & Prasarana -->
<div class="container my-5">
  <div class="text-center mb-4" data-aos="fade-up">
    <h3 class="fw-bold text-primary">Sarana & Prasarana</h3>
    <div class="divider mx-auto" style="width: 80px; height: 4px; background-color: #0d6efd; border-radius: 2px;"></div>
    <p class="text-muted mt-2">Fasilitas lengkap untuk mendukung kenyamanan belajar dan membaca di perpustakaan.</p>
  </div>

  <div class="row g-4">
    <div class="col-md-6 col-lg-3" data-aos="zoom-in">
      <div class="facility-card text-center p-4 border-0 rounded-4 shadow-sm bg-light h-100">
        <div class="icon mb-3 text-primary fs-1">
          <i class="bi bi-person-workspace"></i>
        </div>
        <h6 class="fw-semibold">Ruang Baca Nyaman</h6>
        <p class="text-muted small mb-0">Kapasitas hingga 50 orang dengan suasana tenang dan sejuk.</p>
      </div>
    </div>

    <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="100">
      <div class="facility-card text-center p-4 border-0 rounded-4 shadow-sm bg-light h-100">
        <div class="icon mb-3 text-success fs-1">
          <i class="bi bi-book"></i>
        </div>
        <h6 class="fw-semibold">Koleksi Buku Lengkap</h6>
        <p class="text-muted small mb-0">Lebih dari 3.000 buku tersedia dari berbagai kategori bacaan.</p>
      </div>
    </div>

    <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="200">
      <div class="facility-card text-center p-4 border-0 rounded-4 shadow-sm bg-light h-100">
        <div class="icon mb-3 text-warning fs-1">
          <i class="bi bi-pc-display-horizontal"></i>
        </div>
        <h6 class="fw-semibold">Katalog Digital</h6>
        <p class="text-muted small mb-0">Komputer katalog digital mempermudah pencarian koleksi.</p>
      </div>
    </div>

    <div class="col-md-6 col-lg-3" data-aos="zoom-in" data-aos-delay="300">
      <div class="facility-card text-center p-4 border-0 rounded-4 shadow-sm bg-light h-100">
        <div class="icon mb-3 text-info fs-1">
          <i class="bi bi-wifi"></i>
        </div>
        <h6 class="fw-semibold">Akses Wi-Fi Gratis</h6>
        <p class="text-muted small mb-0">Nikmati koneksi internet cepat selama berada di perpustakaan.</p>
      </div>
    </div>
  </div>
</div>

<!-- ✨ Style tambahan -->
<style>
  .facility-card {
    transition: all 0.3s ease;
  }
  .facility-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    background-color: #f8f9fa;
  }
  .facility-card .icon i {
    transition: transform 0.3s ease, color 0.3s ease;
  }
  .facility-card:hover .icon i {
    transform: scale(1.2);
  }
</style>


  <!-- CTA -->
  <div class="text-center cta-button scroll-reveal">
    <a href="<?= base_url('book'); ?>" class="btn btn-primary btn-lg">
      <i class="bi bi-search"></i> Jelajahi Koleksi Buku
    </a>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  // Scroll reveal animation
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      }
    });
  }, {
    threshold: 0.1
  });

  document.querySelectorAll('.scroll-reveal').forEach(el => observer.observe(el));
</script>
<?= $this->endSection() ?>
