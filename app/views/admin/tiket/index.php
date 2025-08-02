<?php include '../app/views/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Daftar Tiket Pemesanan</h2>

    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Pemesan</th>
                <th>Bus</th>
                <th>Rute</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Total</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Barcode</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['tiket'] as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['nama_user']) ?></td>
                    <td><?= $t['kode_bus'] ?></td>
                    <td><?= $t['asal'] ?> → <?= $t['tujuan'] ?></td>
                    <td><?= $t['tanggal'] ?></td>
                    <td><?= $t['jam'] ?></td>
                    <td>Rp<?= number_format($t['total_harga']) ?></td>
                    <td>
                        <!-- --------------------------------------------------- -->
                        <span class="badge bg-<?=
                                                $t['status'] === 'belum_bayar' ? 'secondary' : ($t['status'] === 'sudah_bayar' ? 'info' : 'success') ?>">
                            <?= $t['status'] ?>
                        </span> <br>
                        <!-- -------------------------------------------------------- -->
                        <button class="mt-1 btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#ubahModal<?= $t['id'] ?>">Ubah</button>

                        <!-- Modal -->
                        <div class="modal fade" id="ubahModal<?= $t['id'] ?>" tabindex="-1" aria-labelledby="ubahModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="index.php?url=admin/ubahStatusTiket">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ubah Status Tiket</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <input type="hidden" name="tiket_id" value="<?= $t['id'] ?>">
                                            <div class="mb-3">
                                                <label>Status Tiket</label>
                                                <select name="status" class="form-select status-select" data-modal-id="<?= $t['id'] ?>" required>
                                                    <option value="belum_bayar" <?= $t['status'] === 'belum_bayar' ? 'selected' : '' ?>>Belum Bayar</option>
                                                    <option value="sudah_bayar" <?= $t['status'] === 'sudah_bayar' ? 'selected' : '' ?>>Sudah Bayar</option>
                                                    <option value="digunakan" <?= $t['status'] === 'digunakan' ? 'selected' : '' ?>>Digunakan</option>
                                                    <option value="kadaluarsa" <?= $t['status'] === 'kadaluarsa' ? 'selected' : '' ?>>Kadaluarsa</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 metode-pembayaran" id="metode-<?= $t['id'] ?>" style="display: none;">
                                                <label>Metode Pembayaran</label>
                                                <select name="metode_pembayaran" class="form-select metode-select-<?= $t['id'] ?>">
                                                    <option value="">-- Pilih Metode --</option>
                                                    <option value="QRIS" <?= $t['metode_pembayaran'] === 'QRIS' ? 'selected' : '' ?>>QRIS</option>
                                                    <option value="Transfer" <?= $t['metode_pembayaran'] === 'Transfer' ? 'selected' : '' ?>>Transfer</option>
                                                    <option value="Lainnya" <?= $t['metode_pembayaran'] === 'Lainnya' ? 'selected' : '' ?>>Lainnya</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </td>
                    <td><?= $t['metode_pembayaran'] ?? '-' ?></td>
                    <td><code><?= $t['barcode'] ?></code></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<!-- ----------------------------------------------------------------------------------------------------------- -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const selects = document.querySelectorAll('.status-select');

        selects.forEach(select => {
            const id = select.dataset.modalId;
            const metodeDiv = document.getElementById('metode-' + id);

            function toggleMetode() {
                if (select.value === 'sudah_bayar') {
                    metodeDiv.style.display = 'block';
                } else {
                    metodeDiv.style.display = 'none';
                }
            }

            // Saat pertama dibuka
            toggleMetode();

            // Saat status diubah
            select.addEventListener('change', toggleMetode);
        });
    });
</script>


<?php include '../app/views/layouts/footer.php'; ?>