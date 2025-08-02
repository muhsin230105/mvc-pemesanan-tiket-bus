<?php
$current = $_GET['url'] ?? 'admin'; // default 'admin' kalau kosong
?>
<?php include '../app/views/layouts/header.php'; ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - PO Muhsin Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="d-flex flex-column min-vh-100">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">

                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link <?= $current === 'admin' ? 'active' : '' ?>" href="index.php?url=admin">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current === 'admin/users' ? 'active' : '' ?>" href="index.php?url=admin/users">Pengguna</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current === 'admin/bus' ? 'active' : '' ?>" href="index.php?url=admin/bus">Bus</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $current === 'admin/tiket' ? 'active' : '' ?>" href="index.php?url=admin/tiket">tiket</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>