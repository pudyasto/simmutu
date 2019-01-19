ALTER TABLE `m_indikator` 
ADD COLUMN `stat` ENUM('Aktif', 'Tidak') NOT NULL DEFAULT 'Aktif' AFTER `nama_pj`;
