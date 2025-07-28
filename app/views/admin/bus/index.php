<?php include '../app/views/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Daftar Bus</h2>
    <a href="index.php?url=admin/tambahBus" class="btn btn-primary mb-3">+ Tambah Bus</a>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kode</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Kursi</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['bus'] as $bus): ?>
                <tr>
                    <td><?= $bus['kode_bus'] ?></td>
                    <td><?= $bus['asal'] ?></td>
                    <td><?= $bus['tujuan'] ?></td>
                    <td><?= $bus['tanggal'] ?></td>
                    <td><?= $bus['jam'] ?></td>
                    <td><?= $bus['jumlah_kursi'] ?></td>
                    <td>Rp<?= number_format($bus['harga_per_kursi']) ?></td>
                    <td>
                        <a href="index.php?url=admin/editBus/<?= $bus['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="index.php?url=admin/hapusBus/<?= $bus['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus data ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../app/views/admin/footer.php'; ?>