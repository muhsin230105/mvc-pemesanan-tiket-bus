<?php include '../app/views/admin/header.php'; ?>

<div class="container mt-4">
    <h2>Daftar Pengguna</h2>

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