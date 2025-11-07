<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Peminjaman Baru</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= base_url('admin/loans/new/books/search?member-uid=' . esc($member['uid'])); ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <?= session()->getFlashdata('msg'); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
<?php endif; ?>

<?php if (isset($validation) && $validation->getErrors()) : ?>
  <div class="alert alert-warning">
    <?= $validation->listErrors(); ?>
  </div>
<?php endif; ?>

<form action="<?= base_url('admin/loans/new'); ?>" method="post">
  <?= csrf_field(); ?>
  <input type="hidden" name="member_uid" value="<?= esc($member['uid']); ?>">

  <!-- Data Anggota -->
  <div class="card mb-4">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-3">Data Anggota</h5>
      <div class="row">
        <div class="col-md-6 mb-3">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" value="<?= esc($member['first_name']); ?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Nomor Telepon</label>
          <input type="text" class="form-control" value="<?= esc($member['phone'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Alamat</label>
          <input type="text" class="form-control" value="<?= esc($member['address'] ?? ''); ?>" readonly>
        </div>
        <div class="col-md-6 mb-3">
          <label class="form-label">Kelas & Jurusan</label>
          <input type="text" class="form-control" value="<?= esc(($member['kelas'] ?? '') . ' - ' . ($member['jurusan'] ?? '')); ?>" readonly>
        </div>
      </div>
    </div>
  </div>

  <!-- Form Peminjaman -->
  <div class="card">
    <div class="card-body">
      <h5 class="card-title fw-semibold mb-4">Form Peminjaman Buku</h5>
      <div class="row">
        <?php foreach ($books as $book) : ?>
          <input type="hidden" name="slugs[]" value="<?= esc($book['slug']); ?>">
          <div class="col-12 mb-4">
            <div class="card border border-primary position-relative">
              <div class="card-body">
                <div class="position-absolute top-50 start-0 translate-middle-y border border-black me-4"
                     style="background-image: url('<?= base_url(BOOK_COVER_URI . $book['book_cover']); ?>'); height: 160px; width: 120px; background-size: cover; background-position: center;">
                </div>
                <div class="row" style="margin-left: 130px;">
                  <div class="col-md-5">
                    <p><b><?= esc($book['title']) . ' (' . esc($book['year']) . ')'; ?></b></p>
                    <p>Pengarang: <?= esc($book['author']); ?></p>
                    <p>Penerbit: <?= esc($book['publisher']); ?></p>
                  </div>
                  <div class="col-md-2">
                    <label class="form-label">Jumlah</label>
                    <input type="number"
                           class="form-control <?= $validation->hasError('quantity[' . $book['slug'] . ']') ? 'is-invalid' : ''; ?>"
                           name="quantity[<?= $book['slug']; ?>]"
                           value="<?= esc($oldInput['quantity'][$book['slug']] ?? 1); ?>"
                           min="1"
                           max="<?= $book['stock'] < 10 ? $book['stock'] : 10; ?>"
                           required>
                    <div class="invalid-feedback">
                      <?= $validation->getError('quantity[' . $book['slug'] . ']'); ?>
                    </div>
                    <small class="form-text">Stok tersedia: <?= esc($book['stock']); ?></small>
                  </div>
                  <div class="col-md-5">
                    <label class="form-label">Lama Meminjam</label>
                    <div class="<?= $validation->hasError('duration[' . $book['slug'] . ']') ? 'is-invalid' : ''; ?>">
                      <?php foreach ([1, 2, 3] as $day) : ?>
                        <div class="form-check form-check-inline">
                          <input type="radio"
                                 class="form-check-input"
                                 name="duration[<?= $book['slug']; ?>]"
                                 id="duration-<?= $book['slug'] . '-' . $day; ?>"
                                 value="<?= $day; ?>"
                                 <?= (isset($oldInput['duration'][$book['slug']]) ? (($oldInput['duration'][$book['slug']] == $day) ? 'checked' : '') : (($day == 1) ? 'checked' : '')); ?>
                                 required>
                          <label class="form-check-label" for="duration-<?= $book['slug'] . '-' . $day; ?>">
                            <?= $day; ?> hari
                          </label>
                        </div>
                      <?php endforeach; ?>
                    </div>
                    <div class="invalid-feedback">
                      <?= $validation->getError('duration[' . $book['slug'] . ']'); ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
  </div>
</form>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Tambahkan interaksi JS di sini jika diperlukan
</script>
<?= $this->endSection() ?>
