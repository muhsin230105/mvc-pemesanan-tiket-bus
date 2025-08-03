<!-- app/views/home/index.php -->
<?php
require_once '../app/views/layouts/header.php';
require_once '../app/views/layouts/navbar.php'; ?>

<h1 class="text-center my-4">MULAI PERJALANAN ANDA</h1>

<form method="GET" action="index.php">
    <input type="hidden" name="url" value="home/cari">

    <!-- ASAL -->
    <input type="text" name="asal" list="listTerminal" class="form-control" placeholder="Terminal Asal" required>

    <!-- TUJUAN -->
    <input type="text" name="tujuan" list="listTerminal" class="form-control" placeholder="Terminal Tujuan" required>

    <!-- TANGGAL -->
    <input type="date" name="tanggal" class="form-control" required>

    <!-- List terminal -->
    <datalist id="listTerminal">
        <?php foreach ($data['terminal'] as $terminal): ?>
            <option value="<?= htmlspecialchars($terminal) ?>">
            <?php endforeach; ?>
    </datalist>

    <div class="d-grid text-center my-3">
        <button class="btn btn-primary" type="submit">Cari Bus</button>
    </div>
</form>


<h3 class="mb-3">Daftar Bus Tersedia</h3>

<?php if (!empty($data['bus'])): ?>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kode Bus</th>
                    <th>Asal</th>
                    <th>Tujuan</th>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Kursi</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data['bus'] as $bus): ?>
                    <tr>
                        <td><?= $bus['kode_bus']; ?></td>
                        <td><?= $bus['asal']; ?></td>
                        <td><?= $bus['tujuan']; ?></td>
                        <td><?= $bus['tanggal']; ?></td>
                        <td><?= $bus['jam']; ?></td>
                        <td><?= $bus['jumlah_kursi']; ?></td>
                        <td><a href="index.php?url=bus/detail/<?= $bus['id']; ?>" class="btn btn-sm btn-info">PESAN</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Belum ada bus tersedia.</div>
<?php endif; ?>

<?php require_once '../app/views/layouts/footer.php'; ?>