<?php
// app/core/App.php
class App
{
    protected $controller = 'HomeController';
    protected $method = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->parseURL();
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]);
            } else {
                echo "Controller $controllerName tidak ditemukan.";
                exit;
            }
        }
        require_once realpath(__DIR__ . '/../controllers/' . $this->controller . '.php');
        $controllerInstance = new $this->controller;

        if (isset($url[1])) {
            if (method_exists($controllerInstance, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            } else {
                echo "Method {$url[1]} tidak ditemukan dalam controller {$this->controller}.";
                exit;
            }
        }

        $this->params = $url ? array_values($url) : [];

        if (method_exists($controllerInstance, $this->method)) {
            call_user_func_array([$controllerInstance, $this->method], $this->params);
        } else {
            echo "Metode {$this->method} tidak ditemukan.";
            exit;
        }
    }

    // Parse URL untuk mendapatkan controller, method, dan params
    public function parseURL()
    {
        if (isset($_GET['url'])) {
            // Menghapus query string jika ada dan menanggalkan trailing slash
            return explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
        }
        return ['home']; // Default controller jika URL tidak ada
    }

    public function view($view, $data = [])
    {
        // Debugging untuk memeriksa path view yang dipanggil
        echo "Memuat view: $view<br>";

        require_once '../app/views/' . $view . '.php';  // Pastikan path ke view benar
    }
}
