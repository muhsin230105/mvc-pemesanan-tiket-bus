<?php
// app/core/helper.php

function requireLogin($role = null)
{
    if (!isset($_SESSION['user'])) {
        header('Location: index.php?url=login');
        exit;
    }

    // Jika role di-set dan role tidak sesuai dengan role user, beri akses ditolak
    if ($role && $_SESSION['user']['role'] !== $role) {
        echo "Akses ditolak. Halaman ini hanya untuk $role.";
        exit;
    }
}
