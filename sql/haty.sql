-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-06-13 15:45:17
-- サーバのバージョン： 10.4.18-MariaDB
-- PHP のバージョン: 8.0.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `haty`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `gift`
--

CREATE TABLE `gift` (
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `conditions` int(11) NOT NULL,
  `gift_name` varchar(30) NOT NULL,
  `post` date NOT NULL DEFAULT current_timestamp(),
  `applicant` int(11) DEFAULT NULL,
  `giftcomment` text DEFAULT NULL,
  `category` varchar(10) DEFAULT NULL,
  `judge` tinyint(1) DEFAULT NULL,
  `image` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `giftgroup`
--

CREATE TABLE `giftgroup` (
  `gift_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `good`
--

CREATE TABLE `good` (
  `gift_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `groupdb`
--

CREATE TABLE `groupdb` (
  `user_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `groupname` varchar(100) NOT NULL,
  `code` varchar(10000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `talk`
--

CREATE TABLE `talk` (
  `user_id` int(11) NOT NULL,
  `gift_id` int(11) NOT NULL,
  `id` int(11) NOT NULL,
  `comment` text NOT NULL,
  `post` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `user`
--

CREATE TABLE `user` (
  `uid` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `password` varchar(400) NOT NULL,
  `comment` text DEFAULT NULL,
  `icon` blob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `gift`
--
ALTER TABLE `gift`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `giftgroup`
--
ALTER TABLE `giftgroup`
  ADD PRIMARY KEY (`gift_id`,`group_id`),
  ADD KEY `gift_id` (`gift_id`),
  ADD KEY `group_id` (`group_id`);

--
-- テーブルのインデックス `good`
--
ALTER TABLE `good`
  ADD PRIMARY KEY (`gift_id`,`user_id`),
  ADD KEY `gift_id` (`gift_id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `groupdb`
--
ALTER TABLE `groupdb`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- テーブルのインデックス `talk`
--
ALTER TABLE `talk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `gift_id` (`gift_id`);

--
-- テーブルのインデックス `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`uid`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `gift`
--
ALTER TABLE `gift`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `groupdb`
--
ALTER TABLE `groupdb`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- テーブルの AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT;

--
-- ダンプしたテーブルの制約
--

--
-- テーブルの制約 `gift`
--
ALTER TABLE `gift`
  ADD CONSTRAINT `gift_ibfk_1` FOREIGN KEY (`id`) REFERENCES `giftgroup` (`gift_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- テーブルの制約 `groupdb`
--
ALTER TABLE `groupdb`
  ADD CONSTRAINT `groupdb_ibfk_1` FOREIGN KEY (`id`) REFERENCES `giftgroup` (`group_id`);

--
-- テーブルの制約 `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `good` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
