<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Detail Anggota</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<style>
  #qr-code {
    background-image: url(<?= base_url(MEMBERS_QR_CODE_URI . $member['qr_code']); ?>);
    background-size: contain;
    background-repeat: no-repeat;
    background-position: center;
    max-width: 500px;
    height: 300px;
  }
</style>

<?php use CodeIgniter\I18n\Time; ?>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert <?= (session()->getFlashdata('error') ?? false) ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="row">
  <div class="col-12 col-lg-7">
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div class="d-flex justify-content-between mb-4">
              <a href="<?= base_url('admin/members'); ?>" class="btn btn-outline-primary">
                <i class="ti ti-arrow-left"></i> Kembali
              </a>
              <div class="d-flex gap-2">
                <a href="<?= base_url("admin/members/{$member['uid']}/edit"); ?>" class="btn btn-primary">
                  <i class="ti ti-edit"></i> Edit
                </a>
                <form action="<?= base_url("admin/members/{$member['uid']}"); ?>" method="post">
                  <?= csrf_field(); ?>
                  <input type="hidden" name="_method" value="DELETE">
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus anggota ini?');">
                    <i class="ti ti-trash"></i> Delete
                  </button>
                </form>
              </div>
            </div>

            <h5 class="card-title fw-semibold mb-4">Detail Anggota</h5>
            <div class="row mb-3">
              <div class="col-12">
                <div class="w-100 mb-4">
                  <?php
                  $tableData = [
                    'No Anggota'    => $member['no_anggota'],
                    'Nomor Induk'   => $member['nomor_induk'],
                    'Nama Lengkap'  => $member['first_name'],
                    'Kelas'         => $member['kelas'],
                    'Jurusan'       => $member['jurusan'],
                    'Nomor Telepon' => $member['phone'],
                    'Alamat'        => $member['address'],
                    'Tanggal Lahir' => $member['date_of_birth'] 
                                        ? Time::parse($member['date_of_birth'], locale: 'id')->toLocalizedString('d MMMM Y') 
                                        : '-',
                    'Jenis Kelamin' => $member['gender'] === 'male' ? 'Laki-laki' : 'Perempuan',
                  ];
                  ?>
                  <table class="table table-borderless">
                    <?php foreach ($tableData as $key => $value) : ?>
                      <tr>
                        <td style="width:180px;"><strong><?= $key; ?></strong></td>
                        <td style="width:15px;" class="text-center">:</td>
                        <td><?= esc($value); ?></td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Statistik -->
      <div class="col-12">
        <div class="row">
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100">
              <div class="card-body">
                <h2><i class="ti ti-book"></i></h2>
                <h5>Buku dipinjam:</h5>
                <h4><?= $totalBooksLent; ?></h4>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100">
              <div class="card-body">
                <h2><i class="ti ti-arrows-exchange"></i></h2>
                <h5>Transaksi peminjaman:</h5>
                <h4><?= $loanCount; ?></h4>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100">
              <div class="card-body">
                <h2><i class="ti ti-check"></i></h2>
                <h5>Transaksi pengembalian:</h5>
                <h4><?= $returnCount; ?></h4>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100">
              <div class="card-body">
                <h2><i class="ti ti-calendar-time"></i></h2>
                <h5>Jumlah terlambat:</h5>
                <h4><?= $lateCount; ?></h4>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100">
              <div class="card-body">
                <h2><i class="ti ti-report-money"></i></h2>
                <h5>Denda belum dibayar:</h5>
                <h4>Rp<?= $unpaidFines; ?></h4>
              </div>
            </div>
          </div>
          <div class="col-12 col-sm-6 col-xl-4">
            <div class="card h-100">
              <div class="card-body">
                <h2><i class="ti ti-cash"></i></h2>
                <h5>Denda dibayar:</h5>
                <h4>Rp<?= $paidFines; ?></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- QR Code -->
  <div class="col-12 col-lg-5">
    <div class="card">
      <div class="card-body">
        <p class="text-center mb-4" style="line-break: anywhere;">UID : <?= $member['uid']; ?></p>
        <div id="qr-code" class="m-auto"></div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
