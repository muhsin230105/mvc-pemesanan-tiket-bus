<!-- app/controllers/LoginControler.php -->
<?php

class LoginController extends Controller
{
    public function index()
    {
        $this->view('auth/login');
    }
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $no_hp = $_POST['no_hp'];

            $userModel = $this->model('User');

            // Optional: validasi email unik
            if ($userModel->findByEmail($email)) {
                echo "<script>alert('Email sudah digunakan!'); window.location.href='index.php?url=login';</script>";
                exit;
            }

            $userModel->insertUser([
                'nama' => $nama,
                'email' => $email,
                'password' => $password,
                'no_hp' => $no_hp,
                'role' => 'pembeli' // Default
            ]);

            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='index.php?url=login';</script>";
            exit;
        }
    }

    public function proses()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => $user['role']
            ];
            switch ($user['role']) {
                case 'admin':
                    header('Location: index.php?url=admin');
                    exit;
                case 'kernet':
                    header('Location: index.php?url=kernet/index'); // Redirect ke halaman kernet untuk scan tiket
                    exit;
                default:
                    header('Location: index.php'); // Redirect default
                    exit;
            }
        } else {
            echo "<script>alert('Email atau password salah!'); window.location.href='index.php?url=login';</script>";
        }
    }


    public function logout()
    {
        session_destroy();
        header('Location: index.php?url=login');
        exit;
    }
}
