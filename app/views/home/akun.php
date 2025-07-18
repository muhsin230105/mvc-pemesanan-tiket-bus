<?php
require_once '../app/views/layouts/header.php';
require_once '../app/views/layouts/navbar.php';
?>

<div class="container mt-5">
    <h3>Profil Saya</h3>

    <?php if (isset($data['success_message'])): ?>
        <!-- Menampilkan notifikasi sukses -->
        <div class="alert alert-success">
            <?= $data['success_message']; ?>
        </div>
    <?php endif; ?>

    <!-- Form untuk mengedit data akun -->
    <form method="POST" action="index.php?url=akun/update">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" class="form-control" id="nama" name="nama" value="<?= $data['user']['nama']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?= $data['user']['email']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <button type="submit" class="btn btn-primary">Update Profil</button>
    </form>
</div>

<?php
require_once '../app/views/layouts/footer.php';
?>