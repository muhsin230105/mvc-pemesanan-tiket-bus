<!-- app/views/bus/detail.php -->
<?php require_once __DIR__ . '/../layouts/header.php'; ?>
<h3>Layout Kursi Bus <?= $data['bus']['kode_bus']; ?></h3>

<!-- app/views/bus/detail.php -->
<form action="<?= BASE_URL; ?>/index.php?url=tiket/pesan" method="POST" id="formKursi">
    <input type="hidden" name="bus_id" value="<?= $data['bus']['id']; ?>">
    <input type="hidden" name="tanggal" value="<?= $data['bus']['tanggal']; ?>">
    <div class="bus-layout">
        <?php
        $bookedSeats = $data['kursi_terisi']; // array kursi yang sudah dipesan
        $leftSeats = [1, 2, 5, 6, 9, 10, 13, 14, 17, 18, 21, 22, 25, 26, 29, 30, 33, 34, 37, 39, 41, 42];
        $rightSeats = [3, 4, 7, 8, 11, 12, 15, 16, 19, 20, 23, 24, 27, 28, 31, 32, 35, 36, 38, 40, 43];
        $totalSeats = 43;

        for ($i = 0; $i < 11; $i++) {
            echo '<div class="row-seat">';

            // Kursi kiri
            $left1 = $leftSeats[$i * 2] ?? null;
            $left2 = $leftSeats[$i * 2 + 1] ?? null;

            foreach ([$left1, $left2] as $seat) {
                if ($seat !== null) {
                    $isBooked = in_array($seat, $bookedSeats);
                    $class = $isBooked ? 'seat booked' : 'seat';
                    $disabled = $isBooked ? 'disabled' : '';
                    echo "<div class='$class' data-seat='$seat'>$seat</div>";
                } else {
                    echo "<div class='seat' style='visibility:hidden'></div>";
                }
            }

            echo "<div style='width: 40px;'></div>"; // lorong

            // Kursi kanan
            $right1 = $rightSeats[$i * 2] ?? null;
            $right2 = $rightSeats[$i * 2 + 1] ?? null;

            foreach ([$right1, $right2] as $seat) {
                if ($seat !== null) {
                    $isBooked = in_array($seat, $bookedSeats);
                    $class = $isBooked ? 'seat booked' : 'seat';
                    $disabled = $isBooked ? 'disabled' : '';
                    echo "<div class='$class' data-seat='$seat'>$seat</div>";
                } else {
                    echo "<div class='seat' style='visibility:hidden'></div>";
                }
            }

            echo '</div>';
        }
        ?>
    </div>

    <input type="hidden" name="kursi[]" id="kursiTerpilih">
    <p>Jumlah kursi kosong: <strong><?= $totalSeats - count($bookedSeats); ?></strong></p>
    <button type="submit" class="btn btn-primary mt-3">Pesan Sekarang</button>
</form>


<script>
    const kursiTerpilih = new Set();
    const kursiInput = document.getElementById('kursiTerpilih');

    document.querySelectorAll('.seat:not(.booked)').forEach(seat => {
        seat.addEventListener('click', () => {
            const nomor = seat.dataset.seat;
            if (kursiTerpilih.has(nomor)) {
                kursiTerpilih.delete(nomor);
                seat.classList.remove('selected');
            } else {
                kursiTerpilih.add(nomor);
                seat.classList.add('selected');
            }
            kursiInput.value = Array.from(kursiTerpilih); // Mengirimkan daftar kursi yang dipilih
        });
    });

    document.getElementById('formKursi').addEventListener('submit', (e) => {
        if (kursiTerpilih.size === 0) {
            alert("Silakan pilih kursi terlebih dahulu.");
            e.preventDefault(); // Mencegah form disubmit jika kursi belum dipilih
        } else {
            console.log("Data yang dikirim:", Array.from(kursiTerpilih));
        }
    });
</script>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>