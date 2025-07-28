<?php
// app/controllers/AdminController.php
// class AdminController extends Controller
// {
//     public function __construct()
//     {
//         // Pastikan hanya admin yang bisa mengakses halaman ini
//         if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
//             echo "Anda tidak memiliki akses ke halaman ini.";
//             exit;
//         }
//     }

//     public function index()
//     {
//         // Menampilkan halaman dashboard admin
//         $this->view('admin/dashboard');
//     }
// }

// app/controllers/AdminController.php

class AdminController extends Controller
{
    public function __construct()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            echo "Anda tidak memiliki akses ke halaman ini.";
            exit;
        }
    }

    public function index()
    {
        $busModel = $this->model('Bus');
        $userModel = $this->model('User');
        $tiketModel = $this->model('Tiket');

        $data['bus'] = $busModel->getAllBus();
        $data['totalBus'] = count($data['bus']);
        $data['totalUser'] = $userModel->getUserCount();
        $data['totalTiket'] = $tiketModel->getTiketCount();

        $this->view('admin/dashboard', $data);
    }

    public function bus()
    {
        $busModel = $this->model('Bus');
        $data['bus'] = $busModel->getAllBus();
        $this->view('admin/bus/index', $data);
    }

    public function tambahBus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $busModel = $this->model('Bus');
            $busModel->insertBus($_POST);
            header('Location: index.php?url=admin/bus');
            exit;
        }
        $this->view('admin/bus/create');
    }

    public function editBus($id)
    {
        $busModel = $this->model('Bus');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $busModel->updateBus($id, $_POST);
            header('Location: index.php?url=admin/bus');
            exit;
        }

        $data['bus'] = $busModel->getBusById($id);
        $this->view('admin/bus/edit', $data);
    }

    public function hapusBus($id)
    {
        $busModel = $this->model('Bus');
        $busModel->deleteBus($id);
        header('Location: index.php?url=admin/bus');
        exit;
    }
}
