<!-- app/controllers/LoginControler.php -->
<?php

class LoginController extends Controller
{
    public function index()
    {
        $this->view('auth/login');
    }

    public function proses()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        $userModel = $this->model('User');
        $user = $userModel->findByEmail($email);

        // Cek apakah user ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            // Set session user
            $_SESSION['user'] = [
                'id' => $user['id'],
                'nama' => $user['nama'],
                'email' => $user['email'],
                'role' => $user['role']
            ];

            // Redirect berdasarkan role
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
