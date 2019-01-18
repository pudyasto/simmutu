-- MySQL dump 10.13  Distrib 5.7.23, for Win32 (AMD64)
--
-- Host: localhost    Database: db_simmutu
-- ------------------------------------------------------
-- Server version	5.7.23

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'Administrator','IT Administrator'),(2,'Admin','Admin Umum');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups_access`
--

DROP TABLE IF EXISTS `groups_access`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups_access` (
  `group_id` mediumint(8) unsigned NOT NULL,
  `menu_id` mediumint(8) unsigned NOT NULL,
  `privilege` varchar(10) NOT NULL,
  UNIQUE KEY `uq_group_menu` (`group_id`,`menu_id`),
  KEY `fk_groups_access_1_idx` (`group_id`),
  KEY `fk_groups_access_2_idx` (`menu_id`),
  CONSTRAINT `groups_access_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `groups_access_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `menus` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups_access`
--

LOCK TABLES `groups_access` WRITE;
/*!40000 ALTER TABLE `groups_access` DISABLE KEYS */;
INSERT INTO `groups_access` VALUES (2,6,'1,1,1'),(2,7,'1,1,1'),(2,8,'1,1,1');
/*!40000 ALTER TABLE `groups_access` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(15) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_indikator`
--

DROP TABLE IF EXISTS `m_indikator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_indikator` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `jenis_id` int(11) NOT NULL,
  `urut` int(11) NOT NULL,
  `nama` text NOT NULL,
  `dimensi` text,
  `tujuan` text,
  `definisi` text,
  `inklusi` text,
  `eksklusi` text,
  `frekuensi` varchar(45) NOT NULL,
  `tipe_id` int(11) DEFAULT NULL,
  `periode_analisa` int(11) DEFAULT NULL,
  `num` text,
  `denum` text,
  `sumber_data` varchar(200) DEFAULT NULL,
  `standar` varchar(100) NOT NULL,
  `nama_pj` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `m_indikator_m_unit_fk` (`unit_id`),
  KEY `m_indikator_m_jenis_fk` (`jenis_id`),
  CONSTRAINT `m_indikator_m_jenis_fk` FOREIGN KEY (`jenis_id`) REFERENCES `m_jenis` (`id`),
  CONSTRAINT `m_indikator_m_unit_fk` FOREIGN KEY (`unit_id`) REFERENCES `m_unit` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=233 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_indikator`
--

LOCK TABLES `m_indikator` WRITE;
/*!40000 ALTER TABLE `m_indikator` DISABLE KEYS */;
INSERT INTO `m_indikator` VALUES (1,1,1,1,'Waktu tanggap pelayanan dokter di gawat darurat',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 5 menit',NULL),(2,1,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(3,1,2,2,'Emergency Response Time ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,' < 5 menit',NULL),(4,1,2,3,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(5,1,2,4,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(6,1,2,5,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(7,1,2,6,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(8,1,2,7,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(9,2,1,1,'Jumlah kunjungan sesuai dengan PPK ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'3 kali kunjungan',NULL),(10,2,1,2,'Perawatan Saluran Akar Ganda',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(11,2,1,3,'Kelengkapan assesmen medis ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(12,2,1,4,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(13,2,1,5,'Kelengakapan Alat Medis sesuai CP',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(14,2,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(15,2,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(16,2,2,3,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(17,2,2,4,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(18,2,2,5,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(19,2,2,6,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(20,2,2,7,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(21,3,1,1,'Kelengkapan assesmen medis awal pasien rawat jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(22,3,1,2,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1 Jam',NULL),(23,3,1,3,'Kelengkapan asesmen medis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(24,3,1,4,'Manajemen nyeri pasca operasi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 1 jam',NULL),(25,3,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(26,3,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(27,3,2,3,'Penundaan Operasi elektif Mayor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'2X24 jam',NULL),(28,3,2,4,'Penundaan Operasi elektif Minor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1X24 jam',NULL),(29,3,2,5,'Kepatuhan jam visit spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Jam 8 pagi',NULL),(30,3,2,6,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(31,3,2,7,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(32,3,2,8,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(33,3,2,9,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(34,3,2,10,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(35,3,3,1,'Angka kelengkapan asesmen awal dokter di rawat jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(36,3,3,2,'Angka keterlambatan penyerahan hasil pemeriksaan foto radiologi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'5% (< 6 Jam)',NULL),(37,3,3,3,'Angka kelengkapan dokumen site marking',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(38,3,3,4,'Angka kelengkapan monitoring status fisiologis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(39,3,3,5,'Angka kelengkapan ringkasan rawat jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(40,3,3,6,'Angka kepatuhan cuci tangan dokter dan perawat',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(41,3,4,1,'Kepatuhan pemakaian APD',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(42,3,4,2,'Angka efektifitas penggunaan alat canggih (CBCT)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'6 Pasien /hari',NULL),(43,3,4,3,'Survei kepuasan pelayanan unit kerja yang melayani pasien bedah mulut',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'> 80 %',NULL),(44,3,4,4,'Survei kepuasan seluruh staff rumah sakit',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'> 80 %',NULL),(45,3,4,5,'Demografi pasien bedah mulut (wilayah , pendidikan, jenis kelamin, umur)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Ada',NULL),(46,3,4,6,'Survei kepuasan asuhan dokter, perawat, dan nakes lainnya',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'> 80%',NULL),(47,3,4,7,'Pola pemahaman staf dalam melaksanakan cara cuci tangan yang benar',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'> 80%',NULL),(48,3,5,1,'Kepatuhan pelaksanaan identifikasi sebelum tindakan bedah mulut',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(49,3,5,2,'Kelengkapan verifikasi the read back process',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(50,3,5,3,'Ketepatan label pada obat LASA',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(51,3,5,4,'Angka kelengkapan surgical safety checklist',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(52,3,5,5,'Kepatuhan cuci tangan oleh Dokter Gigi Muda (DGM)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(53,3,5,6,'Terpasangnya pita kuning pada pasien risiko jatuh',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(54,3,6,1,'Impaksi Gigi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(55,3,6,2,'Abses Maksilofasial',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(56,3,6,3,'Kista Rahang',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(57,3,6,4,'Tumor Jinak',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(58,3,6,5,'Neoplasma',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(59,4,1,1,'Kelengkapan alat medis (Restrain) pada anak berkebutuhan khusus',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(60,4,1,2,'Waktu pelaksanaan asesmen medis untuk anak',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'30 Menit',NULL),(61,4,1,3,'Kelengkapan assesmen medis awal pasien rawat jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(62,4,1,4,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(63,4,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(64,4,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(65,4,2,3,'Penundaan Operasi elektif Minor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1X24 jam',NULL),(66,4,2,4,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(67,4,2,5,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(68,4,2,6,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(69,4,2,7,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(70,4,2,8,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(71,5,1,1,'Kelengkapan assesmen medis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(72,5,1,2,'Ketersediaan alat (Alat Cetak dan MMR) dan bahan (Bahan Cetak)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(73,5,1,3,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(74,5,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(75,5,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(76,5,2,3,'Penundaan Operasi elektif Minor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1X24 jam',NULL),(77,5,2,4,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(78,5,2,5,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(79,5,2,6,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(80,5,2,7,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(81,5,2,8,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(82,6,1,1,'Kepatuhan pemakaian Alat Pelindung Diri (Penutup Kepala, Google, Masker, Handscoon, Gown)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(83,6,1,2,'Kelengkapan assesmen medis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(84,6,1,3,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(85,6,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(86,6,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(87,6,2,3,'Jam Visit Dokter Spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Jam 8 pagi',NULL),(88,6,2,4,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(89,6,2,5,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(90,6,2,6,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(91,6,2,7,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(92,6,2,8,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(93,7,1,1,'Kelengkapan assesmen medis ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(94,7,1,2,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(95,7,1,3,'Ketersediaan alat medis tindakan scalling',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(96,7,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(97,7,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(98,7,2,3,'Penundaan Operasi elektif Minor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1X24 jam',NULL),(99,7,2,4,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(100,7,2,5,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(101,7,2,6,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(102,7,2,7,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(103,7,2,8,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(104,8,1,1,'Kelengkapan assesmen medis ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(105,8,1,2,'Dokter pemberi pelayanan di poliklinik spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(106,8,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(107,8,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(108,8,2,3,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(109,8,2,4,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(110,8,2,5,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(111,8,2,6,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(112,8,2,7,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(113,9,1,1,'Kepatuhan terhadap identifikasi pasien : Survei pelaksanaan identifikasi sebelum tindakan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(114,9,1,2,'Kepatuhan komunikasi efektif : Pemahaman staf terhadap read back process',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(115,9,1,3,'Peningkatan keamanan obat high alert : Kejadian tidak adanya label high alert pada obat high alert di unit kerja',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(116,9,1,4,'Kepastian tepat lokasi dan prosedur : Kejadian ketidaklengkapan penandaan lokasi foto radiografik.',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(117,9,1,5,'Kepastian tepat lokasi dan prosedur : Angka ketidaklengkapan surgical safety check list',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(118,9,1,6,'Pengurangan risiko infeksi terkait pelayanan kesehatan : Kepatuhan cuci tangan oleh Supervisor, perawat, dan ko-ass (nasional)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(119,9,1,7,'Pengurangan risiko jatuh : Kejadian tidak terpasangnya pita kuning pada pasien risiko jatuh (nasional)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(120,9,1,8,'Kehadiran Supervisor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(121,9,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(122,9,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 5 menit',NULL),(123,9,2,3,'Penundaan Operasi elektif Minor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1X24 jam',NULL),(124,9,2,4,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(125,9,2,5,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(126,9,2,6,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(127,9,2,7,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(128,9,2,8,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(129,10,1,1,'Pelaksanaan ekspertisi oleh Sp. Rad OM (CBCT)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1 X 24 Jam',NULL),(130,10,1,2,'Kejadian kegagalan pelayanan rontgen',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Kerusakan foto < 2%',NULL),(131,10,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(132,10,2,2,'Waktu Tunggu ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(133,10,2,3,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(134,10,2,4,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(135,10,2,5,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(136,11,1,1,'Pelaksaan ekspertisi oleh Sp.PK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Dokter Sp.PK',NULL),(137,11,1,2,'Kerusakan sampel Lab. (Darah Lisis)',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'0',NULL),(138,11,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(139,11,2,2,'Waktu Tunggu hasil pemeriksaan darah rutin',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 4 jam',NULL),(140,11,2,3,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(141,11,2,4,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(142,11,2,5,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(143,11,2,6,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(144,12,1,1,'Kelengkapan asesmen awal keperawatan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(145,12,1,2,'Ketepatan kehadiran Dokter Gigi Umum',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Shift Pagi 09:00 s/d 11:30 & Shift Siang 13:00 s/d 15:30',NULL),(146,12,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(147,12,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(148,12,2,3,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(149,12,2,4,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(150,12,2,5,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(151,12,2,6,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(152,12,2,7,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(153,13,1,1,'Penulisan resep sesuai telaah resep',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(154,13,1,2,'Ketersediaan obat dan dental material sesuai dengan formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(155,13,2,1,'Kepatuhan Identifikasi pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(156,13,2,2,'Waktu Tunggu ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Obat racikan < 30 menit; obat jadi < 15 menit',NULL),(157,13,2,3,'Kepatuhan penggunaan formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(158,13,2,4,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(159,13,2,5,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(160,13,2,6,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(161,13,2,7,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(162,14,1,1,'Kelengkapan catatan rekam medik 24 jam setelah pelayanan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(163,14,1,2,'Kelengkapan pengisian informed consent setelah mendapatkan informasi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(164,14,1,3,'Keterbacaan catatan rekam medis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(165,14,1,4,'Tidak terjadinya duplikasi nomor RM',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(166,14,1,5,'Penyimpanan RM sesuai penjajaran',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(167,14,2,1,'Kepatuhan identifikasi pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(168,14,2,2,'Waktu Tunggu',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Pasien baru < 10 menit; Pasien lama < 5 menit',NULL),(169,14,2,3,'Kecepatan respon terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(170,15,1,1,'Baku mutu limbah cair',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'BOD < 30 mg/l , COD < 80 mg/l , TSS < 30 mg/l ,  PH 6-9 ',NULL),(171,15,1,2,'Pengelolaan limbah padat infeksius sesuai dengan aturan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(172,16,1,1,'Tidak adanya kejadian linen yang hilang',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(173,16,1,2,'Ketepatan waktu pengembalian linen dari Instalasi Laundry RISA ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'2 Hari ',NULL),(174,17,1,1,'Kegiatan pencatatan dan pelaporan infeksi nosokomial / HAI (Health Care Associated Infection) di RS (min 1 parameter) ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(175,17,1,2,'Pemeliharaan kebersihan dental unit',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(176,17,1,3,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(177,17,1,4,'Kepatuhan pemakaian APD',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(178,18,1,2,'Ketepatan waktu pemeliharaan alat ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(179,18,2,1,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'<15 menit',NULL),(180,19,1,1,'Tindak lanjut penyelesaian hasil pertemuan direksi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(181,19,1,2,'Kelengkapan laporan akuntabilitas kinerja',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(182,19,2,1,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(183,20,1,1,'Ketiadaan kuman pada hasil pemeriksaan hand instruments',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'0%',NULL),(184,20,1,2,'Kepatuhan proses dalam sterilisasi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(185,20,1,3,'Re-circulation instrumen',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(186,20,1,4,'Pemakaian indicator internal sterilisasi dalam packing ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(187,20,1,5,'Kepatuhan pengiriman alat kotor dari unit ke CSSD',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Pagi : 08:30 & Siang : 13:00',NULL),(188,20,2,1,'Kepatuhan cuci tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(189,20,2,2,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(190,21,1,1,'Kepatuhan pemasangan gelang/pita kuning',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(191,21,1,2,'Waktu tunggu pelayanan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 30 menit',NULL),(192,21,2,1,'Ketepatan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(193,21,2,2,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(194,21,2,3,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(195,21,2,4,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(196,21,2,5,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(197,21,2,6,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(198,22,1,1,'Kelengkapan assesmen medis anastesi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(199,22,1,2,'Kelengkapan informed concern bedah',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(200,22,1,3,'Kelengkapan informed concern anastesi',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(201,22,1,4,'Kelengkapan persediaan bahan habis pakai ',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(202,22,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(203,22,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(204,22,2,3,'Penundaan Operasi elektif Mayor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'2X24 jam',NULL),(205,22,2,4,'Penundaan Operasi elektif Minor',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'1X24 jam',NULL),(206,22,2,5,'Kepatuhan jam visit spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Jam 8 pagi',NULL),(207,22,2,6,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(208,22,2,7,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(209,22,2,8,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(210,22,2,9,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(211,22,2,10,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(212,23,1,1,'Kepatuhan pemakaian APD oleh dokter dan pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(213,23,1,2,'Kepatuhan sterilisasi re-used instruments',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(214,23,1,3,'Kepatuhan dokter untuk melakukan konseling',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(215,23,2,1,'Kepatuhan Identifikasi Pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(216,23,2,2,'Waktu Tunggu Rawat Jalan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 60 menit',NULL),(217,23,2,3,'Jam Visit Dokter Spesialis',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'Jam 8 pagi',NULL),(218,23,2,4,'Kepatuhan Penggunaan Formularium',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'95%',NULL),(219,23,2,5,'Kepatuhan Cuci Tangan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(220,23,2,6,'Kepatuhan terhadap PPK',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(221,23,2,7,'Kepuasan Pasien dan Keluarga',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'80%',NULL),(222,23,2,8,'Kecepatan respons terhadap komplain',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 15 menit',NULL),(223,24,1,2,'Response time pelayanan ambulance oleh masyarakat yang membutuhkan',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'2 Jam ',NULL),(224,25,1,1,'Waktu pengerjaan Plat Aktif',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'5 Hari Kerja',NULL),(225,25,1,2,'Waktu pengerjaan galangan gigit',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'2 Hari Kerja',NULL),(226,25,1,3,'Ketersediaan anasir gigi sesuai dengan warna',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(227,25,2,1,'Kepatuhan identifikasi pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'100%',NULL),(228,25,2,2,'Waktu pengerjaan GTL',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'7 Hari Kerja',NULL),(229,25,2,3,'Waktu Pengerjaan GTC',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'5 Hari Kerja',NULL),(230,25,2,4,'Waktu Pengerjaan Boxing',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'2 Hari Kerja',NULL),(231,26,1,1,'Waktu lamanya transit jenazah',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'< 2 Jam',NULL),(232,27,1,1,'Ketepatan waktu pemberian makanan kepada pasien',NULL,NULL,NULL,NULL,NULL,'',NULL,NULL,NULL,NULL,NULL,'> 90%',NULL);
/*!40000 ALTER TABLE `m_indikator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_jenis`
--

DROP TABLE IF EXISTS `m_jenis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_jenis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_jenis`
--

LOCK TABLES `m_jenis` WRITE;
/*!40000 ALTER TABLE `m_jenis` DISABLE KEYS */;
INSERT INTO `m_jenis` VALUES (1,'Mutu Unit'),(2,'Mutu Nasional'),(3,'Mutu Prioritas Area Klinis'),(4,'Mutu Prioritas Area Manajemen'),(5,'Mutu Nasional Sasaran keselamatan pasien'),(6,'Kepatuhan Protokol Klinis');
/*!40000 ALTER TABLE `m_jenis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_tipe`
--

DROP TABLE IF EXISTS `m_tipe`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_tipe` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_tipe`
--

LOCK TABLES `m_tipe` WRITE;
/*!40000 ALTER TABLE `m_tipe` DISABLE KEYS */;
INSERT INTO `m_tipe` VALUES (1,'Input'),(2,'Process'),(3,'Outcome'),(4,'Outcome and Process');
/*!40000 ALTER TABLE `m_tipe` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_unit`
--

DROP TABLE IF EXISTS `m_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `m_unit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `stat` enum('Aktif','Tidak') NOT NULL DEFAULT 'Aktif',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_unit`
--

LOCK TABLES `m_unit` WRITE;
/*!40000 ALTER TABLE `m_unit` DISABLE KEYS */;
INSERT INTO `m_unit` VALUES (1,'UGD','Unit Gawat Darurat','Aktif'),(2,'Konservasi','','Aktif'),(3,'Bedah Mulut','','Aktif'),(4,'Kedokteran Gigi Anak','','Aktif'),(5,'Prostodonsia','','Aktif'),(6,'Ilmu Penyakit Mulut','','Aktif'),(7,'Periodonsia','','Aktif'),(8,'Ortodonsia','','Aktif'),(9,'Integrasi','','Aktif'),(10,'Radiologi','','Aktif'),(11,'Lab Klinik','','Aktif'),(12,'Oral Diagnostic','','Aktif'),(13,'Farmasi','','Aktif'),(14,'Rekam Medik','','Aktif'),(15,'Pengelolaan limbah','','Aktif'),(16,'Pelayanan Laundry ','','Aktif'),(17,'Pencegahan dan pengendalian infeksi (PPI) ','','Aktif'),(18,'IPSRS','','Aktif'),(19,'Administrasi umum dan keuangan','','Aktif'),(20,'Sterilisasi (CSSD)','','Aktif'),(21,'Geriatri','','Aktif'),(22,'Bedah Sentral','','Aktif'),(23,'Klinik (Infeksi HIV)','','Aktif'),(24,'Ambulance','','Aktif'),(25,'Laboratorium Teknik Gigi','','Aktif'),(26,'Transit Jenazah','','Aktif'),(27,'Instalasi Gizi (MoU)','','Aktif');
/*!40000 ALTER TABLE `m_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menus`
--

DROP TABLE IF EXISTS `menus`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menus` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `lang` varchar(2) NOT NULL DEFAULT 'id',
  `menuorder` mediumint(8) NOT NULL DEFAULT '0',
  `menu_name` varchar(50) NOT NULL,
  `description` varchar(100) DEFAULT NULL,
  `link` varchar(50) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `statmenu` mediumint(8) unsigned NOT NULL,
  `mainmenuid` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT INTO `menus` VALUES (1,'id',0,'Menu dan Pengguna','Manajemen menu dan pengguna aplikasi','#','group',1,NULL),(2,'id',0,'Menu','Manajemen menu aplikasi','menus','fa fa-bars',1,1),(3,'id',0,'Grup Pengguna','Manajemen grup pengguna','groups','fa fa-users',1,1),(4,'id',0,'Pengguna','Manajemen pengguna aplikasi','users','fa fa-user-plus',1,1),(5,'id',0,'Master Data','Manajemen master data','#','layers',1,NULL),(6,'id',0,'Unit Pelayanan','Master data unit pelayanan','m_unit','chevron_right',1,5),(7,'id',0,'Indikator Mutu','Master data indikator mutu','indikator','stars',1,NULL),(8,'id',0,'Tipe Indikator','Master data tipe indikator','m_tipe','chevron_right',1,5);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tmp_sessions`
--

DROP TABLE IF EXISTS `tmp_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tmp_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '	',
  `data` blob NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tmp_sessions`
--

LOCK TABLES `tmp_sessions` WRITE;
/*!40000 ALTER TABLE `tmp_sessions` DISABLE KEYS */;
INSERT INTO `tmp_sessions` VALUES ('0bguavobngi87f5rph5bgshet1dmsfjl','::1',1547802903,_binary '__ci_last_regenerate|i:1547802903;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547802900\";last_check|i:1547802903;name|s:13:\"Administrator\";groupid|s:1:\"1\";group_name|s:13:\"Administrator\";userid|s:1:\"1\";platform|s:10:\"Windows 10\";browser|s:19:\"Chrome 71.0.3578.98\";logged_in|b:1;log_tanggal|s:10:\"1547802903\";'),('19srmfq78vlepbniukrief3hmaudplts','::1',1547730504,_binary '__ci_last_regenerate|i:1547730504;'),('5iqupltb24srmkc3qml1h3eitnj31coe','::1',1547720351,_binary '__ci_last_regenerate|i:1547718913;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547639418\";last_check|i:1547687197;name|s:13:\"Administrator\";groupid|s:1:\"1\";group_name|s:13:\"Administrator\";userid|s:1:\"1\";platform|s:10:\"Windows 10\";browser|s:19:\"Chrome 71.0.3578.98\";logged_in|b:1;log_tanggal|s:10:\"1547687197\";'),('63c3q5tnm7t426pg90v41o6ej4ph9400','::1',1547794863,_binary '__ci_last_regenerate|i:1547794863;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547774211\";last_check|i:1547794863;'),('7hfgqod8n2evjujpeucrkroeup8ojd8l','::1',1547787062,_binary '__ci_last_regenerate|i:1547786857;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547728896\";last_check|i:1547774211;name|s:13:\"Administrator\";groupid|s:1:\"1\";group_name|s:13:\"Administrator\";userid|s:1:\"1\";platform|s:10:\"Windows 10\";browser|s:19:\"Chrome 71.0.3578.98\";logged_in|b:1;log_tanggal|s:10:\"1547774211\";'),('bh4rvtlfp26f8jj5q5bkv6o6r3cn2bb4','::1',1547783836,_binary '__ci_last_regenerate|i:1547783836;'),('cclb1t5te7dfnif17vlpjlicnjjk2ro7','::1',1547802868,_binary '__ci_last_regenerate|i:1547802868;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547794863\";last_check|i:1547802868;'),('gajo3lmu7jb1dsojn607eulb27ij7r00','::1',1547822307,_binary '__ci_last_regenerate|i:1547821240;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547802903\";last_check|i:1547815971;name|s:13:\"Administrator\";groupid|s:1:\"1\";group_name|s:13:\"Administrator\";userid|s:1:\"1\";platform|s:10:\"Windows 10\";browser|s:19:\"Chrome 71.0.3578.98\";logged_in|b:1;log_tanggal|s:10:\"1547815971\";'),('h5dbjf6cvv7r32iclf9vrn8i5vfhqh5f','::1',1547728896,_binary '__ci_last_regenerate|i:1547728896;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547687197\";last_check|i:1547728896;'),('jioqvo6k29fu1kbhr201d5nuh4c80a3o','::1',1547774211,_binary '__ci_last_regenerate|i:1547774211;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547728896\";last_check|i:1547774211;'),('karokhhfg2supcoms7fvp4l8cmd47l56','::1',1547802903,_binary '__ci_last_regenerate|i:1547802903;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547802900\";last_check|i:1547802903;'),('kcodo12ead927ioln8b7m07melglb96r','::1',1547798217,_binary '__ci_last_regenerate|i:1547796639;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547774211\";last_check|i:1547794863;name|s:13:\"Administrator\";groupid|s:1:\"1\";group_name|s:13:\"Administrator\";userid|s:1:\"1\";platform|s:10:\"Windows 10\";browser|s:19:\"Chrome 71.0.3578.98\";logged_in|b:1;log_tanggal|s:10:\"1547794863\";'),('lcl6f3aga552g9ml4jj7p8jest2pr5lh','::1',1547730527,_binary '__ci_last_regenerate|i:1547730504;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547687197\";last_check|i:1547728896;name|s:13:\"Administrator\";groupid|s:1:\"1\";group_name|s:13:\"Administrator\";userid|s:1:\"1\";platform|s:10:\"Windows 10\";browser|s:19:\"Chrome 71.0.3578.98\";logged_in|b:1;log_tanggal|s:10:\"1547728896\";'),('pi82q2eoevh04cq0ngg27aafe50pd6fm','::1',1547718913,_binary '__ci_last_regenerate|i:1547718913;'),('tktrfldrovgn5fogrt5fis35ps9vho8f','::1',1547802900,_binary '__ci_last_regenerate|i:1547802900;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547802868\";last_check|i:1547802900;'),('up3m83e8njiba596k150humtcdq0uo8l','::1',1547815971,_binary '__ci_last_regenerate|i:1547815971;identity|s:13:\"administrator\";username|s:13:\"administrator\";email|s:21:\"mr.pudyasto@gmail.com\";user_id|s:1:\"1\";old_last_login|s:10:\"1547802903\";last_check|i:1547815971;');
/*!40000 ALTER TABLE `tmp_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `trn_indikator`
--

DROP TABLE IF EXISTS `trn_indikator`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `trn_indikator` (
  `indikator_id` int(11) NOT NULL,
  `tgl_tran` date NOT NULL,
  `keterangan` text,
  `num` int(11) NOT NULL DEFAULT '0',
  `denum` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) DEFAULT NULL,
  `tgl_add` datetime DEFAULT NULL,
  `tgl_edit` datetime DEFAULT NULL,
  PRIMARY KEY (`indikator_id`,`tgl_tran`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `trn_indikator`
--

LOCK TABLES `trn_indikator` WRITE;
/*!40000 ALTER TABLE `trn_indikator` DISABLE KEYS */;
/*!40000 ALTER TABLE `trn_indikator` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varchar(45) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `salt` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` int(11) unsigned NOT NULL,
  `last_login` int(11) unsigned DEFAULT NULL,
  `active` tinyint(1) unsigned DEFAULT '1',
  `full_name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username_UNIQUE` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'127.0.0.1','administrator','$2y$08$SiBeiAbNFLWRXlR2X2NH5OdyhhvJkJV2MJiRu5yJ/kbW1wpcjACC.','','mr.pudyasto@gmail.com','','DLpWTi9Yyx9uONbEmg3GJ.d7d1a85c12ea0b34ca',1547099714,NULL,1268889823,1547815971,1,'Administrator'),(2,'::1','admin','$2y$08$hA8vimoLziyBDGps6UEUk.2xNoAb4CYp5Lp9RD0JCXWF42Ac.zzcu',NULL,'admin@gmail.com',NULL,NULL,NULL,NULL,1545375444,1545799435,1,'Admin Akreditasi');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `users_groups_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `users_groups_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,1),(5,2,2);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-01-18 21:40:08
