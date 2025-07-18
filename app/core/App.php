<?php
// app/core/App.php
class App
{
    protected $controller = 'HomeController';  // Controller default
    protected $method = 'index';              // Method default
    protected $params = [];                   // Params default

    public function __construct()
    {
        // Memparse URL untuk mendapatkan controller, method, dan params
        $url = $this->parseURL();
        // echo '<pre>';
        // print_r($url);  // Debugging untuk melihat parameter yang dikirim
        // echo '</pre>';
        // Tentukan controller
        if (isset($url[0])) {
            $controllerName = ucfirst($url[0]) . 'Controller';
            if (file_exists('../app/controllers/' . $controllerName . '.php')) {
                $this->controller = $controllerName;
                unset($url[0]); // Menghapus controller dari URL
            } else {
                // Controller tidak ditemukan, tampilkan error
                echo "Controller $controllerName tidak ditemukan.";
                exit;
            }
        }

        // Memastikan controller dimuat dengan benar
        require_once realpath(__DIR__ . '/../controllers/' . $this->controller . '.php');  // Memperbaiki path
        // Membuat instance objek controller
        $controllerInstance = new $this->controller;

        // Tentukan method
        if (isset($url[1])) {
            if (method_exists($controllerInstance, $url[1])) {
                $this->method = $url[1];
                unset($url[1]); // Menghapus method dari URL
            } else {
                // Method tidak ditemukan, arahkan ke method default atau error
                echo "Method {$url[1]} tidak ditemukan dalam controller {$this->controller}.";
                exit;
            }
        }

        // Menyusun params
        $this->params = $url ? array_values($url) : [];

        // Pastikan metode yang dimaksud ada dan bisa dipanggil
        if (method_exists($controllerInstance, $this->method)) {
            // Memanggil metode pada objek controller
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
