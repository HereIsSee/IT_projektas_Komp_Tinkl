-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 11:51 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `renginiu_kalendorius_1`
--

-- --------------------------------------------------------

--
-- Table structure for table `miestas`
--

CREATE TABLE `miestas` (
  `id` int(11) NOT NULL,
  `miestas` varchar(255) NOT NULL,
  `kartu_panaudotas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `miestas`
--

INSERT INTO `miestas` (`id`, `miestas`, `kartu_panaudotas`) VALUES
(1, 'Kaunas', 18),
(2, 'Vilnius', 25),
(3, 'Klaipėda', 2),
(4, 'Šiauliai', 0);

-- --------------------------------------------------------

--
-- Table structure for table `mikrorajonas`
--

CREATE TABLE `mikrorajonas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `kartu_panaudotas` int(11) DEFAULT 0,
  `fk_miesto_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `mikrorajonas`
--

INSERT INTO `mikrorajonas` (`id`, `pavadinimas`, `kartu_panaudotas`, `fk_miesto_id`) VALUES
(1, 'Eiguliai', 15, 1),
(2, 'Dainava', 2, 1),
(3, 'Gričiupis', 1, 1),
(4, 'Žaliakalnis', 0, 1),
(5, 'Centras', 0, 1),
(6, 'Šančiai', 0, 1),
(7, 'Lazdynai', 2, 2),
(8, 'Vilkpėdė', 6, 2),
(9, 'Paneriai', 16, 2),
(10, 'Rasos', 1, 2),
(11, 'Antaklanis', 0, 2),
(12, 'Verkiai', 0, 2),
(13, 'Pilaitė', 0, 2),
(14, 'Pietinė Klaipėda', 1, 3),
(15, 'Šilutės plento rajonas', 0, 3),
(16, 'Centras', 1, 3),
(17, 'Senamiestis', 0, 3),
(18, 'Naujakiemio rajonas', 0, 3),
(19, 'Centras', 0, 4),
(20, 'Dainiai', 0, 4),
(21, 'Lieporiai', 0, 4),
(22, 'Gubernija', 0, 4),
(23, 'Zokniai', 0, 4);

-- --------------------------------------------------------

--
-- Table structure for table `renginiai_grupes`
--

CREATE TABLE `renginiai_grupes` (
  `fk_renginio_id` int(11) NOT NULL,
  `fk_socialines_grupes_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `renginiai_grupes`
--

INSERT INTO `renginiai_grupes` (`fk_renginio_id`, `fk_socialines_grupes_id`) VALUES
(143, 1),
(144, 1),
(145, 1),
(147, 1),
(148, 1),
(152, 1),
(143, 2),
(144, 2),
(145, 2),
(146, 2),
(147, 2),
(148, 2),
(149, 2),
(150, 2),
(152, 2),
(145, 3),
(146, 3),
(149, 3),
(150, 3),
(151, 3),
(145, 4),
(146, 4),
(143, 5),
(144, 5),
(146, 5),
(147, 5),
(149, 5),
(150, 5),
(144, 6),
(148, 6),
(148, 7);

-- --------------------------------------------------------

--
-- Table structure for table `renginio_tipas`
--

CREATE TABLE `renginio_tipas` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `kartu_panaudotas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `renginio_tipas`
--

INSERT INTO `renginio_tipas` (`id`, `pavadinimas`, `kartu_panaudotas`) VALUES
(1, 'Koncertas', 11),
(2, 'Paroda', 10),
(3, 'Teatro spektaklis', 6),
(4, 'Sporto varžybos', 29),
(5, 'Festivalis', 6),
(6, 'Konferacija', 9),
(7, 'Mugė', 7),
(8, 'Seminaras', 8),
(9, 'Edukacinė dirbtuvė', 6);

-- --------------------------------------------------------

--
-- Table structure for table `renginiu_nuotraukos`
--

CREATE TABLE `renginiu_nuotraukos` (
  `id` int(11) NOT NULL,
  `nuotraukos_kelias` varchar(255) NOT NULL,
  `fk_renginio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `renginiu_nuotraukos`
--

INSERT INTO `renginiu_nuotraukos` (`id`, `nuotraukos_kelias`, `fk_renginio_id`) VALUES
(25, '../assets/images/16/143/213309242-2cd5b590-5797-4fda-8acf-d587328f175a.jpg', 143),
(26, '../assets/images/16/143/download.jpg', 143),
(27, '../assets/images/16/143/sting-koncertas-kaune-6665ef1a0a34a.jpg', 143),
(28, '../assets/images/16/144/download (1).jpg', 144),
(29, '../assets/images/16/144/download (2).jpg', 144),
(30, '../assets/images/16/144/DSC_9165.jpg', 144),
(31, '../assets/images/16/145/1589778-495033-756x425.jpg', 145),
(32, '../assets/images/16/145/kaledine-muge-79783729.jpg', 145),
(33, '../assets/images/16/146/download (2).jpg', 146),
(34, '../assets/images/16/146/Eglutė_m_z-1881-e1604405737295.jpg', 146),
(35, '../assets/images/16/147/A02A3503.jpg', 147),
(36, '../assets/images/17/148/14b4bc50-7e17-11ed-ab81-a71b60a80a19.jpg', 148);

-- --------------------------------------------------------

--
-- Table structure for table `renginys`
--

CREATE TABLE `renginys` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `renginio_data` date NOT NULL,
  `aprasymas` mediumtext DEFAULT NULL,
  `adresas` varchar(255) DEFAULT NULL,
  `fk_seno_renginio_id` int(11) DEFAULT NULL,
  `fk_renginio_tipas_id` int(11) DEFAULT NULL,
  `fk_vip_vartotojo_id` int(11) NOT NULL,
  `fk_miesto_id` int(11) NOT NULL,
  `fk_mikrorajono_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `renginys`
--

INSERT INTO `renginys` (`id`, `pavadinimas`, `renginio_data`, `aprasymas`, `adresas`, `fk_seno_renginio_id`, `fk_renginio_tipas_id`, `fk_vip_vartotojo_id`, `fk_miesto_id`, `fk_mikrorajono_id`) VALUES
(143, 'Muzikos vakaras Žaliakalnyje', '2024-12-15', 'Kviečiame į gyvo garso koncertą Kaune, Žaliakalnyje! Vakaro metu išgirsite populiarias lietuvių bei užsienio grupių dainas, atliekamas profesionalių muzikantų. Ateikite praleisti laiką su muzika ir gera kompanija!', 'Savanorių pr. 123, Kaunas', NULL, 1, 16, 1, 4),
(144, 'Naujųjų metų muzikos vakaras', '2024-12-31', 'Kviečiame švęsti Naujuosius metus su gyvos muzikos koncertu Kauno Centre! Pasinerkite į šventinę nuotaiką su populiariais atlikėjais ir muzika, kurią visi mėgsta. Renginio metu lauks gyvi pasirodymai, puiki atmosfera ir geriausi naujametiniai prisiminimai!', 'Laisvės alėja 10, Kaunas', 143, 1, 16, 1, 5),
(145, 'Didžioji mugė!!!', '2025-01-06', 'Kviečiame į Didžiąją mugę Vilniuje, Rasų mikrorajone! Čia laukia įvairūs prekeiviai su vietiniais gaminiais, rankdarbiais ir kulinariniais šedevrais. Renginys skirtas visai šeimai – rasite užsiėmimų tiek vaikams, tiek suaugusiems. Ateikite ir praleiskite smagią dieną su kaimynais ir draugais!', 'Rasų g. 20, Vilnius', NULL, 7, 16, 2, 10),
(146, 'Kalėdų šventė Klaipėdoje', '2024-12-23', 'Kviečiame į šventinę Kalėdų šventę Klaipėdoje, Šilutės plento rajone! Renginys skirtas visai šeimai ir draugams – galėsite mėgautis šventine muzika, žaidimais, Kalėdų senelio pasirodymu bei šventiniu maistu. Ateikite ir pajuskite šventinę dvasią kartu su mumis!', 'Šilutės pl. 35, Klaipėda', NULL, 5, 16, 3, 15),
(147, 'Kalėdų šventė Kaune', '2024-12-23', 'Švęskime Kalėdas Kauno Dainavos mikrorajone su muzika, Kalėdų seneliu, žaidimais ir šventiniu maistu! Renginys skirtas visai šeimai ir draugams – laukia šventinė programa su gyva muzika, dirbtuvėlėmis ir dovanėlėmis vaikams. Ateikite pasinerti į Kalėdų nuotaiką ir praleiskite nuostabų laiką su artimaisiais!', 'V. Krėvės pr. 50, Kaunas', NULL, 5, 16, 1, 2),
(148, 'Sporto renginys \"Galim!\" ', '2024-12-21', 'Kviečiame visus sporto entuziastus į \'Galim!\' sporto varžybas Šiauliuose, Dainų mikrorajone! Dalyvaukite įvairiose rungtyse, stebėkite įspūdingus pasirodymus ir mėgaukitės sportine dvasia kartu su bendraminčiais. Tai puiki proga susitikti su draugais, aktyviai praleisti laiką ir išbandyti savo jėgas!', 'Sporto g. 12, Šiauliai', NULL, 4, 17, 4, 20),
(149, 'Žiemos festivalis \"Baltoji šventė\"', '2025-01-12', 'Prisijunkite prie žiemos festivalio \'Baltoji šventė\' Vilniuje! Mūsų laukia puikus laikas su žiemos pramogomis: nuo ledo skulptūrų parodų iki įvairių žaidimų ir veiklų vaikams bei suaugusiems. Tai puiki proga susirinkti drauge ir mėgautis žiemos grožiu.', 'Velnio g. 23', NULL, 4, 17, 2, 10),
(150, 'Kalėdinis teatro spektaklis', '2024-12-26', 'Kviečiame visus į Kalėdinį teatro spektaklį Vilniuje, Antakalnio rajone! Šventinio vakaro metu aktoriai pristatys klasikinius bei modernius pasirodymus, tinkamus visai šeimai. Ateikite mėgautis kūrybinga atmosfera ir įkvėpimu pripildyta švente!', 'Antakalnio g. 45, Vilnius', NULL, 3, 17, 2, 11),
(151, 'asdf', '2024-12-28', 'asf', 'sdf', NULL, 3, 17, 3, 15),
(152, 'Renginys kaune', '2024-12-20', 'Testavimio renginys', 'Velnio g. 23', 143, 3, 16, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `socialines_grupes`
--

CREATE TABLE `socialines_grupes` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `kartu_panaudotas` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `socialines_grupes`
--

INSERT INTO `socialines_grupes` (`id`, `pavadinimas`, `kartu_panaudotas`) VALUES
(1, 'Jaunimas', 12),
(2, 'Šeimos su vaikais', 10),
(3, 'Senjorai', 12),
(4, 'Verslininkai', 26),
(5, 'Meno ar kultūros entuziastai', 11),
(6, 'Sporto mėgėjai', 9),
(7, 'Akademinė bendruomenė', 10),
(8, 'Universiteto moksleiviai', 10);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojas`
--

CREATE TABLE `vartotojas` (
  `id` int(11) NOT NULL,
  `vardas` varchar(255) NOT NULL,
  `el_pastas` varchar(255) NOT NULL,
  `slaptazodis` varchar(255) NOT NULL,
  `vaidmuo` char(11) DEFAULT NULL,
  `vip_specializacija` int(11) DEFAULT NULL
) ;

--
-- Dumping data for table `vartotojas`
--

INSERT INTO `vartotojas` (`id`, `vardas`, `el_pastas`, `slaptazodis`, `vaidmuo`, `vip_specializacija`) VALUES
(14, 'vartotojas', 'vartotojas@vartotojas.com', '$2y$10$Ct8TTuHCt7LD2PmF/WM5EOGFMUc/0VpwOm55CT9NnQe2r26Eav7oy', 'vartotojas', NULL),
(15, 'admin', 'admin@admin.com', '$2y$10$gv9hvXWa/tPvSnYs65VP1uR1nWLzjDWHaJ0RiMuwkBng0JseSt/6G', 'admin', NULL),
(16, 'vip', 'vip@vip.com', '$2y$10$SwufT0v4HtKm.jq9b3yxTu79w9Nz/WhNBO5gW9UJFJreEXULrltKy', 'vip', 4),
(17, 'vip2', 'vip2@vip2.com', '$2y$10$PKKe1LWkhYs3Uakx1ta1Muq1eLSa0V3fXtmGAeFo3/Kr1pXJw7w.m', 'vip', 4),
(18, 'random', 'random@random.com', '$2y$10$McfmHXCXfmxaCk5NwZMtu.dORtbXDAVRPSQtsFkSgZKf0QysDonku', 'vip', 0),
(19, 'vartotojas1', 'vartotojas1@vartotojas1', '$2y$10$Mcwp0uumpKtwIEzCKdTDk.l4utmWfi0K2iyckrdb9U6I4VPS3h.8K', 'vartotojas', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojo_grupes_pasirinkimai`
--

CREATE TABLE `vartotojo_grupes_pasirinkimai` (
  `fk_socialines_grupes_id` int(11) NOT NULL,
  `fk_vartotojo_pasirinkimo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vartotojo_grupes_pasirinkimai`
--

INSERT INTO `vartotojo_grupes_pasirinkimai` (`fk_socialines_grupes_id`, `fk_vartotojo_pasirinkimo_id`) VALUES
(1, 58),
(2, 57),
(2, 58),
(3, 58),
(4, 58),
(5, 58),
(6, 58),
(7, 58),
(8, 58);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojo_pasirinkimai`
--

CREATE TABLE `vartotojo_pasirinkimai` (
  `id` int(11) NOT NULL,
  `pavadinimas` varchar(255) NOT NULL,
  `fk_vartotojo_id` int(11) NOT NULL,
  `fk_miesto_id` int(11) DEFAULT NULL,
  `fk_mikrorajono_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vartotojo_pasirinkimai`
--

INSERT INTO `vartotojo_pasirinkimai` (`id`, `pavadinimas`, `fk_vartotojo_id`, `fk_miesto_id`, `fk_mikrorajono_id`) VALUES
(57, 'Random prenumerata', 19, 1, 1),
(58, 'Main vartotojo prenumerata', 14, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `vartotojo_renginio_tipas_pasirinkimai`
--

CREATE TABLE `vartotojo_renginio_tipas_pasirinkimai` (
  `fk_vartotojo_pasirinkimo_id` int(11) NOT NULL,
  `fk_renginio_tipo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `vartotojo_renginio_tipas_pasirinkimai`
--

INSERT INTO `vartotojo_renginio_tipas_pasirinkimai` (`fk_vartotojo_pasirinkimo_id`, `fk_renginio_tipo_id`) VALUES
(58, 1),
(58, 2),
(58, 3),
(57, 4),
(58, 4),
(58, 5),
(58, 6),
(58, 7),
(58, 8),
(58, 9);

-- --------------------------------------------------------

--
-- Table structure for table `zinute`
--

CREATE TABLE `zinute` (
  `id` int(11) NOT NULL,
  `antraste` varchar(255) DEFAULT NULL,
  `aprasymas` varchar(1000) DEFAULT NULL,
  `perskaityta` tinyint(1) NOT NULL DEFAULT 0,
  `fk_vartotojo_id` int(11) NOT NULL,
  `fk_vartotojo_pasirinkimo_id` int(11) DEFAULT NULL,
  `fk_renginio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_lithuanian_ci;

--
-- Dumping data for table `zinute`
--

INSERT INTO `zinute` (`id`, `antraste`, `aprasymas`, `perskaityta`, `fk_vartotojo_id`, `fk_vartotojo_pasirinkimo_id`, `fk_renginio_id`) VALUES
(55, 'Naujas renginys!', '', 0, 14, 58, 152);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `miestas`
--
ALTER TABLE `miestas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mikrorajonas`
--
ALTER TABLE `mikrorajonas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_miesto_id` (`fk_miesto_id`);

--
-- Indexes for table `renginiai_grupes`
--
ALTER TABLE `renginiai_grupes`
  ADD PRIMARY KEY (`fk_socialines_grupes_id`,`fk_renginio_id`),
  ADD KEY `fk_renginio_id` (`fk_renginio_id`);

--
-- Indexes for table `renginio_tipas`
--
ALTER TABLE `renginio_tipas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `renginiu_nuotraukos`
--
ALTER TABLE `renginiu_nuotraukos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_renginio_id` (`fk_renginio_id`);

--
-- Indexes for table `renginys`
--
ALTER TABLE `renginys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_seno_renginio_id` (`fk_seno_renginio_id`),
  ADD KEY `fk_renginio_tipas_id` (`fk_renginio_tipas_id`),
  ADD KEY `fk_vip_vartotojo_id` (`fk_vip_vartotojo_id`),
  ADD KEY `fk_miesto_id` (`fk_miesto_id`),
  ADD KEY `fk_mikrorajono_id` (`fk_mikrorajono_id`);

--
-- Indexes for table `socialines_grupes`
--
ALTER TABLE `socialines_grupes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vartotojas`
--
ALTER TABLE `vartotojas`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `vardas` (`vardas`),
  ADD UNIQUE KEY `el_pastas` (`el_pastas`);

--
-- Indexes for table `vartotojo_grupes_pasirinkimai`
--
ALTER TABLE `vartotojo_grupes_pasirinkimai`
  ADD PRIMARY KEY (`fk_socialines_grupes_id`,`fk_vartotojo_pasirinkimo_id`),
  ADD KEY `fk_vartotojo_pasirinkimo_id` (`fk_vartotojo_pasirinkimo_id`);

--
-- Indexes for table `vartotojo_pasirinkimai`
--
ALTER TABLE `vartotojo_pasirinkimai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vartotojo_id` (`fk_vartotojo_id`),
  ADD KEY `fk_mikrorajono_id` (`fk_mikrorajono_id`),
  ADD KEY `fk_miesto_id` (`fk_miesto_id`);

--
-- Indexes for table `vartotojo_renginio_tipas_pasirinkimai`
--
ALTER TABLE `vartotojo_renginio_tipas_pasirinkimai`
  ADD PRIMARY KEY (`fk_renginio_tipo_id`,`fk_vartotojo_pasirinkimo_id`),
  ADD KEY `fk_vartotojo_pasirinkimo_id` (`fk_vartotojo_pasirinkimo_id`);

--
-- Indexes for table `zinute`
--
ALTER TABLE `zinute`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_vartotojo_id` (`fk_vartotojo_id`),
  ADD KEY `fk_vartotojo_pasirinkimo_id` (`fk_vartotojo_pasirinkimo_id`),
  ADD KEY `fk_renginio_id` (`fk_renginio_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `miestas`
--
ALTER TABLE `miestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `mikrorajonas`
--
ALTER TABLE `mikrorajonas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `renginio_tipas`
--
ALTER TABLE `renginio_tipas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `renginiu_nuotraukos`
--
ALTER TABLE `renginiu_nuotraukos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `renginys`
--
ALTER TABLE `renginys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `socialines_grupes`
--
ALTER TABLE `socialines_grupes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `vartotojas`
--
ALTER TABLE `vartotojas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vartotojo_pasirinkimai`
--
ALTER TABLE `vartotojo_pasirinkimai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=59;

--
-- AUTO_INCREMENT for table `zinute`
--
ALTER TABLE `zinute`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `mikrorajonas`
--
ALTER TABLE `mikrorajonas`
  ADD CONSTRAINT `mikrorajonas_ibfk_1` FOREIGN KEY (`fk_miesto_id`) REFERENCES `miestas` (`id`);

--
-- Constraints for table `renginiai_grupes`
--
ALTER TABLE `renginiai_grupes`
  ADD CONSTRAINT `renginiai_grupes_ibfk_1` FOREIGN KEY (`fk_renginio_id`) REFERENCES `renginys` (`id`),
  ADD CONSTRAINT `renginiai_grupes_ibfk_2` FOREIGN KEY (`fk_socialines_grupes_id`) REFERENCES `socialines_grupes` (`id`);

--
-- Constraints for table `renginiu_nuotraukos`
--
ALTER TABLE `renginiu_nuotraukos`
  ADD CONSTRAINT `renginiu_nuotraukos_ibfk_1` FOREIGN KEY (`fk_renginio_id`) REFERENCES `renginys` (`id`);

--
-- Constraints for table `renginys`
--
ALTER TABLE `renginys`
  ADD CONSTRAINT `fk_mikrorajono_id` FOREIGN KEY (`fk_mikrorajono_id`) REFERENCES `mikrorajonas` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `renginys_ibfk_1` FOREIGN KEY (`fk_seno_renginio_id`) REFERENCES `renginys` (`id`),
  ADD CONSTRAINT `renginys_ibfk_2` FOREIGN KEY (`fk_renginio_tipas_id`) REFERENCES `renginio_tipas` (`id`),
  ADD CONSTRAINT `renginys_ibfk_3` FOREIGN KEY (`fk_vip_vartotojo_id`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `renginys_ibfk_4` FOREIGN KEY (`fk_miesto_id`) REFERENCES `miestas` (`id`),
  ADD CONSTRAINT `renginys_ibfk_5` FOREIGN KEY (`fk_miesto_id`) REFERENCES `mikrorajonas` (`id`);

--
-- Constraints for table `vartotojo_grupes_pasirinkimai`
--
ALTER TABLE `vartotojo_grupes_pasirinkimai`
  ADD CONSTRAINT `vartotojo_grupes_pasirinkimai_ibfk_1` FOREIGN KEY (`fk_socialines_grupes_id`) REFERENCES `socialines_grupes` (`id`),
  ADD CONSTRAINT `vartotojo_grupes_pasirinkimai_ibfk_2` FOREIGN KEY (`fk_vartotojo_pasirinkimo_id`) REFERENCES `vartotojo_pasirinkimai` (`id`);

--
-- Constraints for table `vartotojo_pasirinkimai`
--
ALTER TABLE `vartotojo_pasirinkimai`
  ADD CONSTRAINT `vartotojo_pasirinkimai_ibfk_1` FOREIGN KEY (`fk_vartotojo_id`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `vartotojo_pasirinkimai_ibfk_2` FOREIGN KEY (`fk_mikrorajono_id`) REFERENCES `mikrorajonas` (`id`),
  ADD CONSTRAINT `vartotojo_pasirinkimai_ibfk_3` FOREIGN KEY (`fk_miesto_id`) REFERENCES `miestas` (`id`);

--
-- Constraints for table `vartotojo_renginio_tipas_pasirinkimai`
--
ALTER TABLE `vartotojo_renginio_tipas_pasirinkimai`
  ADD CONSTRAINT `vartotojo_renginio_tipas_pasirinkimai_ibfk_1` FOREIGN KEY (`fk_vartotojo_pasirinkimo_id`) REFERENCES `vartotojo_pasirinkimai` (`id`),
  ADD CONSTRAINT `vartotojo_renginio_tipas_pasirinkimai_ibfk_2` FOREIGN KEY (`fk_renginio_tipo_id`) REFERENCES `renginio_tipas` (`id`);

--
-- Constraints for table `zinute`
--
ALTER TABLE `zinute`
  ADD CONSTRAINT `fk_renginio_id` FOREIGN KEY (`fk_renginio_id`) REFERENCES `renginys` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `zinute_ibfk_1` FOREIGN KEY (`fk_vartotojo_id`) REFERENCES `vartotojas` (`id`),
  ADD CONSTRAINT `zinute_ibfk_2` FOREIGN KEY (`fk_vartotojo_pasirinkimo_id`) REFERENCES `vartotojo_pasirinkimai` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
