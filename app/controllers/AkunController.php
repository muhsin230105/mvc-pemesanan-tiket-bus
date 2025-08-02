<?php
// app/controllers/AkunController.php

class AkunController extends Controller
{
    public function index()
    {
        requireLogin();
        $userModel = $this->model('User');
        $user_id = $_SESSION['user']['id'];
        $data['user'] = $userModel->getUserById($user_id);

        if (isset($_SESSION['success_message'])) {
            $data['success_message'] = $_SESSION['success_message'];
            unset($_SESSION['success_message']);
        }

        $this->view('home/akun', $data);
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = $_SESSION['user']['id'];
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = $_POST['password'] ?? '';

            // Validasi input data (contoh: cek email valid)
            if (empty($nama) || empty($email)) {
                echo "Nama dan Email tidak boleh kosong!";
                exit;
            }

            // Jika password diisi, hash dan update
            if (!empty($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT); // Hash password sebelum menyimpannya
            }

            // Update data pengguna
            $userModel = $this->model('User');
            $userModel->updateUser($user_id, $nama, $email, $password);

            // Setelah berhasil, update session dengan data baru
            $_SESSION['user']['nama'] = $nama;
            $_SESSION['user']['email'] = $email;

            // Menyimpan pesan sukses ke session
            $_SESSION['success_message'] = "Profil berhasil diperbarui.";

            // Redirect kembali ke halaman akun setelah update berhasil
            header('Location: index.php?url=akun');  // Pastikan URL sesuai dengan route yang benar
            exit;
        }
    }
}
