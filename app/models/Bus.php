<?php
// app/models/Bus.php
class Bus extends Model
{
    // Di model Bus.php
    public function getTerminalList()
    {
        $stmt = $this->db->query("SELECT DISTINCT asal FROM bus UNION SELECT DISTINCT tujuan FROM bus");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getAllBus()
    {
        $tanggalHariIni = date('Y-m-d');
        $stmt = $this->db->prepare("SELECT * FROM bus WHERE tanggal >= ?");
        $stmt->execute([$tanggalHariIni]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function cariBus($asal, $tujuan, $tanggal)
    {
        $sql = "SELECT 
                bus.*, 
                (bus.jumlah_kursi - 
                    COALESCE((
                        SELECT COUNT(*) 
                        FROM kursi_tiket kt
                        JOIN tiket t ON kt.tiket_id = t.id
                        WHERE t.bus_id = bus.id
                    ), 0)
                ) AS sisa_kursi
            FROM bus
            WHERE asal LIKE ? AND tujuan LIKE ? AND tanggal = ?";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(["%$asal%", "%$tujuan%", $tanggal]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM bus WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getKursiTerisi($bus_id)
    {
        $sql = "SELECT kt.nomor_kursi 
            FROM kursi_tiket kt
            JOIN tiket t ON kt.tiket_id = t.id
            WHERE t.bus_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$bus_id]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN); // ambil array nomor_kursi
    }
}
