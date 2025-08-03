<?php
// app/controllers/AdminController.php
class AdminController extends Controller
{
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

    public function __construct()
    {
        requireLogin('admin');
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

    // -------------------------------------------------------------

    public function users()
    {
        $userModel = $this->model('User');
        $data['users'] = $userModel->getAllUsers();
        $this->view('admin/users/index', $data);
    }

    public function tambahUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = $this->model('User');

            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $userModel->insertUser([
                'nama'     => $_POST['nama'],
                'email'    => $_POST['email'],
                'password' => $password,
                'no_hp'    => $_POST['no_hp'],
                'role'     => $_POST['role']
            ]);

            header('Location: index.php?url=admin/users');
            exit;
        }

        $this->view('admin/users/create');
    }

    public function editUser($id)
    {
        $userModel = $this->model('User');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama     = $_POST['nama'];
            $email    = $_POST['email'];
            $password = !empty($_POST['password'])
                ? password_hash($_POST['password'], PASSWORD_DEFAULT)
                : null;

            $userModel->updateUserByAdmin(
                $id,
                $_POST['nama'],
                $_POST['email'],
                !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null,
                $_POST['no_hp'],
                $_POST['role']
            );

            header('Location: index.php?url=admin/users');
            exit;
        }

        $data['user'] = $userModel->getUserById($id);
        $this->view('admin/users/edit', $data);
    }

    public function hapusUser($id)
    {
        $userModel = $this->model('User');
        try {
            $userModel->deleteUser($id);
        } catch (PDOException $e) {
            echo "<script>alert('Gagal menghapus. User ini memiliki tiket aktif!'); window.location.href='index.php?url=admin/users';</script>";
            exit;
        }

        header("Location: index.php?url=admin/users");
        exit;
    }

    // -------------------------------------------------------------

    public function tiket()
    {
        $tiketModel = $this->model('Tiket');
        $data['tiket'] = $tiketModel->getAllTiketWithRelasi();
        $this->view('admin/tiket/index', $data);
    }

    public function ubahStatusTiket()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tiketModel = $this->model('Tiket');
            $id = $_POST['tiket_id'];
            $status = $_POST['status'];
            $metode = $_POST['metode_pembayaran'] ?? null;

            $tiketModel->updateStatusPembayaran($id, $status, $metode);
            header('Location: index.php?url=admin/tiket');
            exit;
        }
    }
}
