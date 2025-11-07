<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Data Kunjungan</title>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container mt-4">
    <h2>Data Kunjungan</h2>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="mb-3 d-flex justify-content-between align-items-center flex-wrap gap-2">
        <a href="<?= site_url('admin/visitors/create') ?>" class="btn btn-primary">Tambah Pengunjung</a>

        <form action="<?= site_url('admin/visitors/export') ?>" method="post" class="d-flex align-items-center gap-2 flex-wrap">
            <label for="month" class="form-label mb-0">Bulan:</label>
            <input type="month" name="month" class="form-control" required>

            <label for="format" class="form-label mb-0">Format:</label>
            <select name="format" class="form-select" required>
                <option value="pdf">PDF</option>
                <option value="excel">Excel</option>
            </select>

            <button type="submit" class="btn btn-success">Export</button>
        </form>
    </div>

    <?php
    // Mapping angka kelas ke X, XI, XII
    $kelas_map = [
        '10' => 'X',
        '11' => 'XI',
        '12' => 'XII'
    ];

    // Badge warna untuk kelas
    $kelas_badge = [
        'X'  => 'primary',
        'XI' => 'success',
        'XII'=> 'warning'
    ];
    ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped table-hover align-middle mt-3">
            <thead class="table-dark text-center">
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach ($visitors as $v): 
                    $kelas_romawi = isset($kelas_map[$v['kelas']]) ? $kelas_map[$v['kelas']] : $v['kelas'];
                    $badge_class = isset($kelas_badge[$kelas_romawi]) ? $kelas_badge[$kelas_romawi] : 'secondary';
                ?>
                <tr>
                    <td class="text-center"><?= $no++ ?></td>
                    <td><?= $v['name'] ?></td>
                    <td class="text-center">
                        <span class="badge bg-<?= $badge_class ?>"><?= $kelas_romawi ?></span>
                    </td>
                    <td><?= $v['jurusan'] ?></td>
                    <td class="text-center"><?= date('d M Y', strtotime($v['visit_date'])) ?></td>
                    <td class="text-center"><?= date('H:i', strtotime($v['visit_time'])) ?></td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
