<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Peminjaman Baru</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= base_url('admin/loans'); ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i> Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold mb-4">Cari Anggota</h5>
    <div class="mb-3">
      <label for="search" class="form-label">Masukkan Nama atau Nomor Anggota</label>
      <input type="text" class="form-control" id="search" placeholder="Contoh: Ikhsan atau AGT20240123">
    </div>
    <button class="btn btn-primary" id="btnSearch">Cari</button>

    <div id="memberResult" class="mt-4 border rounded p-3 bg-light">
      <p class="text-center text-muted m-0">Data anggota akan muncul di sini setelah pencarian</p>
    </div>
  </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
  $(document).ready(function() {
    $('#btnSearch').on('click', function() {
      let keyword = $('#search').val().trim();

      if (keyword === '') {
        $('#memberResult').html("<p class='text-danger text-center'>⚠ Masukkan nama atau nomor anggota terlebih dahulu</p>");
        return;
      }

      $.ajax({
        url: "<?= site_url('admin/loans/new/members/search'); ?>",
        type: 'GET',
        data: { keyword: keyword },
        beforeSend: function() {
          $('#memberResult').html("<p class='text-primary text-center'>🔎 Sedang mencari data...</p>");
        },
        success: function(response) {
          $('#memberResult').html(response);
          $('html, body').animate({
            scrollTop: $("#memberResult").offset().top
          }, 500);
        },
        error: function(xhr) {
  console.error("Error:", xhr.status, xhr.responseText);
  $('#memberResult').html("<p class='text-danger text-center'>❌ Terjadi kesalahan: " + xhr.status + "</p>");
}

      });
    });

    $('#search').keypress(function(e) {
      if (e.which == 13) {
        $('#btnSearch').click();
      }
    });
  });
  
</script>
<?= $this->endSection() ?>
