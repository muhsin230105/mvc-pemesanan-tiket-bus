<!-- app/views/tiket/konfirmasi.php -->
<?php
require_once '../app/views/layouts/header.php';
require_once '../app/views/layouts/navbar.php'; ?>

<style>
    /* Hiding the payment form after successful payment */
    .payment-form-hidden {
        display: none;
    }

    /* Set background color for the entire body */
    body.status-belum-bayar {
        background-color: rgba(255, 255, 0, 0.1);
    }

    body.status-sudah-bayar {
        background-color: rgba(0, 255, 0, 0.1);
    }

    body.status-digunakan {
        background-color: rgba(255, 0, 0, 0.1);
        /* Optional, to differentiate status */
    }
</style>

<body class="<?= $data['tiket']['status'] == 'belum_bayar' ? 'status-belum-bayar' : ($data['tiket']['status'] == 'sudah_bayar' ? 'status-sudah-bayar' : 'status-digunakan') ?>">

    <div class="container mt-5">
        <h3>Detail Tiket Anda</h3>

        <ul class="list-group">
            <li class="list-group-item">ID Tiket: <?= $data['tiket']['id']; ?></li>
            <li class="list-group-item">Bus: <?= $data['tiket']['bus_id']; ?></li>
            <li class="list-group-item">Asal: <?= $data['tiket']['asal']; ?></li>
            <li class="list-group-item">Tujuan: <?= $data['tiket']['tujuan']; ?></li>
            <li class="list-group-item">Jam Keberangkatan: <?= $data['tiket']['jam']; ?></li>
            <li class="list-group-item">Tanggal Pesan: <?= $data['tiket']['tanggal_pesan']; ?></li>
            <li class="list-group-item">
                Status Pembayaran:
                <span class="badge bg-<?= $data['tiket']['status'] == 'sudah_bayar' ? 'success' : 'warning' ?>" id="status-pembayaran">
                    <?= ucfirst($data['tiket']['status']); ?>
                </span>
            </li>
            <li class="list-group-item">Metode Pembayaran: <?= $data['tiket']['metode_pembayaran'] ?? 'Belum memilih metode pembayaran'; ?></li>
            <li class="list-group-item">Harga: <?= $data['tiket']['total_harga']; ?></li>
            <li class="list-group-item">
                <strong>Barcode QR:</strong><?= $data['tiket']['barcode']; ?><br>
                <!-- Menampilkan QR Code untuk barcode -->
                <img src="https://api.qrserver.com/v1/create-qr-code/?data=<?= urlencode($data['tiket']['barcode']); ?>&size=150x150" alt="QR Code">
            </li>
        </ul>

        <!-- Tombol Pembatalan Pemesanan (Sembunyikan jika statusnya 'digunakan') -->
        <?php if ($data['tiket']['status'] !== 'sudah_bayar' && $data['tiket']['status'] !== 'digunakan'): ?>
            <form action="index.php?url=tiket/batal/<?= $data['tiket']['id']; ?>" method="POST">
                <button type="submit" class="btn btn-danger mt-3">Batal Pemesanan</button>
            </form>
        <?php endif; ?>

        <a href="index.php?url=tiket/listTiket" class="btn btn-secondary mt-3">Kembali ke Daftar Tiket</a>

        <!-- Pilihan Pembayaran -->
        <div id="payment-status" class="mt-4 <?= $data['tiket']['status'] == 'belum_bayar' ? 'status-belum-bayar' : ($data['tiket']['status'] == 'sudah_bayar' ? 'status-sudah-bayar' : 'status-digunakan') ?>">
            <form id="payment-form" class="<?= $data['tiket']['status'] == 'sudah_bayar' || $data['tiket']['status'] == 'digunakan' ? 'payment-form-hidden' : '' ?>">
                <h4 class="mt-4" id="payment-title">Pilih Metode Pembayaran</h4>
                <div class="mb-3">
                    <label class="form-label">Metode Pembayaran</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" value="qris" id="qris" required>
                        <label class="form-check-label" for="qris">QRIS</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="metode_pembayaran" value="transfer bank" id="transfer-bank" required>
                        <label class="form-check-label" for="transfer-bank">Transfer Bank</label>
                    </div>
                </div>

                <!-- Tombol Konfirmasi -->
                <button type="submit" class="btn btn-primary">Konfirmasi Pembayaran</button>
            </form>
        </div>

        <!-- Modal untuk pembayaran QRIS atau Transfer Bank -->
        <div class="modal" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Konfirmasi Pembayaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="payment-details">
                        <!-- QRIS / Transfer Bank Details will be shown here -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="confirm-payment">OK</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Menambahkan Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
    <script>
        // Form submit handling
        document.getElementById('payment-form').addEventListener('submit', function(event) {
            event.preventDefault();

            const metodePembayaran = document.querySelector('input[name="metode_pembayaran"]:checked').value;
            const tiketId = <?= $data['tiket']['id']; ?>;

            // Show the modal with appropriate payment details
            let paymentDetails = '';
            if (metodePembayaran === 'qris') {
                paymentDetails = '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRXqBerNvdlpmXuvzh4DHJ4yBO9xf99Vc8_gg&s" alt="QRIS Code" />'; // Use real QR code here
            } else if (metodePembayaran === 'transfer bank') {
                paymentDetails = '<p>Nomor Virtual Akun: 1234567890</p>';
            }

            document.getElementById('payment-details').innerHTML = paymentDetails;

            // Show the modal
            const paymentModal = new bootstrap.Modal(document.getElementById('paymentModal'));
            paymentModal.show();

            // Handle confirm payment
            document.getElementById('confirm-payment').addEventListener('click', function() {
                // Update payment status (use AJAX or form submit to update status)
                fetch('index.php?url=tiket/updateStatusPembayaran', {
                    method: 'POST',
                    body: new URLSearchParams({
                        tiket_id: tiketId,
                        metode_pembayaran: metodePembayaran
                    })
                }).then(response => response.text()).then(data => {
                    // Change background color and hide payment form
                    document.body.classList.remove('status-belum-bayar');
                    document.body.classList.add('status-sudah-bayar');
                    document.getElementById('payment-form').classList.add('payment-form-hidden'); // Hide payment form
                    document.getElementById('payment-title').style.display = 'none'; // Hide the title text
                    alert('Pembayaran berhasil.');
                    location.reload(); // Refresh the page to show updated status
                });
            });
        });
    </script>
</body>

</html>