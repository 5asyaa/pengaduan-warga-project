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
}
