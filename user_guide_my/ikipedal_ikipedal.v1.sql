-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 24 Eki 2014, 09:44:48
-- Sunucu sürümü: 5.6.16
-- PHP Sürümü: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Veritabanı: `ikipedal_ikipedal`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `admin_users`
--

CREATE TABLE IF NOT EXISTS `admin_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) DEFAULT '1',
  `username` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `password` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `name` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `surname` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `email` varchar(80) COLLATE utf8_turkish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `admin_users`
--

INSERT INTO `admin_users` (`id`, `is_active`, `username`, `password`, `name`, `surname`, `email`, `created_at`, `updated_at`) VALUES
(1, 1, 'iso', 'cfd1db80feab1f6edda2d1280ebb3e3f', 'ismail', 'akbudak', NULL, '2014-04-09 20:23:42', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alerts`
--

CREATE TABLE IF NOT EXISTS `alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `bio` tinyint(1) DEFAULT '0',
  `photo` tinyint(1) DEFAULT '0',
  `extra_tr` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL,
  `extra_en` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL,
  `extra_read` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=31 ;

--
-- Tablo döküm verisi `alerts`
--

INSERT INTO `alerts` (`id`, `user_id`, `bio`, `photo`, `extra_tr`, `extra_en`, `extra_read`, `created_at`) VALUES
(29, 14, 0, 0, NULL, NULL, 1, '2014-10-19 17:07:53'),
(30, 15, 0, 0, NULL, NULL, 1, '2014-10-19 21:01:31');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `alert_user`
--

CREATE TABLE IF NOT EXISTS `alert_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_user_id` int(11) DEFAULT NULL,
  `received_user_id` int(11) DEFAULT NULL,
  `message_id` int(11) DEFAULT NULL,
  `explain` varchar(200) COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `sender_user_id` (`sender_user_id`),
  KEY `received_user_id` (`received_user_id`),
  KEY `message_id` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `atandance`
--

CREATE TABLE IF NOT EXISTS `atandance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `block_user`
--

CREATE TABLE IF NOT EXISTS `block_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `blocked_user_id` int(11) DEFAULT NULL,
  `explain` text COLLATE utf8_turkish_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `blocked_user_id` (`blocked_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL DEFAULT '0',
  `ip_address` varchar(45) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL DEFAULT '0',
  `user_agent` varchar(120) CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text CHARACTER SET utf8 COLLATE utf8_turkish_ci NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Tablo döküm verisi `ci_sessions`
--

INSERT INTO `ci_sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('16904dee64fc5ba078544a36296c53a1', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 1414143467, '');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `complain`
--

CREATE TABLE IF NOT EXISTS `complain` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `complain_user_id` int(11) DEFAULT NULL,
  `complain` varchar(350) COLLATE utf8_turkish_ci DEFAULT NULL,
  `email` varchar(70) COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `complain_user_id` (`complain_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '-1',
  `user_type` varchar(30) COLLATE utf8_turkish_ci DEFAULT NULL,
  `issue` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `url` varchar(60) COLLATE utf8_turkish_ci DEFAULT 'diger',
  `subject` varchar(50) COLLATE utf8_turkish_ci DEFAULT NULL,
  `message` varchar(350) COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `email` varchar(70) COLLATE utf8_turkish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `created_events`
--

CREATE TABLE IF NOT EXISTS `created_events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `o_from` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `from_lat` float DEFAULT NULL,
  `from_lng` float DEFAULT NULL,
  `d_to` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `to_lat` float DEFAULT NULL,
  `to_lng` float DEFAULT NULL,
  `distance` double DEFAULT NULL,
  `time` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=18 ;

--
-- Tablo döküm verisi `created_events`
--

INSERT INTO `created_events` (`id`, `event_id`, `o_from`, `from_lat`, `from_lng`, `d_to`, `to_lat`, `to_lng`, `distance`, `time`) VALUES
(1, 4, 'Denizli, Türkiye', 37.7765, 29.0864, 'Edirne, Türkiye', 41.6667, 26.5667, 885.845, '   11 saat 13 dakika'),
(2, 4, 'Edirne, Türkiye', 41.6667, 26.5667, 'Adapazarı, Türkiye', 40.8291, 30.4155, 402.794, '   4 saat 17 dakika'),
(3, 4, 'Adapazarı, Türkiye', 40.8291, 30.4155, 'Adana, Türkiye', 37, 35.3213, 800.831, '   9 saat 54 dakika'),
(4, 4, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 2089.47, ' 25 saat 25 dk '),
(5, 5, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(6, 6, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(7, 7, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(8, 8, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(9, 9, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(10, 10, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(11, 11, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(12, 12, 'Denizli, Türkiye', 37.7765, 29.0864, 'Edirne, Türkiye', 41.6667, 26.5667, 885.845, '   11 hour 13 minute'),
(13, 12, 'Edirne, Türkiye', 41.6667, 26.5667, 'Adapazarı, Türkiye', 40.8291, 30.4155, 402.794, '   4 hour 17 minute'),
(14, 12, 'Adapazarı, Türkiye', 40.8291, 30.4155, 'Adana, Türkiye', 37, 35.3213, 800.831, '   9 hour 54 minute'),
(15, 12, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 2089.47, ' 25 hr 25 min '),
(16, 13, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(17, 14, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min ');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `delete_acount`
--

CREATE TABLE IF NOT EXISTS `delete_acount` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `description` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `email_alerts`
--

CREATE TABLE IF NOT EXISTS `email_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `place1` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `place2` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `date` date DEFAULT NULL,
  `origin` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `destination` varchar(100) COLLATE utf8_turkish_ci DEFAULT '-1',
  `dLat` float DEFAULT '-1',
  `dLng` float DEFAULT '-1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `email_alerts_result`
--

CREATE TABLE IF NOT EXISTS `email_alerts_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_alert_id` int(11) DEFAULT NULL,
  `event_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_alert_id` (`email_alert_id`),
  KEY `ride_offer_id` (`event_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `name` varchar(100) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_way` tinyint(1) DEFAULT '0',
  `trip_type` tinyint(1) DEFAULT '0',
  `origin` varchar(150) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `destination` varchar(150) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `way_points` varchar(500) DEFAULT NULL,
  `departure_date` date DEFAULT NULL,
  `departure_time` time DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `return_time` time DEFAULT NULL,
  `round_trip` tinyint(1) DEFAULT '0',
  `total_distance` varchar(70) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `total_time` varchar(70) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `explain_departure` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `explain_approval` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  `event_type_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Tablo döküm verisi `events`
--

INSERT INTO `events` (`id`, `user_id`, `name`, `is_active`, `is_way`, `trip_type`, `origin`, `destination`, `way_points`, `departure_date`, `departure_time`, `return_date`, `return_time`, `round_trip`, `total_distance`, `total_time`, `explain_departure`, `explain_approval`, `created_at`, `updated_at`, `event_type_id`) VALUES
(4, 15, 'Wsa', 1, 1, 0, 'Denizli, Türkiye', 'Adana, Türkiye', 'Edirne, Türkiye?Adapazarı, Türkiye', '2014-10-24', '12:30:00', '2014-10-25', '12:30:00', 1, ' 2089.47 km ', ' 25 saat 25 dk ', '', 0, '2014-10-23 20:57:13', NULL, 2),
(5, 15, 'Test 111', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Test', 0, '2014-10-23 21:04:59', NULL, 1),
(6, 15, 'Test 111', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Test', 0, '2014-10-23 21:05:46', NULL, 1),
(7, 15, 'Test 111', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Test', 0, '2014-10-23 21:06:05', NULL, 1),
(8, 15, 'Test 111', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Test', 0, '2014-10-23 21:06:25', NULL, 1),
(9, 15, 'Test 111', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Test', 0, '2014-10-23 21:06:28', NULL, 1),
(10, 15, 'Test 111a', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Testa', 0, '2014-10-23 21:06:59', NULL, 2),
(11, 15, 'Test 111aaa', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Testa', 0, '2014-10-23 21:07:31', NULL, 2),
(12, 15, 'Adadasd', 1, 1, 0, 'Denizli, Türkiye', 'Adana, Türkiye', 'Edirne, Türkiye?Adapazarı, Türkiye', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 2089.47 km ', ' 25 hr 25 min ', 'Asdad', 0, '2014-10-23 21:11:29', NULL, 1),
(13, 15, 'Adadasd', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', 'Asdad', 0, '2014-10-23 21:23:18', NULL, 1),
(14, 15, 'Asd', 1, 0, 0, 'Denizli, Türkiye', 'Adana, Türkiye', '', '2014-10-30', '12:30:00', '2014-10-31', '12:30:00', 1, ' 734.277 km ', ' 11 hr 8 min ', '', 0, '2014-10-23 23:06:35', NULL, 2);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_paths`
--

CREATE TABLE IF NOT EXISTS `event_paths` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `event_id` int(11) DEFAULT NULL,
  `o_from` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `from_lat` float DEFAULT NULL,
  `from_lng` float DEFAULT NULL,
  `d_to` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `to_lat` float DEFAULT NULL,
  `to_lng` float DEFAULT NULL,
  `distance` double DEFAULT NULL,
  `time` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_offer_id` (`event_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=26 ;

--
-- Tablo döküm verisi `event_paths`
--

INSERT INTO `event_paths` (`id`, `event_id`, `o_from`, `from_lat`, `from_lng`, `d_to`, `to_lat`, `to_lng`, `distance`, `time`) VALUES
(9, 4, 'Denizli, Türkiye', 37.7765, 29.0864, 'Edirne, Türkiye', 41.6667, 26.5667, 885.845, '   11 saat 13 dakika'),
(10, 4, 'Edirne, Türkiye', 41.6667, 26.5667, 'Adapazarı, Türkiye', 40.8291, 30.4155, 402.794, '   4 saat 17 dakika'),
(11, 4, 'Adapazarı, Türkiye', 40.8291, 30.4155, 'Adana, Türkiye', 37, 35.3213, 800.831, '   9 saat 54 dakika'),
(12, 4, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 2089.47, ' 25 saat 25 dk '),
(13, 5, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(14, 6, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(15, 7, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(16, 8, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(17, 9, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(18, 10, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(19, 11, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(20, 12, 'Denizli, Türkiye', 37.7765, 29.0864, 'Edirne, Türkiye', 41.6667, 26.5667, 885.845, '   11 hour 13 minute'),
(21, 12, 'Edirne, Türkiye', 41.6667, 26.5667, 'Adapazarı, Türkiye', 40.8291, 30.4155, 402.794, '   4 hour 17 minute'),
(22, 12, 'Adapazarı, Türkiye', 40.8291, 30.4155, 'Adana, Türkiye', 37, 35.3213, 800.831, '   9 hour 54 minute'),
(23, 12, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 2089.47, ' 25 hr 25 min '),
(24, 13, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min '),
(25, 14, 'Denizli, Türkiye', 37.7765, 29.0864, 'Adana, Türkiye', 37, 35.3213, 734.277, ' 11 hr 8 min ');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `event_types`
--

CREATE TABLE IF NOT EXISTS `event_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `name_en` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=3 ;

--
-- Tablo döküm verisi `event_types`
--

INSERT INTO `event_types` (`id`, `name`, `name_en`) VALUES
(1, 'Bisiklet', 'Biycle'),
(2, 'Spor', 'Sport\r\n');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `look_at`
--

CREATE TABLE IF NOT EXISTS `look_at` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ride_offer_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `path` varchar(60) COLLATE utf8_turkish_ci DEFAULT NULL,
  `origin` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `destination` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `ride_offer_id` (`ride_offer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `received_user_id` int(11) DEFAULT NULL,
  `ride_offer_id` int(11) DEFAULT NULL,
  `send_visible` tinyint(4) DEFAULT '1',
  `sender_archived` tinyint(1) DEFAULT '0',
  `receive_visible` tinyint(4) DEFAULT '1',
  `receive_archived` tinyint(1) DEFAULT '0',
  `message` varchar(500) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `readed_receive` tinyint(1) DEFAULT '0',
  `readed_sender` tinyint(1) DEFAULT '0',
  `is_answer` tinyint(1) DEFAULT '0',
  `complain` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_messages_on_user_id_and_received_user_id` (`user_id`,`received_user_id`),
  KEY `sender_archived` (`sender_archived`),
  KEY `ride_offer_id` (`ride_offer_id`),
  KEY `user_id` (`user_id`),
  KEY `received_user_id` (`received_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `new_message` tinyint(1) DEFAULT '1',
  `after_ride` tinyint(1) DEFAULT '1',
  `receive_rate` tinyint(1) DEFAULT '1',
  `updates` tinyint(1) DEFAULT '1',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_settings_on_user_id` (`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=29 ;

--
-- Tablo döküm verisi `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `new_message`, `after_ride`, `receive_rate`, `updates`, `created_at`, `updated_at`) VALUES
(27, 14, 1, 1, 1, 1, '2014-10-19 17:07:53', NULL),
(28, 15, 1, 1, 1, 1, '2014-10-19 21:01:31', NULL);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `problems`
--

CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `problem` varchar(500) COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `email` varchar(70) COLLATE utf8_turkish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=2 ;

--
-- Tablo döküm verisi `problems`
--

INSERT INTO `problems` (`id`, `problem`, `is_read`, `email`, `created_at`) VALUES
(1, 'Adsadsadasdsadadaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 1, 'asdsadad', '2014-10-21 18:35:29');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ratings`
--

CREATE TABLE IF NOT EXISTS `ratings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `given_userid` int(11) DEFAULT NULL,
  `received_userid` int(11) DEFAULT NULL,
  `rate` int(11) DEFAULT '0',
  `comment` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_driver` tinyint(1) DEFAULT '0',
  `skill` varchar(20) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT 'no-skill',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `index_ratings_on_user_id_and_received_user_id` (`given_userid`,`received_userid`),
  KEY `given_userid` (`given_userid`),
  KEY `received_userid` (`received_userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ride_offer_update`
--

CREATE TABLE IF NOT EXISTS `ride_offer_update` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `session_id` varchar(45) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `ride_offer_id` int(11) DEFAULT NULL,
  `is_update` tinyint(1) DEFAULT '1',
  `round_trip` varchar(7) DEFAULT NULL,
  `origin` varchar(200) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `destination` varchar(200) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `way_points` text CHARACTER SET utf8 COLLATE utf8_turkish_ci,
  `departure_date` varchar(10) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `departure_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `return_date` varchar(10) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `return_time` varchar(10) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `departure_days` varchar(200) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `return_days` varchar(200) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `trip_type` tinyint(1) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level_id` int(11) DEFAULT '1',
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `email` varchar(255) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `tel_no` varchar(14) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `tel_visible` tinyint(1) DEFAULT '1',
  `level_percent` int(11) DEFAULT '15',
  `response_rate` int(11) DEFAULT '100',
  `seen_last` datetime DEFAULT NULL,
  `seen_times` int(11) DEFAULT '0',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `surname` varchar(50) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `sex` tinyint(1) DEFAULT NULL,
  `email_kod` int(6) DEFAULT NULL,
  `email_check` tinyint(4) DEFAULT '0',
  `friends` int(11) DEFAULT '0',
  `face_check` tinyint(1) DEFAULT '0',
  `is_face_acount` tinyint(1) DEFAULT '0',
  `foto` varchar(100) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `foto_onay` tinyint(1) DEFAULT '1',
  `foto_exist` tinyint(1) DEFAULT '0',
  `active` tinyint(1) DEFAULT '1',
  `ban` tinyint(1) DEFAULT '0',
  `country` varchar(80) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `birthyear` int(11) DEFAULT '0',
  `description` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `level_id` (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Tablo döküm verisi `users`
--

INSERT INTO `users` (`id`, `level_id`, `password`, `email`, `tel_no`, `tel_visible`, `level_percent`, `response_rate`, `seen_last`, `seen_times`, `name`, `surname`, `sex`, `email_kod`, `email_check`, `friends`, `face_check`, `is_face_acount`, `foto`, `foto_onay`, `foto_exist`, `active`, `ban`, `country`, `birthyear`, `description`, `created_at`, `updated_at`) VALUES
(14, 1, 'e10adc3949ba59abbe56e057f20f883e', 'roota@root.com', NULL, 1, 15, 100, '2014-10-19 23:37:18', 2, 'Dasd', 'ASDSA', 1, 78014, 0, 0, 0, 0, 'http://localhost/XX/ikipedal//public/assets/male.png', 1, 0, 1, 0, NULL, 1982, 'Asdasd', '2014-10-19 17:07:53', '2014-10-19 21:00:40'),
(15, 1, 'e10adc3949ba59abbe56e057f20f883e', 'root@root.com', NULL, 1, 30, 100, '2014-10-24 00:10:43', 6, 'Aad', 'ASD', 1, 27506, 0, 0, 0, 0, 'http://localhost/XX/ikipedal//public/assets/male.png', 1, 0, 1, 0, NULL, 1992, NULL, '2014-10-19 21:01:31', '2014-10-23 21:10:43');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `user_level`
--

CREATE TABLE IF NOT EXISTS `user_level` (
  `level_id` int(11) NOT NULL AUTO_INCREMENT,
  `level` int(11) DEFAULT NULL,
  `tr_level` varchar(40) COLLATE utf8_turkish_ci DEFAULT NULL,
  `en_level` varchar(40) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`level_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=6 ;

--
-- Tablo döküm verisi `user_level`
--

INSERT INTO `user_level` (`level_id`, `level`, `tr_level`, `en_level`) VALUES
(1, 1, 'Yeni Üye', 'Beginner'),
(2, 2, 'Orta', 'Intermediate'),
(3, 3, 'Tecrübeli', 'Experienced'),
(4, 4, 'Uzman', 'Expert'),
(5, 5, 'Saygı Duyulan', 'Ambassador');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `warnings`
--

CREATE TABLE IF NOT EXISTS `warnings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `type` varchar(20) COLLATE utf8_turkish_ci DEFAULT 'warning',
  `warning` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL,
  `warning_en` varchar(300) COLLATE utf8_turkish_ci DEFAULT NULL,
  `is_read` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `admin_id` (`admin_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
