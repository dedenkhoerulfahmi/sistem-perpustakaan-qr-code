<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Tambah Data Pengunjung</title>
<style>
    @media (max-width: 576px) {
        .form-container {
            padding: 15px;
        }
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4 form-container">
    <h2 class="mb-4">Form Tambah Data Pengunjung</h2>

    <form action="<?= site_url('admin/visitors/store') ?>" method="post">
        <?= csrf_field() ?>

        <!-- Nama Lengkap -->
        <div class="mb-3">
            <label for="name" class="form-label">Nama Lengkap</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Contoh: Siti Nurhaliza" required>
        </div>

        <!-- Pilihan Kelas -->
        <div class="mb-3">
            <label for="kelas" class="form-label">Kelas</label>
            <select name="kelas" id="kelas" class="form-select" required>
                <option value="" disabled selected>Pilih Kelas</option>
                <?php
                $kelas = ['X A','X B','X C','XI A','XI B','XI C','XII A','XII B','XII C'];
                foreach ($kelas as $k): ?>
                    <option value="<?= $k ?>"><?= $k ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Pilihan Jurusan -->
        <div class="mb-3">
            <label for="jurusan" class="form-label">Jurusan</label>
            <select name="jurusan" id="jurusan" class="form-select" required>
                <option value="" disabled selected>Pilih Jurusan</option>
                <?php
                $jurusan = [
                    'Teknik Komputer dan Jaringan',
                    'Tata Boga',
                    'Farmasi Klinis dan Komunitas',
                    'Teknik Bisnis Sepeda Motor',
                    'Asisten Keperawatan',
                    'Akuntansi dan Keuangan Lembaga'
                ];
                foreach ($jurusan as $j): ?>
                    <option value="<?= $j ?>"><?= $j ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tanggal Kunjungan -->
        <div class="mb-3">
            <label for="visit_date" class="form-label">Tanggal Kunjungan</label>
            <input type="date" name="visit_date" id="visit_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
        </div>

        <!-- Jam Kunjungan -->
        <div class="mb-3">
            <label for="visit_time" class="form-label">Jam Kunjungan</label>
            <input type="time" name="visit_time" id="visit_time" class="form-control" value="<?= date('H:i') ?>" required>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <button type="reset" class="btn btn-outline-warning">Reset</button>
            <button type="submit" class="btn btn-success">Simpan Data</button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>
