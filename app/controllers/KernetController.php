<?php
// app/controllers/KernetController.php

class KernetController extends Controller
{
    public function index()
    {
        $kernetModel = $this->model('Kernet');

        // Memanggil fungsi yang benar untuk mengambil semua scan log
        $data['scan_log'] = $kernetModel->getAllScans();

        // Menampilkan halaman scan dengan data log scan
        $this->view('kernet/index', $data);
    }

    public function scanTiket()
    {
        // Proses saat tiket discan
        $tiket_id = $_POST['tiket_id'] ?? ''; // ID tiket dari input manual atau scan QR
        $kernet_id = $_SESSION['user']['id']; // Ambil ID kernet dari session

        $kernetModel = $this->model('Kernet');
        $result = $kernetModel->createScanLog($tiket_id, $kernet_id);

        if ($result) {
            echo "Tiket berhasil discan.";
        } else {
            echo "Tiket tidak ditemukan atau gagal discan.";
        }



        // Redirect atau tampilkan hasil sesuai kebutuhan
        header('Location: index.php?url=kernet/index');
        exit;
    }
}
