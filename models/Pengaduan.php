<?php

class Pengaduan
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Ambil semua pengaduan untuk dashboard
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

    // Ambil pengaduan berdasarkan ID
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

    // Ambil foto bukti awal
    public function getFotoAwal($id)
    {
        $stmt = $this->pdo->prepare("
            SELECT * FROM pengaduan_foto
            WHERE pengaduan_id = ? AND tipe = 'awal'
        ");
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserId($user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pengaduan WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByIdForUser($id, $user_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pengaduan WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $user_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFotoByType($pengaduan_id, $type)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM pengaduan_foto WHERE pengaduan_id = ? AND tipe = ?");
        $stmt->execute([$pengaduan_id, $type]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createPengaduan($user_id, $deskripsi, $lokasi, $identitas)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pengaduan (user_id, deskripsi, lokasi, identitas)
            VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $deskripsi, $lokasi, $identitas]);
        return $this->pdo->lastInsertId();
    }

    public function addFotoAwal($pengaduan_id, $filename, $uploaded_by)
    {
        $stmt = $this->pdo->prepare("
            INSERT INTO pengaduan_foto (pengaduan_id, file_path, tipe, uploaded_by)
            VALUES (?, ?, 'awal', ?)");
        $stmt->execute([$pengaduan_id, $filename, $uploaded_by]);
    }

    public function deletePengaduan($id)
    {
        $stmt = $this->pdo->prepare("DELETE FROM pengaduan WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function validasiFoto($nama, $size)
    {
        $ext_valid = ['jpg', 'jpeg', 'png'];

        $ext = strtolower(pathinfo($nama, PATHINFO_EXTENSION));
        if (!in_array($ext, $ext_valid)) {
            return "Format foto harus JPG atau PNG!";
        }

        // Batas 5MB
        if ($size > 5 * 1024 * 1024) {
            return "Ukuran foto maksimal 5MB!";
        }

        return true; // valid
    }


}
