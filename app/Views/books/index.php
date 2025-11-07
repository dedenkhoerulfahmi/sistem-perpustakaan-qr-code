<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Daftar Buku</title>
<style>
  .table-hover tbody tr:hover {
    background-color: #f1f5f9;
  }

  .book-cover {
    width: 70px;
    height: 95px;
    object-fit: cover;
    border-radius: 4px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
  }

  .text-quantity { 
    font-weight: bold; 
  }

  /* Tambahin padding antar cell */
  .table td, .table th {
    padding: 12px 10px;
    vertical-align: middle;
    text-align: center;
  }

  /* Judul & Pengarang lebih rapih */
  .table td p {
    margin-bottom: 4px;
  }

  /* Atur lebar kolom */
  .table th:nth-child(1), .table td:nth-child(1) { width: 40px; }   /* No */
  .table th:nth-child(2), .table td:nth-child(2) { width: 90px; }   /* Sampul */
  .table th:nth-child(3), .table td:nth-child(3) { width: 110px; }  /* Tanggal Masuk */
  .table th:nth-child(4), .table td:nth-child(4) { width: 110px; }  /* Nomor Induk */
  .table th:nth-child(5), .table td:nth-child(5) { min-width: 240px; text-align: left; } /* Judul & Pengarang */
  .table th:nth-child(6), .table td:nth-child(6) { width: 140px; }  /* Kategori */
  .table th:nth-child(7), .table td:nth-child(7) { width: 140px; }  /* Penerbit */
  .table th:nth-child(8), .table td:nth-child(8) { width: 100px; }  /* Tahun Terbit */
  .table th:nth-child(9), .table td:nth-child(9) { width: 120px; }  /* Sumber */
  .table th:nth-child(10), .table td:nth-child(10) { width: 80px; }   /* Jumlah */
  .table th:nth-child(11), .table td:nth-child(11) { width: 120px; } /* Harga */
  .table th:nth-child(12), .table td:nth-child(12) { width: 100px; } /* Kondisi */
  .table th:nth-child(13), .table td:nth-child(13) { width: 120px; } /* Aksi */
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card shadow-sm">
  <div class="card-body">
    <div class="row mb-3 align-items-center">
      <div class="col-md-6">
        <h5 class="card-title fw-bold mb-0">Data Buku</h5>
      </div>
      <div class="col-md-6 text-md-end mt-2 mt-md-0">
        <form class="d-inline-block me-2" action="" method="get">
          <div class="input-group">
            <input type="text" class="form-control" name="search" value="<?= $search ?? ''; ?>" placeholder="Cari buku">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
          </div>
        </form>
        <a href="<?= base_url('admin/books/new'); ?>" class="btn btn-primary">
          <i class="ti ti-plus"></i> Tambah Buku
        </a>
      </div>
    </div>

    <!-- Tombol Export -->
    <div class="mb-3 text-md-end">
      <a href="<?= base_url('admin/books/export-pdf'); ?>" class="btn btn-danger me-2">
        <i class="ti ti-file-type-pdf"></i> Export PDF
      </a>
      <a href="<?= base_url('admin/books/export-excel'); ?>" class="btn btn-success">
        <i class="ti ti-file-spreadsheet"></i> Export Excel
      </a>
    </div>

    <div class="table-responsive">
      <table class="table table-hover table-striped table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Sampul</th>
            <th>Tanggal Masuk</th>
            <th>Nomor Induk</th>
            <th>Judul & Pengarang</th>
            <th>Kategori</th>
            <th>Penerbit</th>
            <th>Tahun Terbit</th>
            <th>Sumber</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Kondisi</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php $i = 1 + ($itemPerPage * ($currentPage - 1)) ?>
          <?php if (empty($books)) : ?>
            <tr>
              <td colspan="13" class="text-center fw-bold">Tidak ada data</td>
            </tr>
          <?php endif; ?>
          <?php foreach ($books as $book) : ?>
            <tr>
              <th><?= $i++; ?></th>

              <!-- Sampul -->
              <td>
                <a href="<?= base_url("admin/books/{$book['slug']}"); ?>">
                  <?php $coverImageFilePath = BOOK_COVER_URI . $book['book_cover']; ?>
                  <img src="<?= base_url((!empty($book['book_cover']) && file_exists($coverImageFilePath)) ? $coverImageFilePath : BOOK_COVER_URI . DEFAULT_BOOK_COVER); ?>" alt="<?= $book['title']; ?>" class="book-cover">
                </a>
              </td>

              <!-- Tanggal Masuk -->
              <td><?= !empty($book['tanggal_masuk']) ? date('d-m-Y', strtotime($book['tanggal_masuk'])) : '-'; ?></td>

              <!-- Nomor Induk -->
              <td><?= $book['nomor_induk']; ?></td>

              <!-- Judul & Pengarang -->
              <td class="text-start">
                <a href="<?= base_url("admin/books/{$book['slug']}"); ?>" class="text-decoration-none">
                  <p class="mb-1 fw-bold text-primary"><?= $book['title']; ?></p>
                  <p class="mb-0 text-secondary">Pengarang: <?= $book['author']; ?></p>
                </a>
              </td>

              <!-- Kategori -->
              <td><?= esc($book['kategori'] ?? '-'); ?></td>

              <!-- Penerbit -->
              <td><?= $book['publisher']; ?></td>

              <!-- Tahun Terbit -->
              <td><?= $book['year']; ?></td>

              <!-- Sumber -->
              <td><?= $book['sumber']; ?></td>

              <!-- Jumlah -->
              <td class="text-quantity"><?= $book['quantity']; ?></td>

              <!-- Harga -->
              <td>Rp <?= number_format($book['harga'], 0, ',', '.'); ?></td>

              <!-- Kondisi -->
              <td><?= $book['kondisi']; ?></td>

              <!-- Aksi -->
              <td>
                <a href="<?= base_url("admin/books/{$book['slug']}/edit"); ?>" class="btn btn-sm btn-primary mb-1 w-100">
                  <i class="ti ti-edit"></i> Edit
                </a>
                <form action="<?= base_url("admin/books/{$book['slug']}"); ?>" method="post" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-sm btn-danger w-100">
                    <i class="ti ti-trash"></i> Delete
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>

    <?= $pager->links('books', 'my_pager'); ?>
  </div>
</div>
<?= $this->endSection() ?>
