<!-- app/views/layouts/header.php -->
<!-- app/views/layouts/header.php -->
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PO MUHSIN JAYA</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<style>
    .logo {
        font-size: 20px;
        font-weight: bold;
        text-decoration: none;
        color: white;
    }



    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        background-color: #28a745;
        color: white;
        text-align: center;
        line-height: 40px;
        border-radius: 5px;
        font-weight: bold;
        cursor: pointer;
    }

    .booked {
        background-color: #dc3545 !important;
        cursor: not-allowed;
    }

    .selected {
        background-color: #ffc107 !important;
        color: black;
    }

    .row-seat {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }
</style>

<body>
    <header>
        <div class="bg-dark text-white p-3">
            <div class="container d-flex justify-content-between align-items-center">
                <a href="<?= BASE_URL; ?>" class="text-white text-decoration-none h4">PO MUHSIN JAYA</a>

                <!-- Tombol Logout -->
                <?php if (isset($_SESSION['user'])): ?>
                    Selamat Datang <?= $_SESSION['user']['nama']; ?> <!-- Menampilkan hanya nama pengguna -->
                    <form action="index.php?url=login/logout" method="POST" class="mb-0">
                        <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                    </form>
                <?php endif; ?>
            </div>
    </header>