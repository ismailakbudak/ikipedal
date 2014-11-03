-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 19 Eki 2014, 21:35:28
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
('46b9d7a49db0c3b81c5607ffe8e51115', '127.0.0.1', 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:33.0) Gecko/20100101 Firefox/33.0', 1413754141, 'a:10:{s:9:"user_data";s:0:"";s:4:"word";s:5:"64139";s:4:"time";d:1413754273.7033601;s:5:"image";s:128:"<img src="http://localhost/XX/ikipedal//public/captcha/1413754273.7034.jpg" width="110" height="30" style="border:0;" alt=" " />";s:6:"userid";s:88:"KU77Ay6/FtzpOn6ym9DgR2oxpE93v1ZwrxmbDivjqyynlDYjOjf8vOVS1MJz74Z3u/LXYu9nHLXN+VZF+MufsA==";s:4:"name";s:88:"nNYFXDnvvG0nAL3WTIuMLSD1gTa6WyXLQZzYCSYb+0d2GI2wFn7jKMchPYlPgGXaqCBz2Tmhyq2EBTe4pG+qFw==";s:7:"surname";s:88:"ngGAA/PhWs4Pb3gse4CjOGVT4JNg9qeKmoHHBXqIu6A0zPCNPuLQUsu7OHG2pEA+GZYln1KiavG69vlZnX5Uqw==";s:3:"sex";s:88:"5nzUEWwK7p9/D6s6NET1mvqwKh155NJG4RECjrHeU9otndOIvYxp52tO8H9hM/vpGupZDtQk933O8e3UKpw1jw==";s:4:"foto";s:128:"XBfqm76mI+OiG1uN0VQVKlILaRNAxX2Cqc4SmSZdJMiJP762AScxCchIJRBaPIcnJrR9dfvbTs9krLGPb97u0F6nBAonZtoHb4Gps421fTyl8usB0S6E0b28iVO2mDdl";s:9:"logged_in";b:1;}');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `email_alerts_result`
--

CREATE TABLE IF NOT EXISTS `email_alerts_result` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email_alert_id` int(11) DEFAULT NULL,
  `ride_offer_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `email_alert_id` (`email_alert_id`),
  KEY `ride_offer_id` (`ride_offer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=3 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=313 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=87 ;

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
-- Tablo için tablo yapısı `offer_created`
--

CREATE TABLE IF NOT EXISTS `offer_created` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ride_offer_id` int(11) DEFAULT NULL,
  `departure_place` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `arrivial_place` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `dLat` float DEFAULT NULL,
  `dLng` float DEFAULT NULL,
  `price` int(11) DEFAULT NULL,
  `price_class` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
  `distance` double DEFAULT NULL,
  `time` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=11 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=14 ;

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
-- Tablo için tablo yapısı `ride_offers`
--

CREATE TABLE IF NOT EXISTS `ride_offers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
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
  `real_distance` varchar(70) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `real_time` varchar(70) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `total_distance` varchar(70) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `total_time` varchar(70) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `explain_departure` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `explain_return` varchar(300) CHARACTER SET utf8 COLLATE utf8_turkish_ci DEFAULT NULL,
  `explain_approval` tinyint(1) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `searched`
--

CREATE TABLE IF NOT EXISTS `searched` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT '0',
  `origin` varchar(100) COLLATE utf8_turkish_ci DEFAULT 'Türkiye',
  `lat` float DEFAULT '30',
  `lng` float DEFAULT '24',
  `originStatus` tinyint(1) DEFAULT '1',
  `destination` varchar(100) COLLATE utf8_turkish_ci DEFAULT '',
  `dLat` float DEFAULT '-1',
  `dLng` float DEFAULT '-1',
  `destinationStatus` tinyint(1) DEFAULT '0',
  `is_active` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=276 ;

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
(15, 1, 'e10adc3949ba59abbe56e057f20f883e', 'root@root.com', NULL, 1, 15, 100, '2014-10-20 00:31:29', 1, 'Aad', 'ASD', 1, 27506, 0, 0, 0, 0, 'http://localhost/XX/ikipedal//public/assets/male.png', 1, 0, 1, 0, NULL, 1992, NULL, '2014-10-19 21:01:31', '2014-10-19 21:31:29');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `ways_offer`
--

CREATE TABLE IF NOT EXISTS `ways_offer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ride_offer_id` int(11) DEFAULT NULL,
  `departure_place` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `lat` float DEFAULT NULL,
  `lng` float DEFAULT NULL,
  `arrivial_place` varchar(100) COLLATE utf8_turkish_ci DEFAULT NULL,
  `dLat` float DEFAULT NULL,
  `dLng` float DEFAULT NULL,
  `distance` double DEFAULT NULL,
  `time` varchar(20) COLLATE utf8_turkish_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `ride_offer_id` (`ride_offer_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci AUTO_INCREMENT=11 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
