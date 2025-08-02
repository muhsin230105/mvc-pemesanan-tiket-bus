<?php
// app/models/Tiket.php
require_once __DIR__ . '/../core/Database.php';

class Tiket
{
    public function createTiketAndKursi($user_id, $bus_id, $tanggal, $kursi, $total_harga, $barcode)
    {
        // Simpan data tiket ke database
        $query = "INSERT INTO tiket (user_id, bus_id, tanggal_pesan, total_harga, barcode) 
                  VALUES (?, ?, ?, ?, ?)";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id, $bus_id, $tanggal, $total_harga, $barcode]);
        $tiket_id = $db->lastInsertId(); // Ambil ID tiket yang baru dibuat

        // Simpan data kursi yang dipilih
        foreach ($kursi as $nomor_kursi) {
            $kursi_query = "INSERT INTO kursi_tiket (tiket_id, nomor_kursi) VALUES (?, ?)";
            $stmt = $db->prepare($kursi_query);
            $stmt->execute([$tiket_id, $nomor_kursi]);
        }

        return $tiket_id;
    }

    public function getTiketById($tiket_id)
    {
        $query = "SELECT tiket.*, bus.asal, bus.tujuan, bus.jam, bus.kode_bus
              FROM tiket
              INNER JOIN bus ON tiket.bus_id = bus.id
              WHERE tiket.id = ?";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$tiket_id]);

        return $stmt->fetch();
    }

    public function hitungHarga($bus_id, $kursi)
    {
        // Ambil harga per kursi dari tabel bus
        $query = "SELECT harga_per_kursi FROM bus WHERE id = ?";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$bus_id]);
        $bus = $stmt->fetch();

        $harga_per_kursi = $bus['harga_per_kursi'];
        return count($kursi) * $harga_per_kursi;
    }

    public function updateStatusPembayaran($tiket_id, $status, $metode_pembayaran)
    {
        $query = "UPDATE tiket SET status = ?, metode_pembayaran = ? WHERE id = ?";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$status, $metode_pembayaran, $tiket_id]);
    }

    public function updateStatusScan($barcode, $status)
    {
        // Cari tiket berdasarkan barcode
        $query = "SELECT id FROM tiket WHERE barcode = ?";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$barcode]);
        $tiket = $stmt->fetch();

        if (!$tiket) {
            echo "Tiket dengan barcode $barcode tidak ditemukan.";
            exit;
        }

        // Dapatkan ID tiket dari hasil pencarian
        $tiket_id = $tiket['id'];

        // Setelah mendapatkan ID tiket, update status tiket
        $updateQuery = "UPDATE tiket SET status = ? WHERE id = ?";
        $updateStmt = $db->prepare($updateQuery);
        $updateStmt->execute([$status, $tiket_id]);

        // Simpan log scan untuk tiket yang sudah digunakan
        $insertQuery = "INSERT INTO scan_log (tiket_id, waktu_scan, kernet_id) VALUES (?, NOW(), ?)";
        $insertStmt = $db->prepare($insertQuery);
        $insertStmt->execute([$tiket_id, $_SESSION['user']['id']]);

        echo "Status tiket dengan ID $tiket_id berhasil diperbarui dan dicatat sebagai digunakan.";
    }


    // Menambahkan fungsi untuk mengambil tiket berdasarkan user_id
    public function getTiketByUserId($user_id)
    {
        $query = "SELECT * FROM tiket WHERE user_id = ?";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$user_id]);

        // Debugging - Periksa apakah query berhasil mengembalikan data
        if ($stmt->rowCount() == 0) {
            echo "Tidak ada tiket ditemukan untuk user_id $user_id.";
        }

        return $stmt->fetchAll(); // Mengembalikan semua tiket yang dipesan oleh pengguna
    }

    public function batalTiket($tiket_id)
    {
        // Hapus tiket berdasarkan tiket_id
        $query = "DELETE FROM tiket WHERE id = ?";
        $db = Database::getInstance();
        $stmt = $db->prepare($query);
        $stmt->execute([$tiket_id]);
    }

    public function getTiketCount()
    {
        $db = Database::getInstance();
        $query = "SELECT COUNT(*) as total FROM tiket WHERE status IN ('sudah_bayar', 'digunakan')";
        $stmt = $db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function getAllTiketWithRelasi()
    {
        $db = Database::getInstance();
        $query = "SELECT 
                tiket.*, 
                users.nama AS nama_user, 
                bus.kode_bus, 
                bus.asal, 
                bus.tujuan, 
                bus.tanggal, 
                bus.jam 
              FROM tiket
              LEFT JOIN users ON tiket.user_id = users.id
              LEFT JOIN bus ON tiket.bus_id = bus.id
              ORDER BY tiket.id DESC";
        $stmt = $db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
