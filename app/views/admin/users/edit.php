<?php include '../app/views/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Edit Pengguna</h2>

    <form method="POST" action="">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($data['user']['nama']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($data['user']['email']) ?>" required>
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">No. HP</label>
            <input type="text" class="form-control" name="no_hp" maxlength="15" pattern="[0-9]{10,15}" value="<?= htmlspecialchars($data['user']['no_hp']) ?>" required>
        </div>


        <div class="mb-3">
            <label for="password" class="form-label">Password Baru</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak diubah">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role" required>
                <option value="admin" <?= $data['user']['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="pembeli" <?= $data['user']['role'] === 'pembeli' ? 'selected' : '' ?>>Pembeli</option>
                <option value="kernet" <?= $data['user']['role'] === 'kernet' ? 'selected' : '' ?>>Kernet</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="index.php?url=admin/users" class="btn btn-secondary">Batal</a>
    </form>
</div>

<?php include '../app/views/admin/footer.php'; ?>