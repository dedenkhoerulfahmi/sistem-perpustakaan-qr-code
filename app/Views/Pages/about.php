<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Tentang Sistem</title>
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
    background-color: #f8fafc;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 0 10px rgba(0,0,0,0.05);
    margin-bottom: 2rem;
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

  /* === Feature Boxes === */
  .feature-box {
    background-color: #fff;
    border: 1px solid #dbeafe;
    border-radius: 8px;
    padding: 1rem;
    text-align: center;
    transition: transform 0.3s ease;
  }

  .feature-box:hover {
    transform: translateY(-5px);
  }

  .feature-box i {
    font-size: 2rem;
    color: #0d6efd;
    margin-bottom: 0.5rem;
  }

  .cta-button {
    margin-top: 2rem;
  }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<!-- Hero Header (di luar container agar full) -->
<div class="hero-header scroll-reveal">
  <div class="hero-content">
    <h1 class="display-5">Tentang Sistem Informasi Perpustakaan</h1>
    <p class="lead">Sistem ini dirancang untuk mendukung pengelolaan perpustakaan secara digital dan efisien.</p>
  </div>
</div>

<!-- Konten utama -->
<div class="container py-5">
  <!-- Deskripsi Sistem -->
  <div class="section-bg scroll-reveal">
    <div class="section-title">
      <h3>Tujuan Pengembangan</h3>
      <div class="divider"></div>
    </div>
    <p>Sistem Informasi Perpustakaan SMK AS-SHOFA dikembangkan untuk memudahkan pengelolaan data buku, peminjaman, pengembalian, dan pencarian koleksi oleh siswa dan guru. Dengan sistem ini, proses administrasi perpustakaan menjadi lebih cepat, akurat, dan transparan.</p>
  </div>

  <!-- Fitur Utama -->
  <div class="section-bg scroll-reveal">
    <div class="section-title">
      <h3>Fitur Utama</h3>
      <div class="divider"></div>
    </div>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="feature-box shadow-sm">
          <i class="bi bi-archive-fill"></i>
          <h5 class="fw-semibold">Manajemen Buku</h5>
          <p>Petugas dapat menambah, mengedit, dan menghapus data buku dengan mudah melalui dashboard admin.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box shadow-sm">
          <i class="bi bi-search"></i>
          <h5 class="fw-semibold">Pencarian Koleksi</h5>
          <p>Pengunjung dapat mencari buku berdasarkan judul, kategori, pengarang, atau tahun terbit.</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="feature-box shadow-sm">
          <i class="bi bi-bar-chart-line-fill"></i>
          <h5 class="fw-semibold">Statistik Penggunaan</h5>
          <p>Admin dapat melihat data peminjaman, buku favorit, dan aktivitas pengunjung secara real-time.</p>
        </div>
      </div>
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
