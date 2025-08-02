
<?php
// app/core/Model.php
class Model
{
    /**
     * @var PDO
     */
    protected $db;
    protected $stmt;

    public function __construct()
    {
        $this->db = Database::getInstance(); // ✅ gunakan instance tunggal
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
