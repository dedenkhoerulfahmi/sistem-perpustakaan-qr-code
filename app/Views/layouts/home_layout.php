<!DOCTYPE html>
<html lang="en">

<head>
  <?= $this->include('layouts/head') ?>

  <!-- Extra head e.g title -->
  <?= $this->renderSection('head') ?>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/home.css'); ?>">

  <style>
    /* Navbar hover effect */
    .navbar-nav .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.2);
      border-radius: 5px;
      transition: all 0.3s ease;
    }

    .navbar-nav .nav-link.active {
      border-bottom: 2px solid #fff;
    }
  </style>
</head>

<body class="position-relative">
  <!-- Navbar -->
<!-- Navbar -->
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
  <div class="container">
    <a class="navbar-brand d-flex align-items-center fw-bold text-white" href="<?= base_url(); ?>">
      <img src="<?= base_url('assets/images/logo-smk.png'); ?>" alt="Logo" width="32" height="32" class="me-2">
      SMK AS-SHOFA
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav gap-2">
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold <?= uri_string() === '' ? 'active' : '' ?>"
             href="<?= base_url(); ?>">
            <i class="bi bi-house-door-fill me-1"></i> Beranda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold <?= uri_string() === 'profil' ? 'active' : '' ?>"
             href="<?= base_url('profil'); ?>">
            <i class="bi bi-journal-text me-1"></i> Profil Perpustakaan
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white fw-semibold <?= uri_string() === 'about' ? 'active' : '' ?>"
             href="<?= base_url('about'); ?>">
            <i class="bi bi-info-circle-fill me-1"></i> About
          </a>
        </li>
      </ul>
    </div>
  </div>
</nav>



  <!-- Background -->
  <div class="background"></div>

  <!-- Page Wrapper -->
<div class="page-wrapper" id="main-wrapper">
  <div class="body-wrapper position-relative">
    <?= $this->renderSection('back') ?>
    <div class="w-100">
      <?= $this->renderSection('content') ?>
    </div>


        <!-- Footer -->
        <div class="align-self-end w-100">
          <?= $this->include('layouts/footer') ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Basic Scripts -->
  <?= $this->include('imports/scripts/basic_scripts') ?>

  <!-- Extra scripts -->
  <?= $this->renderSection('scripts') ?>
</body>

</html>
