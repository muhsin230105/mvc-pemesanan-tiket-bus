<?php
// app/controllers/homecontroler.php
class HomeController extends Controller
{
    public function index()
    {
        requireLogin();
        if ($_SESSION['user']['role'] === 'kernet') {
            // Redirect kernet jika mencoba mengakses halaman home
            echo "<script>alert('Akses ditolak. Halaman ini hanya untuk admin dan pembeli.'); window.location.href='index.php';</script>";
            exit;
        }
        $busModel = $this->model('Bus');
        $data['title'] = 'Beranda';
        $data['bus'] = $busModel->getAllBus();
        $data['terminal'] = $busModel->getTerminalList(); // ← tambahkan baris ini
        $this->view('home/index', $data);
    }

    public function tiket()
    {
        // Logika untuk halaman tiket
        $data['title'] = 'Halaman Tiket';
        // Anda bisa menambahkan model atau data lain yang ingin ditampilkan di halaman tiket
        $this->view('home/tiket', $data);
    }

    public function akun()
    {
        // Logika untuk halaman akun saya
        $data['title'] = 'Akun Saya';
        // Anda bisa menambahkan model atau data lain yang ingin ditampilkan di halaman akun saya
        $this->view('home/akun', $data);
    }



    public function cari()
    {
        $asal = $_GET['asal'] ?? '';
        $tujuan = $_GET['tujuan'] ?? '';
        $tanggal = $_GET['tanggal'] ?? '';

        $busModel = $this->model('Bus');
        $data['title'] = 'Hasil Pencarian';
        $data['hasil'] = $busModel->cariBus($asal, $tujuan, $tanggal);
        $this->view('home/hasil', $data);
    }

    public function logout()
    {
        // Menghancurkan sesi pengguna untuk logout
        session_destroy();

        // Arahkan pengguna kembali ke halaman login
        header('Location: index.php?url=login');
        exit;
    }
}
