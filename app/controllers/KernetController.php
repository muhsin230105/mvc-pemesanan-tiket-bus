<?php
// app/controllers/KernetController.php

class KernetController extends Controller
{
    public function index()
    {
        requireLogin('kernet');
        $kernetModel = $this->model('Kernet');
        $data['scan_log'] = $kernetModel->getAllScans();
        $this->view('kernet/index', $data);
    }

    public function scanTiket()
    {
        $tiket_id = $_POST['tiket_id'] ?? '';
        $kernet_id = $_SESSION['user']['id'];

        $kernetModel = $this->model('Kernet');
        $result = $kernetModel->createScanLog($tiket_id, $kernet_id);

        if ($result) {
            echo "Tiket berhasil discan.";
        } else {
            echo "Tiket tidak ditemukan atau gagal discan.";
        }

        header('Location: index.php?url=kernet/index');
        exit;
    }
}
