-- MariaDB dump 10.19  Distrib 10.8.3-MariaDB, for osx10.17 (x86_64)
--
-- Host: localhost    Database: boilerplate
-- ------------------------------------------------------
-- Server version	10.8.3-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `blog_authors`
--

DROP TABLE IF EXISTS `blog_authors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_authors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `github_handle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_handle` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_authors_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_authors`
--

LOCK TABLES `blog_authors` WRITE;
/*!40000 ALTER TABLE `blog_authors` DISABLE KEYS */;
INSERT INTO `blog_authors` VALUES
(1,'{\"en\":\"Administrator\"}','sample@domain.com',NULL,NULL,NULL,NULL,'2022-09-07 19:30:19','2022-09-07 19:30:19');
/*!40000 ALTER TABLE `blog_authors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_categories`
--

DROP TABLE IF EXISTS `blog_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT 0,
  `seo_title` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `seo_description` varchar(160) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_categories`
--

LOCK TABLES `blog_categories` WRITE;
/*!40000 ALTER TABLE `blog_categories` DISABLE KEYS */;
INSERT INTO `blog_categories` VALUES
(1,'{\"en\":\"Page\",\"id\":\"Halaman\"}','{\"en\":\"page\",\"id\":\"halaman\"}','{\"en\":\"Category for static page\",\"id\":\"Kategori halaman untuk halaman statis\"}',1,NULL,NULL,'2022-09-07 19:28:50','2022-09-07 19:29:48'),
(2,'{\"en\":\"Technology\",\"id\":\"Teknologi\"}','{\"en\":\"technology\",\"id\":\"teknologi\"}','{\"en\":\"Post category of technology\",\"id\":\"Kategori postingan teknologi\"}',1,NULL,NULL,'2022-09-07 19:29:02','2022-09-07 19:30:01'),
(3,'{\"en\":\"Public\",\"id\":\"Publik\"}','{\"en\":\"public\",\"id\":\"publik\"}','{\"en\":\"Post category of public\",\"id\":\"Kategori postingan publik\"}',1,NULL,NULL,'2022-09-07 19:29:18','2022-09-07 19:29:30');
/*!40000 ALTER TABLE `blog_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `blog_posts`
--

DROP TABLE IF EXISTS `blog_posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `blog_posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `blog_author_id` bigint(20) unsigned DEFAULT NULL,
  `blog_category_id` bigint(20) unsigned DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `published_at` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `blog_posts_slug_unique` (`slug`),
  KEY `blog_posts_blog_author_id_foreign` (`blog_author_id`),
  KEY `blog_posts_blog_category_id_foreign` (`blog_category_id`),
  CONSTRAINT `blog_posts_blog_author_id_foreign` FOREIGN KEY (`blog_author_id`) REFERENCES `blog_authors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `blog_posts_blog_category_id_foreign` FOREIGN KEY (`blog_category_id`) REFERENCES `blog_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `blog_posts`
--

LOCK TABLES `blog_posts` WRITE;
/*!40000 ALTER TABLE `blog_posts` DISABLE KEYS */;
INSERT INTO `blog_posts` VALUES
(1,1,1,'{\"en\":\"Articles\",\"id\":\"Artikel\"}','{\"en\":\"articles\",\"id\":\"artikel\"}','{\"en\":\"This is an example excerpt for SEO purposes on page Articles.\",\"id\":\"Ini adalah contoh kutipan untuk keperluan SEO pada halaman Artikel.\"}','{\"en\":null}','{\"en\":\"<p><\\/p>\",\"id\":\"<p><\\/p>\"}','2022-09-08','2022-09-07 19:38:45','2022-09-07 19:40:35'),
(2,1,1,'{\"en\":\"About\",\"id\":\"Tentang\"}','{\"en\":\"about\",\"id\":\"tentang\"}','{\"en\":\"This is an example excerpt for SEO purposes on page About.\",\"id\":\"Ini adalah contoh kutipan untuk keperluan SEO pada halaman Tentang.\"}','{\"id\":null}','{\"en\":\"<p>This is example of about page<\\/p>\",\"id\":\"<p>Ini adalah contoh untuk halaman tentang.<\\/p>\"}','2022-09-08','2022-09-07 19:39:08','2022-09-07 19:44:34'),
(3,1,2,'{\"en\":\"Website\",\"id\":\"Situs Web\"}','{\"en\":\"website\",\"id\":\"situs-web\"}','{\"en\":\"A website (also written as web site) is a collection of web pages and related content that is identified by a common domain name and published on at least one web server. Examples of notable websites are Google, Facebook, Amazon, and Wikipedia.\",\"id\":\"Situs web (bahasa Inggris: website[1]) adalah sekumpulan halaman web yang saling berhubungan yang umumnya berada pada peladen yang sama berisikan kumpulan informasi yang disediakan secara perorangan, kelompok, atau organisasi.\"}','{\"id\":null}','{\"en\":\"<h2>Introduction<\\/h2><p>A website (also written as web site) is a collection of web pages and related content that is identified by a common domain name and published on at least one web server. Examples of notable websites are Google, Facebook, Amazon, and Wikipedia.<\\/p><p>All publicly accessible websites collectively constitute the World Wide Web. There are also private websites that can only be accessed on a private network, such as a company\'s internal website for its employees.<\\/p><h3>Some Heading Here<\\/h3><p>Websites are typically dedicated to a particular topic or purpose, such as news, education, commerce, entertainment, or social networking. Hyperlinking between web pages guides the navigation of the site, which often starts with a home page.<\\/p><p>Users can access websites on a range of devices, including desktops, laptops, tablets, and smartphones. The app used on these devices is called a web browser.<\\/p><p><a href=\\\"https:\\/\\/en.wikipedia.org\\/wiki\\/Website\\\" as_button=\\\"false\\\" button_theme=\\\"\\\">https:\\/\\/en.wikipedia.org\\/wiki\\/Website<\\/a><\\/p>\",\"id\":\"<h2>Perkenalan<\\/h2><p>Situs web (bahasa Inggris: website[1]) adalah sekumpulan halaman web yang saling berhubungan yang umumnya berada pada peladen yang sama berisikan kumpulan informasi yang disediakan secara perorangan, kelompok, atau organisasi.[2] <\\/p><p>Sebuah situs web biasanya ditempatkan setidaknya pada sebuah server web yang dapat diakses melalui jaringan seperti Internet, ataupun jaringan area lokal (LAN) melalui alamat Internet yang dikenali sebagai URL.<\\/p><h3>Contoh heading disini<\\/h3><p>Gabungan atas semua situs yang dapat diakses publik di Internet disebut pula sebagai World Wide Web atau lebih dikenal dengan singkatan WWW.<\\/p><p>Meskipun setidaknya halaman beranda situs Internet umumnya dapat diakses publik secara bebas, pada praktiknya tidak semua situs memberikan kebebasan bagi publik untuk mengaksesnya, beberapa situs web mewajibkan pengunjung untuk melakukan pendaftaran sebagai anggota, atau bahkan meminta pembayaran untuk dapat menjadi anggota untuk dapat mengakses isi yang terdapat dalam situs web tersebut, misalnya situs-situs yang menampilkan pornografi, situs-situs berita, layanan surel (e-mail), dan lain-lain.<\\/p><p>Pembatasan-pembatasan ini umumnya dilakukan karena alasan keamanan, menghormati privasi, atau karena tujuan komersial tertentu.<\\/p><p><a href=\\\"https:\\/\\/id.wikipedia.org\\/wiki\\/Situs_web\\\" as_button=\\\"false\\\" button_theme=\\\"\\\">https:\\/\\/id.wikipedia.org\\/wiki\\/Situs_web<\\/a><\\/p>\"}','2022-09-08','2022-09-07 19:42:25','2022-09-07 19:43:37');
/*!40000 ALTER TABLE `blog_posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `filament_email_log`
--

DROP TABLE IF EXISTS `filament_email_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `filament_email_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `from` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `to` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bcc` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `text_body` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `html_body` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `raw_body` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sent_debug_info` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `filament_email_log`
--

LOCK TABLES `filament_email_log` WRITE;
/*!40000 ALTER TABLE `filament_email_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `filament_email_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES
(1,'2014_10_11_000000_create_user_roles_table copy',1),
(2,'2014_10_12_000000_create_users_table',1),
(3,'2014_10_12_100000_create_password_resets_table',1),
(4,'2019_08_19_000000_create_failed_jobs_table',1),
(5,'2019_12_14_000001_create_personal_access_tokens_table',1),
(6,'2021_07_24_120348_create_settings_table',1),
(7,'2021_07_24_120525_create_filament_email_log_table',1),
(8,'2021_07_24_120526_add_raw_and_debug_fields_to_filament_email_log_table',1),
(9,'2021_07_24_121955_create_filament_blog_tables',1),
(10,'2021_07_24_121955_create_tag_tables',1),
(11,'2022_04_18_132920_create_navigations_table',1),
(12,'2022_04_21_203420_make_items_longtext_on_navigations_table',1),
(13,'2022_08_10_075134_create_newsletters_table',1),
(14,'2022_12_14_085131_settings',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `navigations`
--

DROP TABLE IF EXISTS `navigations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `navigations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `handle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `items` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `navigations_handle_unique` (`handle`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `navigations`
--

LOCK TABLES `navigations` WRITE;
/*!40000 ALTER TABLE `navigations` DISABLE KEYS */;
INSERT INTO `navigations` VALUES
(1,'Menu English','menu_en','{\"68b372bc-a6d3-4ad3-a687-0feecabc8e26\":{\"label\":\"Home\",\"type\":\"external-link\",\"data\":{\"url\":\"\\/\",\"target\":null},\"children\":[]},\"7715cdc9-62b4-4ff1-a59e-fe0c2c54ff34\":{\"label\":\"Articles\",\"type\":\"external-link\",\"data\":{\"url\":\"\\/articles\",\"target\":null},\"children\":[]},\"de13005a-d065-40a2-a3e3-002ea1d2a971\":{\"label\":\"About\",\"type\":\"external-link\",\"data\":{\"url\":\"\\/about\",\"target\":null},\"children\":[]}}','2022-09-07 19:36:36','2022-09-07 19:36:47'),
(2,'Menu Indonesia','menu_id','{\"fb7ba040-0322-492e-b026-ba48c6b9da8f\":{\"label\":\"Beranda\",\"type\":\"external-link\",\"data\":{\"url\":\"\\/\",\"target\":null},\"children\":[]},\"083d7882-4132-4831-904a-e7689383618a\":{\"label\":\"Artikel\",\"type\":\"external-link\",\"data\":{\"url\":\"\\/artikel\",\"target\":null},\"children\":[]},\"d19638ff-b288-44e9-a130-30891726a9fb\":{\"label\":\"Tentang\",\"type\":\"external-link\",\"data\":{\"url\":\"\\/tentang\",\"target\":null},\"children\":[]}}','2022-09-07 19:37:34','2022-09-07 19:37:34');
/*!40000 ALTER TABLE `navigations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `newsletters`
--

DROP TABLE IF EXISTS `newsletters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `newsletters` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `newsletters`
--

LOCK TABLES `newsletters` WRITE;
/*!40000 ALTER TABLE `newsletters` DISABLE KEYS */;
/*!40000 ALTER TABLE `newsletters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locked` tinyint(1) NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`payload`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `settings_group_index` (`group`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES
(1,'sites','site_name_en',0,'\"The Boilerplate\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(2,'sites','site_name_id',0,'\"The Boilerplate\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(3,'sites','site_description_en',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(4,'sites','site_description_id',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(5,'sites','site_keywords_en',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(6,'sites','site_keywords_id',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(7,'sites','site_profile',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(8,'sites','site_logo',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(9,'sites','site_author',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(10,'sites','site_address',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(11,'sites','site_email',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(12,'sites','site_phone',0,'\"-\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(13,'sites','site_phone_code',0,'\"+62\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(14,'sites','site_location',0,'\"Indonesia\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(15,'sites','site_currency_en',0,'\"USD\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(16,'sites','site_currency_id',0,'\"IDR\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(17,'sites','site_language_en',0,'\"en-US\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(18,'sites','site_language_id',0,'\"id-ID\"','2022-09-07 19:22:19','2022-09-07 19:22:19'),
(19,'sites','site_social',0,'[]','2022-09-07 19:22:19','2022-09-07 19:22:19');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `taggables`
--

DROP TABLE IF EXISTS `taggables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `taggables` (
  `tag_id` bigint(20) unsigned NOT NULL,
  `taggable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `taggable_id` bigint(20) unsigned NOT NULL,
  UNIQUE KEY `taggables_tag_id_taggable_id_taggable_type_unique` (`tag_id`,`taggable_id`,`taggable_type`),
  KEY `taggables_taggable_type_taggable_id_index` (`taggable_type`,`taggable_id`),
  CONSTRAINT `taggables_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `taggables`
--

LOCK TABLES `taggables` WRITE;
/*!40000 ALTER TABLE `taggables` DISABLE KEYS */;
INSERT INTO `taggables` VALUES
(1,'App\\Models\\Post',1),
(1,'App\\Models\\Post',2),
(2,'App\\Models\\Post',3);
/*!40000 ALTER TABLE `taggables` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`name`)),
  `slug` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`slug`)),
  `type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_column` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES
(1,'{\"en\":\"SEO\"}','{\"en\":\"seo\"}',NULL,1,'2022-09-07 19:38:45','2022-09-07 19:38:45'),
(2,'{\"en\":\"Article\"}','{\"en\":\"article\"}',NULL,2,'2022-09-07 19:42:25','2022-09-07 19:42:25');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_roles`
--

DROP TABLE IF EXISTS `user_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_roles`
--

LOCK TABLES `user_roles` WRITE;
/*!40000 ALTER TABLE `user_roles` DISABLE KEYS */;
INSERT INTO `user_roles` VALUES
(1,'Administrator',1,'2022-09-07 19:30:28','2022-09-07 19:30:28',NULL);
/*!40000 ALTER TABLE `user_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_role_id` bigint(20) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_user_role_id_foreign` (`user_role_id`),
  CONSTRAINT `users_user_role_id_foreign` FOREIGN KEY (`user_role_id`) REFERENCES `user_roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES
(1,1,'Super Administrator','super@domain.com',NULL,'$2a$10$LvRfWOU0OClm7LYvfUiVuuDPxi0QNI7VdyHEANWVrFxT9qzcRIz5a','en',NULL,'2022-09-07 19:24:39','2022-09-07 19:30:37',NULL);
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

-- Dump completed on 2022-09-08 10:32:33
