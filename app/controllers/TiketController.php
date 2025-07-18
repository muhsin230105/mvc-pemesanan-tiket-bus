<?php
// app/controllers/TiketController.php
class TiketController extends Controller
{

    public function index() {}
    public function pesan()
    {
        if (!isset($_SESSION['user'])) {
            // Jika pengguna belum login, redirect ke halaman login
            header('Location: index.php?url=login');
            exit;
        }

        // Mengambil data dari form dan validasi input
        $bus_id = $_POST['bus_id'] ?? '';
        $tanggal = $_POST['tanggal'] ?? '';
        $kursi = $_POST['kursi'] ?? []; // Array nomor kursi yang dipilih

        if (empty($bus_id) || empty($tanggal) || empty($kursi)) {
            echo "Semua field harus diisi.";
            exit;
        }

        $user_id = $_SESSION['user']['id']; // ID pengguna yang login

        // Membuat instance model Tiket
        $tiketModel = $this->model('Tiket');

        // Hitung total harga tiket dengan mengambil harga per kursi dari model
        $total_harga = $tiketModel->hitungHarga($bus_id, $kursi);

        // Buat barcode unik untuk tiket
        $barcode = uniqid("TIKET");

        try {
            // Memanggil fungsi untuk membuat tiket dan kursi
            $tiket_id = $tiketModel->createTiketAndKursi($user_id, $bus_id, $tanggal, $kursi, $total_harga, $barcode);

            // Setelah berhasil, redirect atau tampilkan pesan sukses
            header('Location: index.php?url=tiket/konfirmasi&id=' . $tiket_id);
            exit;
        } catch (Exception $e) {
            echo "Terjadi kesalahan: " . $e->getMessage();
            exit;
        }
    }
    // Metode untuk menampilkan rincian pemesanan tiket
    public function konfirmasi()
    {
        $tiket_id = $_GET['id'] ?? null; // Ambil ID tiket dari URL

        if (!$tiket_id) {
            echo "Tiket tidak ditemukan.";
            exit;
        }

        // Mengambil data tiket berdasarkan ID
        $tiketModel = $this->model('Tiket');
        $data['tiket'] = $tiketModel->getTiketById($tiket_id);

        if (!$data['tiket']) {
            echo "Tiket tidak ditemukan.";
            exit;
        }

        // Menampilkan halaman konfirmasi dengan rincian tiket
        $this->view('tiket/konfirmasi', $data);
    }

    public function batal($tiket_id)
    {
        // Pastikan pengguna sudah login
        if (!isset($_SESSION['user'])) {
            header('Location: index.php?url=login');
            exit;
        }

        // Membuat instance model Tiket
        $tiketModel = $this->model('Tiket');

        // Membatalkan tiket dengan ID yang diberikan
        $tiketModel->batalTiket($tiket_id);

        header('Location: index.php?url=tiket/listTiket');
        exit;
    }

    public function detail()
    {
        $tiket_id = $_GET['id'] ?? null; // Ambil ID tiket dari URL

        if (!$tiket_id) {
            echo "Tiket tidak ditemukan.";
            exit;
        }

        // Ambil data tiket berdasarkan ID
        $tiketModel = $this->model('Tiket');
        $data['tiket'] = $tiketModel->getTiketById($tiket_id);

        if (!$data['tiket']) {
            echo "Tiket tidak ditemukan.";
            exit;
        }

        // Menampilkan halaman detail tiket
        $this->view('tiket/konfirmasi', $data);  // Arahkan ke halaman konfirmasi untuk detail tiket
    }


    public function listTiket()
    {
        if (!isset($_SESSION['user'])) {
            // Jika pengguna belum login, redirect ke halaman login
            header('Location: index.php?url=login');
            exit;
        }

        $user_id = $_SESSION['user']['id']; // Ambil ID pengguna yang login

        // Membuat instance model Tiket
        $tiketModel = $this->model('Tiket');

        // Mengambil semua tiket yang sudah dipesan oleh pengguna
        $data['tiket_list'] = $tiketModel->getTiketByUserId($user_id);
        // Menampilkan halaman daftar tiket dengan benar
        $this->view('home/listtiket', $data);  // Memastikan kita memanggil 'listtiket'
    }



    public function updateStatusPembayaran()
    {
        $tiket_id = $_POST['tiket_id'] ?? null;
        $metode_pembayaran = $_POST['metode_pembayaran'] ?? null;
        $status = 'sudah_bayar'; // Status pembayaran sudah dibayar

        if (!$tiket_id || !$metode_pembayaran) {
            echo "Data tidak lengkap.";
            exit;
        }

        // Update status pembayaran tiket
        $tiketModel = $this->model('Tiket');
        $tiketModel->updateStatusPembayaran($tiket_id, $status, $metode_pembayaran);

        echo "Status pembayaran berhasil diperbarui.";
    }
}
