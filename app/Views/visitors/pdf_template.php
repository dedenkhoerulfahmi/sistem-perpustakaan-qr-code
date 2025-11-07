<?php
$nama_bulan = [
  '01' => 'Januari',
  '02' => 'Februari',
  '03' => 'Maret',
  '04' => 'April',
  '05' => 'Mei',
  '06' => 'Juni',
  '07' => 'Juli',
  '08' => 'Agustus',
  '09' => 'September',
  '10' => 'Oktober',
  '11' => 'November',
  '12' => 'Desember',
];

$bulan = date('m', strtotime($selected_month));
$tahun = date('Y', strtotime($selected_month));

// Mapping angka kelas ke X, XI, XII
$kelas_map = [
    '10' => 'X',
    '11' => 'XI',
    '12' => 'XII'
];
?>

<!-- ✅ Kalimat Deskriptif -->
<p style="text-align:center; font-size:16px; margin-bottom:5px;">
  Laporan Data Kunjungan SMK AS-SHOFA Bulan <?= $nama_bulan[$bulan] ?> Tahun <?= $tahun ?>
</p>

<h2 style="text-align:center; margin-bottom:10px;">Laporan Data Kunjungan</h2>

<table border="1" cellpadding="8" cellspacing="0" width="100%" style="border-collapse:collapse; font-family:sans-serif;">
  <thead style="background-color:#f2f2f2;">
    <tr>
      <th>Nama</th>
      <th>Kelas</th>
      <th>Jurusan</th>
      <th>Tanggal</th>
      <th>Jam</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($visitors as $v): 
        $kelas_romawi = isset($kelas_map[$v['kelas']]) ? $kelas_map[$v['kelas']] : $v['kelas'];
    ?>
    <tr>
      <td><?= $v['name'] ?></td>
      <td><?= $kelas_romawi ?></td>
      <td><?= $v['jurusan'] ?></td>
      <td><?= $v['visit_date'] ?></td>
      <td><?= $v['visit_time'] ?></td>
    </tr>
    <?php endforeach ?>
    <tr>
      <td colspan="5" style="text-align:right; font-weight:bold; background-color:#f9f9f9;">
        Total Pengunjung: <?= count($visitors) ?>
      </td>
    </tr>
  </tbody>
</table>
