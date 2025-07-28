<?php include '../app/views/admin/header.php'; ?>
<div class="container mt-4">
    <h1>Selamat Datang, Admin!</h1>
    <p class="mb-3">Statistik Sistem</p>

    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Pengguna</h5>
                    <p class="card-text fs-3"><?= $data['totalUser'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Tiket Terjual</h5>
                    <p class="card-text fs-3"><?= $data['totalTiket'] ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Bus Aktif</h5>
                    <p class="card-text fs-3"><?= $data['totalBus'] ?></p>
                </div>
            </div>
        </div>
    </div>

    <hr>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Daftar Bus Aktif Hari Ini</h4>
        <a href="index.php?url=admin/bus" class="btn btn-outline-primary btn-sm">Kelola Semua Bus</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Kode</th>
                <th>Asal</th>
                <th>Tujuan</th>
                <th>Tanggal</th>
                <th>Jam</th>
                <th>Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['bus'] as $bus): ?>
                <tr>
                    <td><?= htmlspecialchars($bus['kode_bus']) ?></td>
                    <td><?= htmlspecialchars($bus['asal']) ?></td>
                    <td><?= htmlspecialchars($bus['tujuan']) ?></td>
                    <td><?= $bus['tanggal'] ?></td>
                    <td><?= $bus['jam'] ?></td>
                    <td>Rp<?= number_format($bus['harga_per_kursi']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include '../app/views/admin/footer.php'; ?>