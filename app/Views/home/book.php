<?= $this->extend('layouts/home_layout') ?>

<?= $this->section('head') ?>
<title>Buku</title>
<link rel="stylesheet" href="<?= base_url('assets/css/book.css'); ?>">
<?= $this->endSection() ?>

<?= $this->section('back'); ?>
<a href="<?= base_url(); ?>" class="btn btn-outline-primary m-3 position-absolute">
  <i class="ti ti-home"></i> Home
</a>
<?= $this->endSection(); ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm">
  <div class="card-body">
    
    <!-- Header & Search -->
    <div class="row mb-4 align-items-center">
      <div class="col-md-6">
        <h4 class="fw-bold mb-0">📚 Daftar Buku</h4>
        <p class="text-muted">Temukan koleksi buku yang tersedia di perpustakaan.</p>
      </div>
      <div class="col-md-6">
        <form action="" method="get" class="d-flex justify-content-md-end">
          <div class="input-group">
            <input type="text" class="form-control" name="search" value="<?= $search ?? ''; ?>" placeholder="Cari judul atau pengarang...">
            <button class="btn btn-primary" type="submit">
              <i class="bi bi-search"></i>
            </button>
          </div>
        </form>
      </div>
    </div>

    <!-- Book Grid -->
    <div class="row g-4">
      <?php if (empty($books)) : ?>
        <div class="col-12 text-center">
          <h5 class="text-muted">Buku tidak ditemukan.</h5>
        </div>
      <?php endif; ?>

      <?php foreach ($books as $book) : ?>
        <?php
          $coverImageFilePath = BOOK_COVER_URI . $book['book_cover'];
          $coverUrl = base_url((!empty($book['book_cover']) && file_exists($coverImageFilePath)) ? $coverImageFilePath : BOOK_COVER_URI . DEFAULT_BOOK_COVER);
        ?>
        <div class="col-6 col-md-4 col-lg-3">
          <a href="<?= base_url("admin/books/{$book['slug']}"); ?>" class="text-decoration-none">
            <div class="card border-0 shadow-sm book-card-small">
              <img src="<?= $coverUrl; ?>" alt="<?= $book['title']; ?>" class="card-img-top img-fluid" style="height: 180px; object-fit: cover;">
              <div class="card-body p-2">
                <h6 class="fw-semibold text-dark mb-1" style="font-size: 0.95rem;">
                  <?= substr($book['title'], 0, 48) . ((strlen($book['title']) > 48) ? '...'  : '') ?>
                </h6>
                <small class="text-muted">Tahun: <?= $book['year']; ?></small>
              </div>
            </div>
          </a>
        </div>
      <?php endforeach; ?>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
      <?= $pager->links('books', 'my_pager'); ?>
    </div>

  </div>
</div>
<?= $this->endSection() ?>
