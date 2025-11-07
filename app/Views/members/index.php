<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('head') ?>
<title>Data Anggota</title>
<style>
/* Hover baris tabel */
.table-hover tbody tr:hover {
    background-color: #f1f7ff;
}

/* Tab aktif lebih menonjol */
.nav-tabs .nav-link.active {
    background-color: #0d6efd;
    color: white;
    font-weight: bold;
}

/* Badge tambahan */
.badge-custom {
    font-size: 0.85em;
    padding: 0.35em 0.6em;
}

/* Card padding lebih nyaman */
.card-body {
    padding: 1.5rem;
}
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php if (session()->getFlashdata('msg')) : ?>
<div class="pb-2">
    <div class="alert <?= session()->getFlashdata('error') ? 'alert-danger' : 'alert-success'; ?> alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('msg') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
</div>
<?php endif; ?>

<div class="card shadow-sm">
    <div class="card-body">

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-3" id="anggotaTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($activeTab ?? 'siswa')==='siswa'?'active':'' ?>" id="siswa-tab" data-bs-toggle="tab" data-bs-target="#siswa" type="button" role="tab">👨‍🎓 Siswa</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link <?= ($activeTab ?? '')==='guru'?'active':'' ?>" id="guru-tab" data-bs-toggle="tab" data-bs-target="#guru" type="button" role="tab">👨‍🏫 Guru</button>
            </li>
        </ul>

        <div class="tab-content" id="anggotaTabsContent">

            <!-- TAB SISWA -->
            <div class="tab-pane fade <?= ($activeTab ?? 'siswa')==='siswa'?'show active':'' ?>" id="siswa" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">📚 Daftar Siswa</h4>
                    <a href="<?= base_url('admin/members/new'); ?>" class="btn btn-success btn-sm">
                        <i class="ti ti-user-plus"></i> Tambah Siswa
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>No Anggota</th>
                                <th>Nomor Induk</th>
                                <th>Nama</th>
                                <th>Kelas</th>
                                <th>Jurusan</th>
                                <th>Telepon</th>
                                <th>Alamat</th>
                                <th>Gender</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1 ?>
                            <?php if (empty($members)) : ?>
                                <tr>
                                    <td colspan="10" class="text-center text-muted">Tidak ada data siswa</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($members as $m) : ?>
                                    <tr>
                                        <td class="text-center"><?= $i++ ?></td>
                                        <td><span class="badge bg-secondary badge-custom"><?= esc($m['member_no'] ?? '-') ?></span></td>
                                        <td><span class="badge bg-dark text-white badge-custom"><?= esc($m['nomor_induk'] ?? '-') ?></span></td>
                                        <td><?= esc($m['first_name']) ?></td>
                                        <td><span class="badge bg-primary text-white badge-custom"><?= esc($m['kelas'] ?? '-') ?></span></td>
                                        <td><span class="badge bg-warning text-dark badge-custom"><?= esc($m['jurusan'] ?? '-') ?></span></td>
                                        <td><?= esc($m['phone'] ?? '-') ?></td>
                                        <td><?= esc($m['address'] ?? '-') ?></td>
                                        <td class="text-center">
                                            <?= $m['gender']==='male' ? '<span class="badge bg-info text-dark badge-custom">Laki-laki</span>' : 
                                                ($m['gender']==='female' ? '<span class="badge bg-pink text-white badge-custom">Perempuan</span>' : '-') ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="<?= base_url("admin/members/{$m['uid']}/edit"); ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit Siswa">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="<?= base_url("admin/members/{$m['uid']}"); ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus siswa ini?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus Siswa">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB GURU -->
            <div class="tab-pane fade <?= ($activeTab ?? '')==='guru'?'show active':'' ?>" id="guru" role="tabpanel">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="fw-bold mb-0">👨‍🏫 Daftar Guru</h4>
                    <a href="<?= base_url('admin/teachers/new'); ?>" class="btn btn-success btn-sm">
                        <i class="ti ti-user-plus"></i> Tambah Guru
                    </a>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>No Anggota</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $j = 1 ?>
                            <?php if (empty($teachers)) : ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Tidak ada data guru</td>
                                </tr>
                            <?php else : ?>
                                <?php foreach ($teachers as $t) : ?>
                                    <tr>
                                        <td class="text-center"><?= $j++ ?></td>
                                        <td><span class="badge bg-secondary badge-custom"><?= esc($t['no_anggota']) ?></span></td>
                                        <td><?= esc($t['nama']) ?></td>
                                        <td><?= esc($t['alamat']) ?></td>
                                        <td class="text-center">
                                            <a href="<?= base_url("admin/teachers/{$t['id']}/edit"); ?>" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Edit Guru">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            <form action="<?= base_url("admin/teachers/{$t['id']}"); ?>" method="post" class="d-inline" onsubmit="return confirm('Yakin hapus guru ini?');">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="_method" value="DELETE">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Hapus Guru">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
});
</script>

<?= $this->endSection() ?>
