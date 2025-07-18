<?php
// app/controllers/AdminController.php
class AdminController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya admin yang bisa mengakses halaman ini
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Anda tidak memiliki akses ke halaman ini.";
            exit;
        }
    }

    public function index()
    {
        // Menampilkan halaman dashboard admin
        $this->view('admin/dashboard');
    }
}
