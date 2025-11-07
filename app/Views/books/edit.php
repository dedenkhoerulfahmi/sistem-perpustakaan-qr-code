<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
  <title>Edit Buku</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

  <!-- Flash Message -->
  <?php if (session()->getFlashdata('msg')) : ?>
    <div class="alert <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success'; ?>">
      <?= session()->getFlashdata('msg'); ?>
    </div>
  <?php endif; ?>

  <!-- Validasi Error -->
  <?php if (isset($validation)) : ?>
    <div class="alert alert-danger"><?= $validation->listErrors(); ?></div>
  <?php endif; ?>

  <a href="<?= base_url('admin/books'); ?>" class="btn btn-outline-primary mb-3">
    <i class="ti ti-arrow-left"></i> Kembali
  </a>

  <div class="card">
    <div class="card-header">
      <h5 class="mb-0">Edit Buku</h5>
    </div>
    <div class="card-body">
      <form action="<?= base_url('admin/books/' . $book['id']); ?>" method="post" enctype="multipart/form-data">
        <?= csrf_field(); ?>
        <input type="hidden" name="_method" value="PUT">

        <!-- Sampul Buku -->
        <div class="mb-3">
          <label for="cover" class="form-label">Sampul Buku</label>
          <input type="file" class="form-control" id="cover" name="cover" accept="image/*">
        </div>

        <!-- Tanggal Masuk -->
        <div class="mb-3">
          <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
          <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk"
            value="<?= esc($book['tanggal_masuk']); ?>" required>
        </div>

        <!-- Nomor Induk -->
        <div class="mb-3">
          <label for="nomor_induk" class="form-label">Nomor Induk</label>
          <input type="text" class="form-control" id="nomor_induk" name="nomor_induk"
            value="<?= esc($book['nomor_induk']); ?>" required>
        </div>

        <!-- Judul -->
        <div class="mb-3">
          <label for="title" class="form-label">Judul</label>
          <input type="text" class="form-control" id="title" name="title"
            value="<?= esc($book['title']); ?>" required>
        </div>

        <!-- Pengarang -->
        <div class="mb-3">
          <label for="author" class="form-label">Pengarang</label>
          <input type="text" class="form-control" id="author" name="author"
            value="<?= esc($book['author']); ?>">
        </div>

        <!-- Penerbit -->
        <div class="mb-3">
          <label for="publisher" class="form-label">Penerbit</label>
          <input type="text" class="form-control" id="publisher" name="publisher"
            value="<?= esc($book['publisher']); ?>">
        </div>

        <!-- Tahun Terbit -->
        <div class="mb-3">
          <label for="year" class="form-label">Tahun Terbit</label>
          <input type="number" class="form-control" id="year" name="year"
            value="<?= esc($book['year']); ?>">
        </div>

        <!-- Sumber -->
        <div class="mb-3">
          <label for="sumber" class="form-label">Sumber</label>
          <input type="text" class="form-control" id="sumber" name="sumber"
            value="<?= esc($book['sumber']); ?>">
        </div>

        <!-- Jumlah Stok -->
        <div class="mb-3">
          <label for="quantity" class="form-label">Jumlah Stok</label>
          <input type="number" class="form-control" id="quantity" name="quantity"
            value="<?= esc($book['quantity']); ?>" required>
        </div>

        <!-- Harga -->
        <div class="mb-3">
          <label for="harga" class="form-label">Harga</label>
          <input type="number" class="form-control" id="harga" name="harga"
            value="<?= esc($book['harga']); ?>">
        </div>

        <!-- Kondisi -->
        <div class="mb-3">
          <label for="kondisi" class="form-label">Kondisi</label>
          <select class="form-select" id="kondisi" name="kondisi">
            <option value="Baik" <?= $book['kondisi'] === 'Baik' ? 'selected' : ''; ?>>Baik</option>
            <option value="Rusak" <?= $book['kondisi'] === 'Rusak' ? 'selected' : ''; ?>>Rusak</option>
            <option value="Hilang" <?= $book['kondisi'] === 'Hilang' ? 'selected' : ''; ?>>Hilang</option>
          </select>
        </div>

        <!-- Tombol Submit -->
        <button type="submit" class="btn btn-success">Update</button>
      </form>
    </div>
  </div>

<?= $this->endSection() ?>
