<?= $this->extend('layouts/admin_layout') ?>
<?= $this->section('content') ?>

<div class="card shadow-sm">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">✏️ Edit Guru</h4>
        <a href="<?= base_url('admin/members') ?>" class="btn btn-outline-secondary btn-sm">← Kembali</a>
    </div>
    <div class="card-body">
        <form action="<?= base_url("admin/teachers/{$teacher['id']}") ?>" method="post">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="mb-3">
                <label>No Anggota</label>
                <input type="text" name="no_anggota" class="form-control <?= isset($validation) && $validation->hasError('no_anggota') ? 'is-invalid' : '' ?>" value="<?= old('no_anggota', $teacher['no_anggota']) ?>">
                <div class="invalid-feedback"><?= isset($validation) ? $validation->getError('no_anggota') : '' ?></div>
            </div>

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control <?= isset($validation) && $validation->hasError('nama') ? 'is-invalid' : '' ?>" value="<?= old('nama', $teacher['nama']) ?>">
                <div class="invalid-feedback"><?= isset($validation) ? $validation->getError('nama') : '' ?></div>
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea name="alamat" class="form-control <?= isset($validation) && $validation->hasError('alamat') ? 'is-invalid' : '' ?>" rows="3"><?= old('alamat', $teacher['alamat']) ?></textarea>
                <div class="invalid-feedback"><?= isset($validation) ? $validation->getError('alamat') : '' ?></div>
            </div>

            <div class="d-flex justify-content-end">
                <button type="reset" class="btn btn-outline-warning me-2">Reset</button>
                <button type="submit" class="btn btn-success">Simpan</button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
