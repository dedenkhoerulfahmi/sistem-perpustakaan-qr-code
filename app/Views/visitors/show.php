<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
    <title>Detail Pengunjung</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="container mt-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detail Pengunjung</h4>
            </div>
            <div class="card-body">
                <table class="table table-bordered mb-4">
                    <tr>
                        <th width="30%">Nama</th>
                        <td><?= esc($visitor['name']) ?></td>
                    </tr>
                    <tr>
                        <th>Kelas</th>
                        <td><?= esc($visitor['kelas']) ?></td>
                    </tr>
                    <tr>
                        <th>Jurusan</th>
                        <td><?= esc($visitor['jurusan']) ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Kunjungan</th>
                        <td><?= esc($visitor['visit_date']) ?></td>
                    </tr>
                    <tr>
                        <th>Jam Kunjungan</th>
                        <td><?= esc($visitor['visit_time']) ?></td>
                    </tr>
                </table>
                <a href="<?= site_url('visitors') ?>" class="btn btn-outline-secondary">
                    ← Kembali ke daftar
                </a>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>
