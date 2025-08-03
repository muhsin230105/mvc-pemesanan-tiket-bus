<?php include '../app/views/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Daftar Pengguna</h2>

    <!-- Form Tambah Pengguna -->
    <div class="card mb-4">
        <div class="card-header">Tambah Pengguna Baru</div>
        <div class="card-body">
            <form method="POST" action="index.php?url=admin/tambahUser">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label>Nama</label>
                        <input type="text" class="form-control" name="nama" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Email</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>No. HP</label>
                        <input type="text" class="form-control" name="no_hp" maxlength="15" pattern="[0-9]{10,15}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Password</label>
                        <input type="password" class="form-control" name="password" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label>Role</label>
                        <select class="form-select" name="role" required>
                            <option value="pembeli">Pembeli</option>
                            <option value="kernet">Kernet</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Pengguna</button>
            </form>
        </div>
    </div>

    <!-- Tabel Daftar Pengguna -->
    <table class="table table-bordered table-striped mt-3">
        <thead class="table-dark">
            <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Status</th>
                <th>No. HP</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['users'] as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['nama']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><span class="badge bg-secondary"><?= $user['role'] ?></span></td>
                    <td><?= htmlspecialchars($user['no_hp']) ?></td>
                    <td>
                        <?php if ($user['role'] !== 'admin'): ?>
                            <a href="index.php?url=admin/editUser/<?= $user['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="index.php?url=admin/hapusUser/<?= $user['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus pengguna ini?')">Hapus</a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../app/views/admin/footer.php'; ?>