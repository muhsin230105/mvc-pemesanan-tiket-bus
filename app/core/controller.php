<!-- app/core/controler.php -->
<?php
abstract class Controller
{
    abstract public function index();
    public function model($model)
    {
        return new $model;
    }

    public function view($view, $data = [])
    {
        $url = $_GET['url'] ?? '';
        if (!isset($_SESSION['user']) && !in_array($url, ['login', 'register'])) {
            header('Location: index.php?url=login');
            exit;
        }

        require_once '../app/views/' . $view . '.php';
    }
}
