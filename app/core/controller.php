<?php
// app/core/controler.php
class Controller
{
    public function model($model)
    {
        require_once __DIR__ . '/../models/' . $model . '.php';
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
