<?php
// /puclic/index.php
session_start();

// Load config dan core utama
require_once __DIR__ . '/../app/core/helper.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../app/core/Controller.php';
require_once __DIR__ . '/../app/core/Model.php';
require_once __DIR__ . '/../app/core/App.php';

// Autoload controller & model
spl_autoload_register(function ($class) {
    $controllerPath = __DIR__ . "/../app/controllers/$class.php";
    $modelPath = __DIR__ . "/../app/models/$class.php";

    if (file_exists($controllerPath)) {
        require_once $controllerPath;
    } elseif (file_exists($modelPath)) {
        require_once $modelPath;
    }
});



// Jalankan aplikasi
$app = new App();
