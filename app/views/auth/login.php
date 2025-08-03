<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Login & Register - PO Muhsin Jaya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" id="authTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Daftar</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="authTabContent">
                            <!-- LOGIN FORM -->
                            <div class="tab-pane fade show active" id="login" role="tabpanel">
                                <h4 class="text-center mb-3">Login</h4>
                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger"><?= $error ?></div>
                                <?php endif; ?>
                                <form action="index.php?url=login/proses" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <button class="btn btn-primary w-100" type="submit">Login</button>
                                </form>
                            </div>

                            <!-- REGISTER FORM -->
                            <div class="tab-pane fade" id="register" role="tabpanel">
                                <h4 class="text-center mb-3">Daftar Akun</h4>
                                <form action="index.php?url=login/register" method="POST">
                                    <div class="mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="nama" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Password</label>
                                        <input type="password" name="password" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">No HP</label>
                                        <input type="text" name="no_hp" class="form-control" maxlength="15" pattern="[0-9]{10,15}" required>
                                    </div>
                                    <button class="btn btn-success w-100" type="submit">Daftar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-center mt-3 text-muted">© PO Muhsin Jaya <?= date('Y') ?></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>