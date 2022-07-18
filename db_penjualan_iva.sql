-- MySQL dump 10.16  Distrib 10.1.38-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: db_penjualan_iva
-- ------------------------------------------------------
-- Server version	10.1.38-MariaDB

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
-- Table structure for table `banners`
--

DROP TABLE IF EXISTS `banners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `banners` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `gambar` varchar(255) NOT NULL,
  `keterangan` varchar(300) NOT NULL,
  `is_active` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `banners`
--

LOCK TABLES `banners` WRITE;
/*!40000 ALTER TABLE `banners` DISABLE KEYS */;
INSERT INTO `banners` VALUES (1,'banner-2N9RrL1cEC-1658166533.jpg','Banner 1',1,'2022-07-19 00:48:53',NULL),(2,'banner-UN6f2aPKoZ-1658166614.jpg','Banner 2',1,'2022-07-19 00:50:14',NULL),(3,'banner-QI6yfk7vL3-1658166664.jpg','Banner 3',1,'2022-07-19 00:51:04',NULL);
/*!40000 ALTER TABLE `banners` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `detail_transaction`
--

DROP TABLE IF EXISTS `detail_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `detail_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `transaction_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_type_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_type_name` varchar(255) NOT NULL,
  `product_price` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_transaction`
--

LOCK TABLES `detail_transaction` WRITE;
/*!40000 ALTER TABLE `detail_transaction` DISABLE KEYS */;
INSERT INTO `detail_transaction` VALUES (1,2,19,10,'RFID LABEL','varian 1',1000000,3,'2022-06-13 19:11:03','2022-06-13 19:11:03','0000-00-00 00:00:00'),(2,2,20,14,'VARIABLE DATA','varian 2',1000000,1,'2022-06-13 19:11:03','2022-06-13 19:11:03','0000-00-00 00:00:00'),(3,3,28,37,'PRINTED RIGID BOX','varian 1',1000000,1,'2022-06-14 17:55:44','2022-06-14 17:55:44','0000-00-00 00:00:00'),(4,3,23,29,'INSTRUCTION BOOK','varian 4',1000000,3,'2022-06-14 17:55:44','2022-06-14 17:55:44','0000-00-00 00:00:00'),(5,4,22,24,'COLOR ADHESIVES','varian 3',1000000,2,'2022-06-19 20:26:01','2022-06-19 20:26:01','0000-00-00 00:00:00'),(6,5,22,24,'COLOR ADHESIVES','varian 3',1000000,2,'2022-06-19 20:35:42','2022-06-19 20:35:42','0000-00-00 00:00:00'),(7,5,27,35,'PROTECT VINYL','varian 2',1000000,2,'2022-06-19 20:35:42','2022-06-19 20:35:42','0000-00-00 00:00:00'),(8,6,27,34,'PROTECT VINYL','varian 1',1000000,2,'2022-06-23 00:03:04','2022-06-23 00:03:04','0000-00-00 00:00:00'),(9,7,21,18,'HANG TAG','varian 1',1000000,2,'2022-06-25 14:38:50','2022-06-25 14:38:50','0000-00-00 00:00:00'),(10,8,23,28,'INSTRUCTION BOOK','varian 3',1000000,2,'2022-06-25 14:39:56','2022-06-25 14:39:56','0000-00-00 00:00:00'),(11,8,22,23,'COLOR ADHESIVES','varian 2',1000000,1,'2022-06-25 14:39:56','2022-06-25 14:39:56','0000-00-00 00:00:00'),(12,9,19,11,'RFID LABEL','varian 2',2000000,2,'2022-07-17 00:23:03','2022-07-17 00:23:03','0000-00-00 00:00:00'),(13,10,21,20,'HANG TAG','varian 3',1000000,3,'2022-07-17 00:41:28','2022-07-17 00:41:28','0000-00-00 00:00:00'),(14,11,19,11,'RFID LABEL','varian 2',2000000,2,'2022-07-17 00:44:55','2022-07-17 00:44:55','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `detail_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kontak_perusahaan`
--

DROP TABLE IF EXISTS `kontak_perusahaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kontak_perusahaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `no_hp` varchar(50) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kontak_perusahaan`
--

LOCK TABLES `kontak_perusahaan` WRITE;
/*!40000 ALTER TABLE `kontak_perusahaan` DISABLE KEYS */;
INSERT INTO `kontak_perusahaan` VALUES (3,'085896777555','Iva 1','2022-07-19 01:37:52',NULL),(4,'089555333445','Iva 2','2022-07-19 01:38:04',NULL);
/*!40000 ALTER TABLE `kontak_perusahaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_types`
--

DROP TABLE IF EXISTS `product_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `product_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `harga` int(11) NOT NULL,
  `gambar` varchar(500) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_types`
--

LOCK TABLES `product_types` WRITE;
/*!40000 ALTER TABLE `product_types` DISABLE KEYS */;
INSERT INTO `product_types` VALUES (10,19,'varian 1',1000000,'varian_produk-jAym5zpZiW-1654139427.png',NULL,'2022-06-02 05:10:27','2022-06-08 18:21:36'),(11,19,'varian 2',2000000,'varian_produk-hfRkeHXFya-1654139427.png',NULL,'2022-06-02 05:10:27','2022-06-08 18:21:36'),(12,19,'varian 3',3000000,'varian_produk-RyOtxKJmsc-1654705296.jpg',NULL,'2022-06-02 05:10:27','2022-06-08 18:21:36'),(13,20,'varian 1',1000000,'varian_produk-WtXJmZdV3Y-1654145060.jpg',NULL,'2022-06-02 06:44:20','2022-06-21 21:44:58'),(14,20,'varian 2',2000000,'varian_produk-l4nw9paR2m-1654145060.jpg',NULL,'2022-06-02 06:44:20','2022-06-21 21:44:58'),(15,20,'varian 3',3000000,'varian_produk-TRo672jJVw-1654145060.jpg',NULL,'2022-06-02 06:44:21','2022-06-21 21:44:58'),(16,20,'varian 4',4000000,'varian_produk-X1HtAYzMcv-1654145061.jpg',NULL,'2022-06-02 06:44:21','2022-06-21 21:44:58'),(17,20,'varian 5',5000000,'varian_produk-QxvE1m6KNJ-1654145061.jpg',NULL,'2022-06-02 06:44:21','2022-06-21 21:44:58'),(18,21,'varian 1',1000000,'varian_produk-te8wg7uZxj-1654145864.jpg',NULL,'2022-06-02 06:57:44','2022-06-02 06:57:44'),(19,21,'varian 2',1000000,'varian_produk-yfNLqXm3xU-1654145864.jpg',NULL,'2022-06-02 06:57:44','2022-06-02 06:57:44'),(20,21,'varian 3',1000000,'varian_produk-oEZbVRYznU-1654145864.jpg',NULL,'2022-06-02 06:57:44','2022-06-02 06:57:44'),(21,21,'varian 4',1000000,'varian_produk-46OSWhx2FY-1654145864.jpg',NULL,'2022-06-02 06:57:44','2022-06-02 06:57:44'),(22,22,'varian 1',1000000,'varian_produk-2EQ4UyVpKw-1654157153.jpg',NULL,'2022-06-02 10:05:53','2022-06-03 11:16:47'),(23,22,'varian 2',1000000,'varian_produk-TXkQOYz6Wm-1654157153.jpg',NULL,'2022-06-02 10:05:53','2022-06-03 11:16:47'),(24,22,'varian 3',1000000,'varian_produk-iBNlQanjxA-1654157153.jpg',NULL,'2022-06-02 10:05:53','2022-06-03 11:16:47'),(25,22,'varian 4',1000000,'varian_produk-tP6pw2xQLK-1654157153.jpg',NULL,'2022-06-02 10:05:53','2022-06-03 11:16:47'),(26,23,'varian 1',1000000,'varian_produk-zEi5GeFNsn-1654157493.jpg',NULL,'2022-06-02 10:11:33','2022-06-02 10:11:33'),(27,23,'varian 2',1000000,'varian_produk-HLizGRNdAh-1654157493.jpg',NULL,'2022-06-02 10:11:33','2022-06-02 10:11:33'),(28,23,'varian 3',1000000,'varian_produk-u1CUhLBmiZ-1654157493.jpg',NULL,'2022-06-02 10:11:33','2022-06-02 10:11:33'),(29,23,'varian 4',1000000,'varian_produk-f5n2B6QqWP-1654157493.jpg',NULL,'2022-06-02 10:11:33','2022-06-02 10:11:33'),(30,23,'varian 5',1000000,'varian_produk-pNLyYVMgEl-1654157493.jpg',NULL,'2022-06-02 10:11:33','2022-06-02 10:11:33'),(34,27,'varian 1',1000000,'varian_produk-Tty1cDw6a4-1654221912.jpg',NULL,'2022-06-03 04:05:12','2022-06-03 04:05:12'),(35,27,'varian 2',1000000,'varian_produk-1C9vroVnU2-1654221912.jpg',NULL,'2022-06-03 04:05:12','2022-06-03 04:05:12'),(36,27,'varian 3',1000000,'varian_produk-ytQPDVIWuj-1654221912.jpg',NULL,'2022-06-03 04:05:12','2022-06-03 04:05:12'),(37,28,'varian 1',1000000,'varian_produk-q9jwYTP3Ho-1654222086.jpg',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06'),(38,28,'varian 2',1000000,'varian_produk-TEnePLdhR8-1654222086.jpg',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06'),(39,28,'varian 3',1000000,'varian_produk-ufSokHE6YL-1654222086.jpg',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06'),(40,28,'varian 4',1000000,'varian_produk-ZIDiL93h4f-1654222086.jpg',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06'),(41,28,'varian 5',1000000,'varian_produk-4OedAZ2wQ8-1654222086.jpg',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06'),(42,28,'varian 6',1000000,'varian_produk-Tq1yXOsRFg-1654222086.jpg',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06');
/*!40000 ALTER TABLE `product_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `slug` varchar(500) NOT NULL,
  `harga` int(11) NOT NULL DEFAULT '0',
  `stok` int(11) NOT NULL DEFAULT '0',
  `gambar` varchar(500) NOT NULL,
  `deskripsi` text NOT NULL,
  `satuan` varchar(50) NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (19,'RFID LABEL','rfid-label',3000000,50,'produk-Dp20EoQajs-1654139427.png','RFID labels are used to optimize client’s logistics &amp; provide better visibility of inventory while promoting brand authentication. We print variable data onto the RFID label, use RFID technology to encode electronic data. Electronic QC system is a must to ensure grade-A barcode is printed with accurate data. Printed &amp; encoded data reported back to the clients, which are used for item level inventory management. We are partners with global leading RFID inlay &amp; equipment manufacturers to produce high quality RFID labels.','pcs',NULL,'2022-06-02 05:10:27','2022-06-08 18:21:36'),(20,'VARIABLE DATA','variable-data',3000000,50,'produk-6OTGYJu4eL-1654145060.jpg','<p>Our raw materials go through numerous tests (MSDS, FSC, soyink, etc) &amp; certification to avoid misrepresenting client&rsquo;s brand value. We go through rigorous QC system to produce highest quality green label &amp; packaging to all our clients.</p>\r\n\r\n<p>We produce price tags, content label, UPC labels for international clients. We use customized software to manage data &amp; use digital printers to produce products. We print variable data ranging from price, 1D barcode, QR code, etc on to client&rsquo;s smart label. Our QC system ensures all our printed materials have grade-A barcode with accurate data.</p>\r\n','pcs',NULL,'2022-06-02 06:44:20','2022-06-21 21:44:58'),(21,'HANG TAG','hang-tag',3000000,50,'produk-caFAlzeCfY-1654145864.jpg','Hangtags enhance brand identity for clients. We produce quality hang tags to embellish international client’s products.','pcs',NULL,'2022-06-02 06:57:44','2022-06-02 06:57:44'),(22,'COLOR ADHESIVES','color-adhesives',3000000,50,'produk-5MmtNPdOc9-1654157153.jpg','Superior quality color adhesives are environmentally friendly way to incorporate brand graphics &amp; other messages onto the products. We produce color adhesives that are supplied to variety of industry ranging from electronics, apparels, f&amp;b to footwear business.','pcs',NULL,'2022-06-02 10:05:53','2022-06-03 11:16:47'),(23,'INSTRUCTION BOOK','instruction-book',3000000,50,'produk-PfAVDREpuF-1654157493.jpg','Instruction books/ manuals are easy to read description of a product in many different languages. We have long history of printing accurate/eco-friendly instruction books for international electronics brands.','pcs',NULL,'2022-06-02 10:11:33','2022-06-02 10:11:33'),(27,'PROTECT VINYL','protect-vinyl',3000000,50,'produk-Ao1u3fSObw-1654221912.jpg','Vinyls engraved with brand logo &amp; other messages are used to protect surfaces of electronic gadgets.','pcs',NULL,'2022-06-03 04:05:12','2022-06-03 04:05:12'),(28,'PRINTED RIGID BOX','printed-rigid-box',3000000,50,'produk-uUigDw5FId-1654222086.jpg','Printed rigid box are commonly associated with luxury good packaging. Rigid box are not only good for item protection, but a symbol of quality &amp; vanity. We produce most sophisticated printed rigid box to our international clients to amplify client’s product value.','pcs',NULL,'2022-06-03 04:08:06','2022-06-03 04:08:06');
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profil_perusahaan`
--

DROP TABLE IF EXISTS `profil_perusahaan`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profil_perusahaan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_perusahaan` varchar(255) NOT NULL,
  `alamat_perusahaan` varchar(255) NOT NULL,
  `deskripsi_perusahaan` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profil_perusahaan`
--

LOCK TABLES `profil_perusahaan` WRITE;
/*!40000 ALTER TABLE `profil_perusahaan` DISABLE KEYS */;
INSERT INTO `profil_perusahaan` VALUES (1,'Vavapedia','Gedung Artha Graha, Jl. Jend. sudirman kav 52-53 No.Kav 52-53, RT.5/RW.3, Senayan, Kec. Kby. Baru, Kota Jakarta Selatan, Daerah Khusus Ibukota Jakarta 12190','<h2>What is Lorem Ipsum?</h2>\r\n\r\n<p><strong>Lorem Ipsum</strong>&nbsp;is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#39;s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>\r\n\r\n<h2>Why do we use it?</h2>\r\n\r\n<p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using &#39;Content here, content here&#39;, making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for &#39;lorem ipsum&#39; will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>\r\n\r\n<p>&nbsp;</p>\r\n\r\n<h2>Where does it come from?</h2>\r\n\r\n<p>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of &quot;de Finibus Bonorum et Malorum&quot; (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, &quot;Lorem ipsum dolor sit amet..&quot;, comes from a line in section 1.10.32.</p>\r\n\r\n<p>The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those interested. Sections 1.10.32 and 1.10.33 from &quot;de Finibus Bonorum et Malorum&quot; by Cicero are also reproduced in their exact original form, accompanied by English versions from the 1914 translation by H. Rackham.</p>\r\n\r\n<h2>Where can I get some?</h2>\r\n\r\n<p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don&#39;t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn&#39;t anything embarrassing hidden in the middle of text. All the Lorem Ipsum generators on the Internet tend to repeat predefined chunks as necessary, making this the first true generator on the Internet. It uses a dictionary of over 200 Latin words, combined with a handful of model sentence structures, to generate Lorem Ipsum which looks reasonable. The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.</p>\r\n','');
/*!40000 ALTER TABLE `profil_perusahaan` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_nm` varchar(100) NOT NULL,
  `is_admin` int(11) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'superadmin',1,NULL,'2022-05-19 00:00:00','2022-05-19 00:00:00'),(2,'marketing',1,NULL,'2022-05-19 00:00:00','2022-05-19 00:00:00'),(3,'customer',0,NULL,'2022-05-19 00:00:00','2022-05-19 00:00:00');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `status_transaction`
--

DROP TABLE IF EXISTS `status_transaction`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `status_transaction` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `status_transaction`
--

LOCK TABLES `status_transaction` WRITE;
/*!40000 ALTER TABLE `status_transaction` DISABLE KEYS */;
INSERT INTO `status_transaction` VALUES (1,'Menunggu Konfirmasi'),(2,'Menunggu Pembayaran'),(3,'Pesanan Diproses'),(4,'Pesanan Telah Dikirim'),(5,'Transaksi Batal'),(6,'Menunggu Konfirmasi Pembayaran');
/*!40000 ALTER TABLE `status_transaction` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `kode_pemesanan` varchar(100) NOT NULL,
  `tanggal_transaksi` datetime NOT NULL,
  `status_transaksi` int(11) NOT NULL,
  `bukti_pembayaran` varchar(500) DEFAULT NULL,
  `batas_pembayaran` datetime DEFAULT NULL,
  `alamat_pemesanan` text NOT NULL,
  `resi_pemesanan` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (2,6,'TRS-62a8a202edb0c','2022-06-13 19:11:03',5,NULL,NULL,'Jl. Dummy No. 99, Kec. Dummy, Kota Dummy',NULL,'2022-06-13 19:11:03','2022-06-16 22:00:10',NULL),(3,6,'TRS-62a8af80e6a4c','2022-06-14 17:55:44',4,'bukti-2XR8J5z1G7-1655644123.png',NULL,'Jl. Dummy No. 99, Kec. Dummy, Kota Dummy','JS1320967817','2022-06-14 17:55:44','2022-06-19 22:36:30',NULL),(4,6,'TRS-62af23e95b892','2022-06-19 20:26:01',4,'bukti-ABwICz29qb-1655653664.png',NULL,'Jl. Dummy No. 99, Kec. Dummy, Kota Dummy','JS1320967817','2022-06-19 20:26:01','2022-06-19 22:48:29',NULL),(5,6,'TRS-62af262eab08d','2022-06-19 20:35:42',4,'bukti-BjankZy0fT-1655653676.png',NULL,'Jl. Dummy No. 99, Kec. Dummy, Kota Dummy','JS1320967817','2022-06-19 20:35:42','2022-06-19 22:48:32',NULL),(6,6,'TRS-62b34b480f9b5','2022-06-23 00:03:04',5,'bukti-1MiUSw6Qco-1656143022.png',NULL,'Jl. Bekasi',NULL,'2022-06-23 00:03:04','2022-07-17 00:19:54',NULL),(7,6,'TRS-62b6bb8ac6152','2022-06-25 14:38:50',5,'bukti-cLseb8j0pB-1657875100.jpg',NULL,'Jl. Bekasi',NULL,'2022-06-25 14:38:50','2022-07-17 00:20:00',NULL),(8,6,'TRS-62b6bbcce6193','2022-06-25 14:39:56',5,NULL,'2022-07-15 15:52:23','Jl. Bekasi',NULL,'2022-06-25 14:39:56','2022-07-17 00:14:47',NULL),(9,6,'TRS-62d2f3f7dd342','2022-07-17 00:23:03',4,'bukti-u3NjcAPqtx-1657992843.png',NULL,'Jl. Bekasi','6327167313','2022-07-17 00:23:03','2022-07-17 00:39:59',NULL),(10,6,'TRS-62d2f84863aed','2022-07-17 00:41:28',4,'bukti-jKbOlcwN2o-1657993316.png',NULL,'Jl. Bekasi','1331313131','2022-07-17 00:41:28','2022-07-17 00:43:50',NULL),(11,6,'TRS-62d2f9171814e','2022-07-17 00:44:55',4,'bukti-tS6hrdDgop-1658163152.png',NULL,'Jl. Bekasi','123456789','2022-07-17 00:44:55','2022-07-18 23:56:48',NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `role_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_hp` varchar(50) DEFAULT NULL,
  `alamat` text,
  `is_active` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (3,'superuser',1,'superuser@gmail.com','$2y$10$jTTPiJDgIs1vZ2.vxMYT8.8QqNxpe/yRdAX70vtiw82ySZrhwqUAO','085896452806','',1,'2022-05-19 16:10:44','2022-05-19 16:10:44',NULL),(5,'dummycustomer2',3,'dummycustomer2@iva.com','$2y$10$tAamrtznyxoXjYLkP0SPO.t1kp7pi9cJsOI6xfqpACd0vMTEWq7Ui','','',1,'2022-05-22 12:10:54','2022-05-22 12:10:54',NULL),(6,'Jessie',3,'dummycustomer@gmail.com','$2y$10$nHP7i/zSBeHwize.sEc2EO0bO3vZx0rizX9sUg90Bp0wXdZcET5mW','085896452806','Jl. Bekasi',1,'2022-05-23 18:01:57','2022-07-17 00:22:21',NULL),(7,'Marketing 1',2,'marketing1@gmail.com','$2y$10$02zciQ8jqUoHe8GAkuFt2OwU02Wj4aqa.JhC96a1fwBwZ.vu4JELa','085896452806','',1,'2022-05-28 15:31:53','2022-05-28 15:31:53',NULL),(8,'Dummy Customer',3,'dummycustomer@iva.com','$2y$10$.lphoMXYMp4MuhtoxDauseRNY/ucBf0A9oyqZbplr2MDwLd/lJ5w2',NULL,NULL,1,'2022-06-06 10:52:46','2022-06-06 10:52:46',NULL),(9,'Marketing 2',2,'marketing2@gmail.com','$2y$10$run9TEIil.jpOC3obx7Q2O4uoaO9SLiEJrHC07l6nHHI5MYhXsqVy','085896452806',NULL,1,'2022-06-17 18:33:00','2022-06-25 14:08:19',NULL),(10,'Aji Pujo Hardiyanto',3,'ajipujo2nd@gmail.com','$2y$10$6Q5CWbKcFANJzCrv/CRI6eRYNwHPjV3ErMyz2U0YB8Hb4lwXwMh0C','085896452806','Randugunting',1,'2022-06-26 21:39:12','2022-07-18 23:59:37',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-07-19  1:58:25
