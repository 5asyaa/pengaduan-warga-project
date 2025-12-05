<?php

class Pengaduan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /* =========================
     * ADMIN
     * ========================= */

    // Dashboard admin – semua pengaduan
    public function getAll()
    {
        $stmt = $this->pdo->query("
            SELECT p.*, u.nama AS nama_user
            FROM pengaduan p
            JOIN users u ON p.user_id = u.id
            ORDER BY p.created_at ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Detail untuk admin
    public function findById($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT p.*, u.nama, u.email
            FROM pengaduan p
            JOIN users u ON p.user_id = u.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Foto berdasarkan tipe: 'awal' / 'penyelesaian'
    public function getFotoByType($pengaduan_id, $type)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pengaduan_foto
            WHERE pengaduan_id = ? AND tipe = ?
        ");
        $stmt->execute([$pengaduan_id, $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Update status pengaduan (menunggu/proses/ditolak/selesai)
    public function updateStatus($id, $status)
    {
        $stmt = $this->pdo->prepare("UPDATE pengaduan SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // Tambah foto bukti awal (user)
    public function addFotoAwal($pengaduan_id, $filename, $uploaded_by)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pengaduan_foto (pengaduan_id, file_path, tipe, uploaded_by)
            VALUES (?, ?, 'awal', ?)
        ");
        $stmt->execute([$pengaduan_id, $filename, $uploaded_by]);
    }

    // Tambah foto bukti penyelesaian (admin)
    public function addFotoSelesai($pengaduan_id, $filename, $uploaded_by)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pengaduan_foto (pengaduan_id, file_path, tipe, uploaded_by)
            VALUES (?, ?, 'penyelesaian', ?)
        ");
        $stmt->execute([$pengaduan_id, $filename, $uploaded_by]);
    }

    /* =========================
     * USER
     * ========================= */

    public function getByUserId($user_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pengaduan
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdForUser($id, $user_id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pengaduan
            WHERE id = ? AND user_id = ?
        ");
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPengaduan($user_id, $deskripsi, $lokasi, $identitas)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pengaduan (user_id, deskripsi, lokasi, identitas)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->execute([$user_id, $deskripsi, $lokasi, $identitas]);
        return $this->pdo->lastInsertId();
    }

    public function deletePengaduan($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pengaduan WHERE id = ?");
        $stmt->execute([$id]);
    }

    /* =========================
     * VALIDASI FOTO
     * ========================= */

    public function validasiFoto($nama, $size)
    {
        $ext_valid = ['jpg', 'jpeg', 'png'];
        $ext = strtolower(pathinfo($nama, PATHINFO_EXTENSION));

        if (!in_array($ext, $ext_valid)) {
            return "Format foto harus JPG atau PNG!";
        }

        // Maksimal 5MB
        if ($size > 5 * 1024 * 1024) {
            return "Ukuran foto maksimal 5MB!";
        }

        return true;
    }

    public function saveAlasanTolak($id, $alasan)
    {
        $stmt = $this->pdo->prepare("
            UPDATE pengaduan 
            SET status = 'ditolak', alasan_penolakan = ?, updated_at = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([$alasan, $id]);
    }

    public function saveCatatanAdmin($id, $catatan)
    {
        $stmt = $this->pdo->prepare("
            UPDATE pengaduan 
            SET catatan_admin = ?, updated_at = NOW()
            WHERE id = ?
        ");
        return $stmt->execute([$catatan, $id]);
    }

}
