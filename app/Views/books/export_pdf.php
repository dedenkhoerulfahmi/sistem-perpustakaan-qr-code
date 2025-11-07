<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Buku</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h3 { text-align: center; margin-bottom: 15px; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 11px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tfoot th {
            background-color: #e6e6e6;
            font-weight: bold;
        }
        .summary {
            margin-top: 20px;
            width: 50%;
            border-collapse: collapse;
            font-size: 11px;
        }
        .summary th, .summary td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
        }
        .summary th {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h3>Laporan Data Buku</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Masuk</th>
                <th>Nomor Induk</th>
                <th>Judul</th>
                <th>Pengarang</th>
                <th>Penerbit</th>
                <th>Tahun</th>
                <th>Sumber</th>
                <th>Kategori</th> <!-- Tambah kolom kategori hanya di export -->
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $no=1; 
            $rekapKategori = [];
            foreach($books as $b): 
                // Hitung jumlah per kategori
                $kategori = $b['kategori'] ?? 'Tidak Diketahui';
                if (!isset($rekapKategori[$kategori])) {
                    $rekapKategori[$kategori] = 0;
                }
                $rekapKategori[$kategori] += $b['quantity'];
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= !empty($b['tanggal_masuk']) ? date('d-m-Y', strtotime($b['tanggal_masuk'])) : '-' ?></td>
                <td><?= $b['nomor_induk']; ?></td>
                <td><?= $b['title']; ?></td>
                <td><?= $b['author']; ?></td>
                <td><?= $b['publisher']; ?></td>
                <td><?= $b['year']; ?></td>
                <td><?= $b['sumber']; ?></td>
                <td><?= $kategori; ?></td> <!-- tampilkan kategori -->
                <td><?= $b['quantity']; ?></td>
                <td>Rp <?= number_format($b['harga'],0,',','.'); ?></td>
                <td><?= $b['kondisi']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="9" style="text-align:right;">Total Buku</th>
                <th colspan="3"><?= array_sum(array_column($books, 'quantity')); ?></th>
            </tr>
        </tfoot>
    </table>

    <!-- Ringkasan Kategori -->
    <table class="summary">
        <tr>
            <th>Kategori</th>
            <th>Jumlah</th>
        </tr>
        <?php foreach($rekapKategori as $kategori => $jumlah): ?>
        <tr>
            <td><?= $kategori; ?></td>
            <td><?= $jumlah; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
