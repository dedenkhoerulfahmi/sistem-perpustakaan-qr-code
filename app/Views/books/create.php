<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Tambah Buku</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= base_url('admin/books'); ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg') ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (isset($validation)): ?>
  <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Tambah Buku</h5>
    <form action="<?= base_url('admin/books'); ?>" method="post" enctype="multipart/form-data">
      <?= csrf_field(); ?>

      <!-- Upload Cover -->
      <div class="row">
        <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3 p-3">
          <label for="cover" class="d-block" style="cursor: pointer;">
            <div class="d-flex justify-content-center bg-light overflow-hidden h-100 position-relative">
              <img id="bookCoverPreview" src="<?= base_url(BOOK_COVER_URI . DEFAULT_BOOK_COVER); ?>" alt="cover" height="300" class="z-1">
              <p class="position-absolute top-50 start-50 translate-middle z-0">Pilih sampul</p>
            </div>
          </label>
        </div>
        <div class="col-12 col-md-6 col-lg-8 col-xl-9">
          <div class="mb-3">
            <label for="cover" class="form-label">Gambar Sampul Buku</label>
            <input class="form-control <?= $validation->hasError('cover') ? 'is-invalid' : '' ?>" 
                   type="file" id="cover" name="cover" onchange="previewImage()">
            <div class="invalid-feedback"><?= $validation->getError('cover'); ?></div>
          </div>
        </div>
      </div>

      <!-- Tanggal Masuk & Nomor Induk -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
          <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" 
                 value="<?= $oldInput['tanggal_masuk'] ?? ''; ?>" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="nomor_induk" class="form-label">Nomor Induk</label>
          <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" 
                 value="<?= $oldInput['nomor_induk'] ?? ''; ?>" required>
        </div>
      </div>

      <!-- Judul & Pengarang -->
      <div class="mb-3">
        <label for="title" class="form-label">Judul Buku</label>
        <input type="text" class="form-control <?= $validation->hasError('title') ? 'is-invalid' : '' ?>" 
               id="title" name="title" value="<?= $oldInput['title'] ?? ''; ?>" required>
        <div class="invalid-feedback"><?= $validation->getError('title'); ?></div>
      </div>

      <div class="mb-3">
        <label for="author" class="form-label">Pengarang</label>
        <input type="text" class="form-control <?= $validation->hasError('author') ? 'is-invalid' : '' ?>" 
               id="author" name="author" value="<?= $oldInput['author'] ?? ''; ?>" required>
        <div class="invalid-feedback"><?= $validation->getError('author'); ?></div>
      </div>

      <!-- Penerbit & Tahun Terbit -->
      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="publisher" class="form-label">Penerbit</label>
          <input type="text" class="form-control <?= $validation->hasError('publisher') ? 'is-invalid' : '' ?>" 
                 id="publisher" name="publisher" value="<?= $oldInput['publisher'] ?? ''; ?>" required>
          <div class="invalid-feedback"><?= $validation->getError('publisher'); ?></div>
        </div>
        <div class="col-md-6 mb-3">
          <label for="year" class="form-label">Tahun Terbit</label>
          <input type="number" class="form-control <?= $validation->hasError('year') ? 'is-invalid' : '' ?>" 
                 id="year" name="year" value="<?= $oldInput['year'] ?? ''; ?>" minlength="4" maxlength="4" required>
          <div class="invalid-feedback"><?= $validation->getError('year'); ?></div>
        </div>
      </div>

      <!-- Sumber, Stok, Harga -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="sumber" class="form-label">Sumber</label>
          <input type="text" class="form-control" id="sumber" name="sumber" 
                 value="<?= $oldInput['sumber'] ?? ''; ?>">
        </div>
        <div class="col-md-4 mb-3">
          <label for="stock" class="form-label">Jumlah Stok Buku</label>
          <input type="number" class="form-control <?= $validation->hasError('stock') ? 'is-invalid' : '' ?>" 
                 id="stock" name="stock" value="<?= $oldInput['stock'] ?? ''; ?>" required>
          <div class="invalid-feedback"><?= $validation->getError('stock'); ?></div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="harga" class="form-label">Harga</label>
          <input type="number" class="form-control" id="harga" name="harga" 
                 value="<?= $oldInput['harga'] ?? ''; ?>">
        </div>
      </div>

      <!-- Kondisi, Kelas (Rak), Kategori -->
      <div class="row">
        <div class="col-md-4 mb-3">
          <label for="kondisi" class="form-label">Kondisi</label>
          <select class="form-select" id="kondisi" name="kondisi">
            <option value="">-- Pilih kondisi --</option>
            <option value="Baik" <?= ($oldInput['kondisi'] ?? '') == 'Baik' ? 'selected' : ''; ?>>Baik</option>
            <option value="Rusak" <?= ($oldInput['kondisi'] ?? '') == 'Rusak' ? 'selected' : ''; ?>>Rusak</option>
          </select>
        </div>
        <div class="col-md-4 mb-3">
          <label for="rack" class="form-label">Kelas</label>
          <select class="form-select <?= $validation->hasError('rack') ? 'is-invalid' : '' ?>" 
                  id="rack" name="rack" required>
            <option value="">-- Pilih kelas --</option>
            <?php foreach ($racks as $rack): ?>
              <option value="<?= $rack['id']; ?>" <?= ($oldInput['rack'] ?? '') == $rack['id'] ? 'selected' : ''; ?>>
                <?= $rack['name']; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= $validation->getError('rack'); ?></div>
        </div>
        <div class="col-md-4 mb-3">
          <label for="category" class="form-label">Kategori</label>
          <select class="form-select <?= $validation->hasError('category') ? 'is-invalid' : '' ?>" 
                  id="category" name="category" required>
            <option value="">-- Pilih kategori --</option>
            <?php foreach ($categories as $category): ?>
              <option value="<?= $category['id']; ?>" <?= ($oldInput['category'] ?? '') == $category['id'] ? 'selected' : ''; ?>>
                <?= $category['name']; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback"><?= $validation->getError('category'); ?></div>
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  function previewImage() {
    const fileInput = document.querySelector('#cover');
    const imagePreview = document.querySelector('#bookCoverPreview');

    const reader = new FileReader();
    reader.readAsDataURL(fileInput.files[0]);

    reader.onload = function(e) {
      imagePreview.src = e.target.result;
    };
  }
</script>
<?= $this->endSection() ?>
