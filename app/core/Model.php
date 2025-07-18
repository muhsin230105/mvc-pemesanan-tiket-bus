
<?php
// app/core/Model.php

class Model
{
    protected $db;
    protected $stmt;

    public function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=appbus;charset=utf8';
        $user = 'root';
        $pass = ''; // sesuaikan kalau kamu pakai password

        try {
            $this->db = new PDO($dsn, $user, $pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Koneksi DB gagal: ' . $e->getMessage());
        }
    }

    public function execute()
    {
        // Eksekusi query yang telah dipersiapkan
        return $this->stmt->execute();
    }

    public function query($sql)
    {
        $this->stmt = $this->db->prepare($sql);
    }

    public function bind($param, $value)
    {
        $this->stmt->bindValue($param, $value);
    }

    public function single()
    {
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function resultSet()
    {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
