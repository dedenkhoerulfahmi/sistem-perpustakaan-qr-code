<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Anggota Baru</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<a href="<?= base_url('admin/members'); ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i>
  Kembali
</a>

<?php if (session()->getFlashdata('msg')) : ?>
  <div class="pb-2">
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= session()->getFlashdata('msg') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  </div>
<?php endif; ?>

<div class="card">
  <div class="card-body">
    <h5 class="card-title fw-semibold">Form Anggota Baru</h5>
    <form action="<?= base_url('admin/members'); ?>" method="post">
      <?= csrf_field(); ?>
      
      <div class="row mt-3">
        <div class="col-12 col-md-6 mb-3">
          <label for="member_no" class="form-label">No Anggota</label>
          <input type="text" class="form-control" 
                 id="member_no" name="member_no"
                 value="<?= esc($no_anggota ?? '') ?>" 
                 readonly>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="nomor_induk" class="form-label">Nomor Induk</label>
          <input type="text" 
                 class="form-control <?= $validation->hasError('nomor_induk') ? 'is-invalid' : '' ?>" 
                 id="nomor_induk" name="nomor_induk" 
                 value="<?= $oldInput['nomor_induk'] ?? ''; ?>" 
                 placeholder="10.25.1" required>
          <div class="invalid-feedback">
            <?= $validation->getError('nomor_induk'); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-6 mb-3">
          <label for="first_name" class="form-label">Nama Depan</label>
          <input type="text" 
                 class="form-control <?= $validation->hasError('first_name') ? 'is-invalid' : '' ?>" 
                 id="first_name" name="first_name" 
                 value="<?= $oldInput['first_name'] ?? ''; ?>" 
                 placeholder="John" required>
          <div class="invalid-feedback">
            <?= $validation->getError('first_name'); ?>
          </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="kelas" class="form-label">Kelas</label>
          <input type="text" 
                 class="form-control <?= $validation->hasError('kelas') ? 'is-invalid' : '' ?>" 
                 id="kelas" name="kelas" 
                 value="<?= $oldInput['kelas'] ?? ''; ?>">
          <div class="invalid-feedback">
            <?= $validation->getError('kelas'); ?>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12 col-md-6 mb-3">
          <label for="jurusan" class="form-label">Jurusan</label>
          <select class="form-select <?= $validation->hasError('jurusan') ? 'is-invalid' : '' ?>" 
                  id="jurusan" name="jurusan" required>
            <option value="">--Pilih jurusan--</option>
            <?php 
            $jurusanOptions = [
              "Teknik Komputer dan Jaringan",
              "Farmasi Klinis dan Komunitas",
              "Tata Boga",
              "Asisten Keperawatan",
              "Teknik Bisnis Sepeda Motor",
              "Akuntansi dan Keuangan Lembaga"
            ];
            foreach ($jurusanOptions as $j) : ?>
              <option value="<?= $j; ?>" <?= ($oldInput['jurusan'] ?? '') == $j ? 'selected' : ''; ?>>
                <?= $j; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <div class="invalid-feedback">
            <?= $validation->getError('jurusan'); ?>
          </div>
        </div>
        <div class="col-12 col-md-6 mb-3">
          <label for="phone" class="form-label">Nomor Telepon</label>
          <input type="tel" 
                 class="form-control <?= $validation->hasError('phone') ? 'is-invalid' : '' ?>" 
                 id="phone" name="phone" 
                 value="<?= $oldInput['phone'] ?? ''; ?>" 
                 placeholder="+628912345" required>
          <div class="invalid-feedback">
            <?= $validation->getError('phone'); ?>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6 mb-3">
          <label class="form-label">Jenis Kelamin</label>
          <div class="my-2">
            <div class="form-check form-check-inline">
              <input type="radio" 
                     class="form-check-input" 
                     id="male" name="gender" 
                     value="L" <?= ($oldInput['gender'] ?? '') == 'L' ? 'checked' : ''; ?> required>
              <label class="form-check-label" for="male">Laki-laki</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="radio" 
                     class="form-check-input" 
                     id="female" name="gender" 
                     value="P" <?= ($oldInput['gender'] ?? '') == 'P' ? 'checked' : ''; ?> required>
              <label class="form-check-label" for="female">Perempuan</label>
            </div>
          </div>
          <div class="invalid-feedback d-block">
            <?= $validation->getError('gender'); ?>
          </div>
        </div>
      </div>

      <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <textarea class="form-control <?= $validation->hasError('address') ? 'is-invalid' : '' ?>" 
                  id="address" name="address" required><?= $oldInput['address'] ?? ''; ?></textarea>
        <div class="invalid-feedback">
          <?= $validation->getError('address'); ?>
        </div>
      </div>

      <button type="submit" class="btn btn-primary mt-2">Simpan</button>
    </form>
  </div>
</div>
<?= $this->endSection() ?>
