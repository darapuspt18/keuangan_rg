<?php
include 'koneksi.php';

// Header untuk memberi tahu browser bahwa file ini adalah Excel (.xls)
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment5; filename=Laporan_Keuangan_Dara.xls");

$query = mysqli_query($koneksi, "SELECT * FROM transaksi ORDER BY tanggal ASC, id ASC");
?>

<h3 style="text-align: center;">Laporan Keuangan Rumah Tangga</h3>
<table border="1">
    <thead>
        <tr style="background-color: #8a253c; color: white;">
            <th>No</th>
            <th>Tanggal</th>
            <th>Kategori</th>
            <th>Jenis</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $no = 1;
        while($data = mysqli_fetch_assoc($query)): 
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $data['tanggal']; ?></td>
            <td><?= $data['kategori']; ?></td>
            <td><?= ucfirst($data['jenis']); ?></td>
            <td><?= $data['jumlah']; ?></td>
            <td><?= $data['keterangan']; ?></td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>