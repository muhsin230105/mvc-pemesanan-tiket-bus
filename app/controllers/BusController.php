<?php
// app/controllers/buscontroller.php
class BusController extends Controller
{
    public function index()
    {
        $busModel = $this->model('Bus');
        $data['bus'] = $busModel->getAllBus();
        $this->view('bus/index', $data);
    }
    public function detail($id)
    {
        if (!is_numeric($id)) {
            echo "ID tidak valid.";
            exit;
        }

        $busModel = $this->model('Bus');
        $data['title'] = 'Detail Bus';
        $data['bus'] = $busModel->getBusById($id);

        if (!$data['bus']) {
            echo "Bus tidak ditemukan.";
            exit;
        }
        $data['kursi_terisi'] = $busModel->getKursiTerisi($id);

        $this->view('bus/detail', $data);
    }
}
