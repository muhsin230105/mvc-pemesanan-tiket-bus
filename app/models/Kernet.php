<?php
// app/models/Kernet.php

class Kernet extends Model
{
    public function createScanLog($tiket_id, $kernet_id)
    {
        $this->query("SELECT id, status FROM tiket WHERE barcode = :barcode");
        $this->bind(':barcode', $tiket_id);
        $result = $this->single();

        if ($result) {

            if ($result['status'] == 'digunakan') {
                echo "Tiket sudah digunakan, tidak bisa diproses lagi.";
                return false;
            }


            $this->query("UPDATE tiket SET status = 'digunakan' WHERE id = :tiket_id");
            $this->bind(':tiket_id', $result['id']);
            $this->execute();


            $waktu_scan = date('Y-m-d H:i:s');
            $this->query("INSERT INTO scan_log (tiket_id, kernet_id, waktu_scan) VALUES (:tiket_id, :kernet_id, :waktu_scan)");
            $this->bind(':tiket_id', $result['id']);
            $this->bind(':kernet_id', $kernet_id);
            $this->bind(':waktu_scan', $waktu_scan);
            $this->execute();
            return true;
        } else {
            echo "Tiket tidak ditemukan.";
            return false;
        }
    }




    // Fungsi untuk mengambil semua data scan log dengan informasi lengkap tentang tiket, bus, dan status pembayaran
    public function getAllScans()
    {
        // Gabungkan data dari scan_log, tiket, dan bus
        $this->query("SELECT sl.tiket_id, sl.waktu_scan, t.bus_id, t.tanggal_pesan, t.status, b.asal, b.tujuan, b.jam
                      FROM scan_log sl
                      JOIN tiket t ON sl.tiket_id = t.id
                      LEFT JOIN bus b ON t.bus_id = b.id");

        return $this->resultSet(); // Mengambil semua hasil scan log dengan informasi terkait
    }

    // Fungsi untuk mengambil data scan berdasarkan tiket_id untuk melihat detailnya
    public function getScanByTiketId($tiket_id)
    {
        $this->query("SELECT sl.tiket_id, sl.waktu_scan, t.bus_id, t.tanggal_pesan, t.status, b.asal, b.tujuan, b.jam_berangkat
                      FROM scan_log sl
                      JOIN tiket t ON sl.tiket_id = t.id
                      LEFT JOIN bus b ON t.bus_id = b.id
                      WHERE sl.tiket_id = :tiket_id");

        $this->bind(':tiket_id', $tiket_id);
        return $this->single(); // Mengambil satu hasil berdasarkan tiket_id
    }
}
