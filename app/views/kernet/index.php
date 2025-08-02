<!-- app/views/kernet/index.php -->
<?php include '../app/views/layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemindaian Tiket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <h3>Pemindaian Tiket</h3>

        <!-- Form untuk input ID tiket yang akan dipindai -->
        <form action="index.php?url=kernet/scanTiket" method="POST">
            <div class="mb-3">
                <label for="tiket_id" class="form-label">Masukkan ID Tiket</label>
                <input type="text" class="form-control" id="tiket_id" name="tiket_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Scan Tiket</button>
        </form>

        <hr>

        <h4>Daftar Tiket yang Sudah Digunakan</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID Tiket</th>
                    <th>Bus</th>
                    <th>Tanggal Pesan</th>
                    <th>Status Pembayaran</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Jam Keberangkatan</th>
                    <th>Waktu Scan</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['scan_log'] as $log): ?>
                    <tr>
                        <td><?= $log['tiket_id']; ?></td>
                        <td><?= $log['bus_id'] ? $log['bus_id'] : 'Tidak Ditemukan'; ?></td>
                        <td><?= $log['tanggal_pesan'] ?? 'Tidak Ditemukan'; ?></td>
                        <td><?= ucfirst($log['status']) ?? 'Tidak Ditemukan'; ?></td>
                        <td><?= $log['asal'] ?? 'Tidak Ditemukan'; ?></td>
                        <td><?= $log['tujuan'] ?? 'Tidak Ditemukan'; ?></td>
                        <td><?= $log['jam'] ?? 'Tidak Ditemukan'; ?></td>
                        <td><?= $log['waktu_scan']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>

</html>