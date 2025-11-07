<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Edit Anggota</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
$member = $member ?? [];
$oldInput = $oldInput ?? [];
?>

<a href="<?= base_url('admin/members'); ?>" class="btn btn-outline-primary mb-3">
  <i class="ti ti-arrow-left"></i> Kembali
</a>

<form action="<?= site_url('admin/members/' . ($member['uid'] ?? '')) ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" name="_method" value="PUT">

    <!-- No Anggota -->
    <div class="form-group mb-3">
        <label for="no_anggota">No Anggota</label>
        <input type="text" 
               class="form-control" 
               id="no_anggota" 
               name="no_anggota" 
               value="<?= esc($oldInput['member_no'] ?? $member['member_no'] ?? 'PS-001') ?>"
               readonly>
    </div>

    <!-- Nomor Induk -->
    <div class="form-group mb-3">
        <label for="nomor_induk">Nomor Induk</label>
        <input type="text" 
               class="form-control" 
               id="nomor_induk" 
               name="nomor_induk" 
               value="<?= esc($oldInput['nomor_induk'] ?? $member['nomor_induk'] ?? '') ?>" 
               required>
    </div>

    <!-- Nama -->
    <div class="form-group mb-3">
        <label for="first_name">Nama</label>
        <input type="text" 
               class="form-control" 
               id="first_name" 
               name="first_name" 
               value="<?= esc($oldInput['first_name'] ?? $member['first_name'] ?? '') ?>" 
               required>
    </div>

    <!-- Kelas -->
    <div class="form-group mb-3">
        <label for="kelas">Kelas</label>
        <input type="text" 
               class="form-control" 
               id="kelas" 
               name="kelas" 
               value="<?= esc($oldInput['kelas'] ?? $member['kelas'] ?? '') ?>" 
               required>
    </div>

    <!-- Jurusan -->
    <div class="form-group mb-3">
        <label for="jurusan">Jurusan</label>
        <input type="text" 
               class="form-control" 
               id="jurusan" 
               name="jurusan" 
               value="<?= esc($oldInput['jurusan'] ?? $member['jurusan'] ?? '') ?>" 
               required>
    </div>

    <!-- Nomor HP -->
    <div class="form-group mb-3">
        <label for="phone">Nomor HP</label>
        <input type="text" 
               class="form-control" 
               id="phone" 
               name="phone" 
               value="<?= esc($oldInput['phone'] ?? $member['phone'] ?? '') ?>">
    </div>

    <!-- Alamat -->
    <div class="form-group mb-3">
        <label for="address">Alamat</label>
        <textarea class="form-control" id="address" name="address"><?= esc($oldInput['address'] ?? $member['address'] ?? '') ?></textarea>
    </div>

<div class="form-group mb-3">
    <label for="gender">Jenis Kelamin</label>
    <select class="form-control <?= isset($validation) && $validation->hasError('gender') ? 'is-invalid' : '' ?>" id="gender" name="gender" required>
        <option value="" disabled <?= empty($oldInput['gender'] ?? $member['gender'] ?? '') ? 'selected' : '' ?>>-- Pilih Gender --</option>
        <option value="L" <?= (($oldInput['gender'] ?? $member['gender'] ?? '') === 'L') ? 'selected' : '' ?>>Laki-Laki</option>
        <option value="P" <?= (($oldInput['gender'] ?? $member['gender'] ?? '') === 'P') ? 'selected' : '' ?>>Perempuan</option>
    </select>
    <?php if (isset($validation) && $validation->hasError('gender')) : ?>
        <div class="invalid-feedback d-block">
            <?= $validation->getError('gender') ?>
        </div>
    <?php endif; ?>
</div>
    <!-- Submit -->
    <button type="submit" class="btn btn-success">Simpan Perubahan</button>
</form>
<?php if (empty($member['uid'])) : ?>
  <div class="alert alert-danger">UID anggota tidak tersedia. Form tidak bisa disimpan.</div>
<?php endif; ?>
<?= $this->endSection() ?>
