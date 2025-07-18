<!-- app/views/home/hasil.php -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>

<h2>Hasil Pencarian Bus</h2>

<?php if (!empty($data['hasil'])): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Bus</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Sisa Kursi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['hasil'] as $bus): ?>
                    <tr>
                        <td><?= $bus['kode_bus']; ?></td>
                        <td><?= $bus['asal']; ?></td>
                        <td><?= $bus['tujuan']; ?></td>
                        <td><?= $bus['tanggal']; ?></td>
                        <td><?= $bus['jam']; ?></td>
                        <td><?= $bus['sisa_kursi']; ?></td>
                        <td><a href="index.php?url=bus/detail/<?= $bus['id']; ?>" class="btn btn-sm btn-info">Detail</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Tidak ada bus ditemukan.</div>
<?php endif; ?>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>