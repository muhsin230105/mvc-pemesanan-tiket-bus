<!-- views/layout/navbar.php -->
<div class="bg-dark text-white p-3">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link <?= $url === 'home/index' ? 'active' : '' ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $url === 'tiket/listTiket' ? 'active' : '' ?>" href="index.php?url=tiket/listTiket">Tiket</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= $url === 'akun/index' ? 'active' : '' ?>" href="index.php?url=akun/index">Akun Saya</a>
                        <!--  -->
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<!-- Menambahkan Bootstrap JS (jika belum ditambahkan di bagian footer) -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

<div class="container">