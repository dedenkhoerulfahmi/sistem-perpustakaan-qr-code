<?php if (!empty($msg)) : ?>
  <p class="text-danger text-center"><?= esc($msg) ?></p>

<?php elseif (!empty($members)) : ?>
  <h5 class="fw-semibold mb-3">Hasil Pencarian Anggota</h5>
  <div class="table-responsive">
    <table class="table table-hover table-striped align-middle">
      <thead class="table-light">
        <tr>
          <th>#</th>
          <th>No Anggota</th>
          <th>Nomor Induk</th>
          <th>Nama</th>
          <th>Kelas</th>
          <th>Jurusan</th>
          <th>Phone</th>
          <th>Alamat</th>
          <th>Jenis Kelamin</th>
          <th class="text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $i = 1; foreach ($members as $member) : ?>
          <tr>
            <td><?= $i++ ?></td>
            <td>
              <span class="badge bg-secondary">
                <?= esc($member['member_no'] ?? '-') ?>
              </span>
            </td>
            <td><?= esc($member['nomor_induk'] ?? '-') ?></td>
            <td><b><?= esc($member['first_name'] ?? '') ?> <?= esc($member['last_name'] ?? '') ?></b></td>
            <td><?= esc($member['kelas'] ?? '-') ?></td>
            <td><?= esc($member['jurusan'] ?? '-') ?></td>
            <td><?= esc($member['phone'] ?? '-') ?></td>
            <td><?= esc($member['address'] ?? '-') ?></td>
            <td><?= esc($member['gender'] ?? '-') ?></td>
            <td class="text-center">
              <a href="<?= base_url("admin/loans/new/books/search?member-uid=" . urlencode($member['uid'])) ?>" 
                 class="btn btn-sm btn-primary">
                Pilih
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php else : ?>
  <p class="text-warning text-center">⚠ Tidak ada data anggota ditemukan</p>
<?php endif; ?>
