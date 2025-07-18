<?php
// app/core/Database.php
class Database
{
    private static $instance;
    private $pdo;

    // Membuat koneksi database
    private function __construct()
    {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=appbus', 'root', '');  // Sesuaikan dengan konfigurasi DB Anda
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Koneksi gagal: " . $e->getMessage();
        }
    }

    // Mengembalikan instance koneksi database
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
