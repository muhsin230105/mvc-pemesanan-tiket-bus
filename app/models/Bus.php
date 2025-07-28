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

    public function insertBus($data)
    {
        $stmt = $this->db->prepare("INSERT INTO bus (kode_bus, asal, tujuan, tanggal, jam, jumlah_kursi, harga_per_kursi) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['kode_bus'],
            $data['asal'],
            $data['tujuan'],
            $data['tanggal'],
            $data['jam'],
            $data['jumlah_kursi'],
            $data['harga_per_kursi']
        ]);
    }

    public function updateBus($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE bus SET kode_bus = ?, asal = ?, tujuan = ?, tanggal = ?, jam = ?, jumlah_kursi = ?, harga_per_kursi = ? WHERE id = ?");
        $stmt->execute([
            $data['kode_bus'],
            $data['asal'],
            $data['tujuan'],
            $data['tanggal'],
            $data['jam'],
            $data['jumlah_kursi'],
            $data['harga_per_kursi'],
            $id
        ]);
    }

    public function deleteBus($id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM bus WHERE id = ?");
            $stmt->execute([$id]);
        } catch (PDOException $e) {
            echo "<script>alert('Gagal menghapus data. Bus ini masih digunakan di tiket!'); window.location.href='index.php?url=admin/bus';</script>";
            exit;
        }
    }
}
