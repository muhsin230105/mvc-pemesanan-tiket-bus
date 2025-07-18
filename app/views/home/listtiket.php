<?php
require_once '../app/views/layouts/header.php';
require_once '../app/views/layouts/navbar.php';
?>

<div class="container mt-5">
    <h3>Daftar Tiket Anda</h3>

    <?php if (!empty($data['tiket_list'])): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Tiket</th>
                    <th>Bus</th>
                    <th>Tanggal Pesan</th>
                    <th>Status Pembayaran</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['tiket_list'] as $tiket): ?>
                    <tr>
                        <td><?= $tiket['id']; ?></td>
                        <td><?= $tiket['bus_id']; ?></td>
                        <td><?= $tiket['tanggal_pesan']; ?></td>
                        <td>
                            <span class="badge bg-<?= $tiket['status'] == 'sudah_bayar' ? 'success' : 'warning' ?>">
                                <?= ucfirst($tiket['status']); ?>
                            </span>
                        </td>
                        <td><?= $tiket['total_harga']; ?></td>
                        <td>
                            <a href="index.php?url=tiket/detail&id=<?= $tiket['id']; ?>" class="btn btn-info">Detail</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Anda belum memesan tiket.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>