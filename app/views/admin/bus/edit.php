<?php include '../app/views/layouts/header.php'; ?>

<div class="container mt-4">
    <h2>Edit Data Bus</h2>
    <form action="index.php?url=admin/editBus/<?= $data['bus']['id'] ?>" method="POST">
        <div class="mb-3"><label>Kode Bus</label><input type="text" name="kode_bus" class="form-control" value="<?= $data['bus']['kode_bus'] ?>" required></div>
        <div class="mb-3"><label>Asal</label><input type="text" name="asal" class="form-control" value="<?= $data['bus']['asal'] ?>" required></div>
        <div class="mb-3"><label>Tujuan</label><input type="text" name="tujuan" class="form-control" value="<?= $data['bus']['tujuan'] ?>" required></div>
        <div class="mb-3"><label>Tanggal</label><input type="date" name="tanggal" class="form-control" value="<?= $data['bus']['tanggal'] ?>" required></div>
        <div class="mb-3"><label>Jam</label><input type="time" name="jam" class="form-control" value="<?= $data['bus']['jam'] ?>" required></div>
        <div class="mb-3"><label>Jumlah Kursi</label><input type="number" name="jumlah_kursi" class="form-control" value="<?= $data['bus']['jumlah_kursi'] ?>" required></div>
        <div class="mb-3"><label>Harga per Kursi</label><input type="number" name="harga_per_kursi" class="form-control" value="<?= $data['bus']['harga_per_kursi'] ?>" required></div>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="index.php?url=admin/bus" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../app/views/layouts/footer.php'; ?>