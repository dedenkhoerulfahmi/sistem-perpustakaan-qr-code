<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
    <title>Dashboard Perpustakaan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/home.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- 🟦 Hero Section -->
<div class="container-fluid hero-section py-5 bg-light">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7" data-aos="fade-right">
                <h1 class="display-5 fw-bold mb-3">
                    Selamat Datang di <span class="text-primary">Perpustakaan Digital<br>SMK AS-SHOFA</span>
                </h1>
                <p class="lead mb-4">
                    Sistem informasi ini memudahkan pengelolaan koleksi buku dan pencarian bahan bacaan oleh siswa dan guru.
                </p>
                <div class="d-flex flex-wrap gap-2">
                    <a href="<?= base_url('login'); ?>" class="btn btn-warning btn-lg">
                        <i class="bi bi-person-lock"></i> Login Petugas
                    </a>
                    <a href="<?= base_url('book'); ?>" class="btn btn-outline-primary btn-lg">
                        <i class="bi bi-book-half"></i> Daftar Buku
                    </a>
                </div>
            </div>
            <div class="col-md-5 text-center mt-4 mt-md-0" data-aos="fade-left">
                <img src="<?= base_url('assets/images/digilib-smai.png'); ?>" class="img-fluid rounded shadow" alt="Perpustakaan Digital">
            </div>
        </div>
    </div>
</div>

<!-- 🎨 Styles -->
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
    }
</style>

<!-- ⚙️ Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init();

    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            let count = 0;
            const increment = Math.ceil(target / 100);
            const updateCount = () => {
                count += increment;
                if (count < target) {
                    counter.innerText = count;
                    requestAnimationFrame(updateCount);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>

<?= $this->endSection() ?>
