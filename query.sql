-- ========================================================
-- 1. CREATE DATABASE
-- ========================================================
CREATE DATABASE IF NOT EXISTS pengaduan_warga;
 


USE pengaduan_warga;

-- ========================================================
-- 2. TABLE: users
-- ========================================================
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- 3. TABLE: pengaduan
-- ========================================================
CREATE TABLE `pengaduan` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `deskripsi` text NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `identitas` enum('nama','anonim') DEFAULT 'nama',
  `status` enum('menunggu','proses','ditolak','selesai') DEFAULT 'menunggu',
  `alasan_penolakan` text DEFAULT NULL,
  `catatan_admin` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_pengaduan_user`
     FOREIGN KEY (`user_id`)
     REFERENCES `users` (`id`)
     ON DELETE CASCADE
     ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- 4. TABLE: pengaduan_foto
-- ========================================================
CREATE TABLE `pengaduan_foto` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pengaduan_id` int NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `tipe` enum('awal','penyelesaian') NOT NULL,
  `uploaded_by` int DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pengaduan_id` (`pengaduan_id`),
  KEY `uploaded_by` (`uploaded_by`),
  CONSTRAINT `fk_foto_pengaduan`
     FOREIGN KEY (`pengaduan_id`)
     REFERENCES `pengaduan` (`id`)
     ON DELETE CASCADE
     ON UPDATE CASCADE,
  CONSTRAINT `fk_foto_user`
     FOREIGN KEY (`uploaded_by`)
     REFERENCES `users` (`id`)
     ON DELETE SET NULL
     ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- 5. TABLE: riwayat_status
-- ========================================================
CREATE TABLE `riwayat_status` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pengaduan_id` int NOT NULL,
  `status_lama` varchar(50) DEFAULT NULL,
  `status_baru` varchar(50) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `pengaduan_id` (`pengaduan_id`),
  CONSTRAINT `fk_riwayat_pengaduan`
     FOREIGN KEY (`pengaduan_id`)
     REFERENCES `pengaduan` (`id`)
     ON DELETE CASCADE
     ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ========================================================
-- DONE
-- Database pengaduan_warga siap digunakan
-- ========================================================
