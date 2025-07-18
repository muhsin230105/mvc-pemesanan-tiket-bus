<?php
// app/controllers/buscontroller.php
class BusController extends Controller
{
    public function detail($id)
    {
        // Validasi ID
        if (!is_numeric($id)) {
            echo "ID tidak valid.";
            exit;
        }

        $busModel = $this->model('Bus');
        $data['title'] = 'Detail Bus';
        $data['bus'] = $busModel->getBusById($id);

        // Jika bus tidak ditemukan
        if (!$data['bus']) {
            echo "Bus tidak ditemukan.";
            exit;
        }

        // Ambil kursi yang sudah dipesan
        $data['kursi_terisi'] = $busModel->getKursiTerisi($id);

        $this->view('bus/detail', $data);
    }
}
