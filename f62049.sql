-- phpMyAdmin SQL Dump
-- version 3.5.FORPSI
-- http://www.phpmyadmin.net
--
-- Počítač: 81.2.194.146
-- Vygenerováno: Pon 12. led 2015, 11:14
-- Verze MySQL: 5.5.37-35.1-log
-- Verze PHP: 5.2.17

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `f62049`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `aktualni_karavany`
--

CREATE TABLE IF NOT EXISTS `aktualni_karavany` (
  `id_nabidka` int(11) NOT NULL AUTO_INCREMENT,
  `id_karavan` int(11) NOT NULL,
  `id_zaklad` int(11) NOT NULL,
  `datum_do` date NOT NULL,
  PRIMARY KEY (`id_nabidka`),
  KEY `id_karavan` (`id_karavan`),
  KEY `id_zaklad` (`id_zaklad`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `clanky`
--

CREATE TABLE IF NOT EXISTS `clanky` (
  `id_clanek` int(11) NOT NULL,
  `jazyk` int(2) NOT NULL DEFAULT '1',
  `id_autor` int(11) NOT NULL,
  `nadpis` text COLLATE utf8_czech_ci NOT NULL,
  `perex` text COLLATE utf8_czech_ci NOT NULL,
  `text` text COLLATE utf8_czech_ci NOT NULL,
  `novinka` tinyint(1) NOT NULL DEFAULT '0',
  `datum_vytvoreni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `kategorie` int(2) NOT NULL DEFAULT '10',
  `image` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  PRIMARY KEY (`id_clanek`,`jazyk`),
  KEY `id_autor` (`id_autor`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `clanky`
--

INSERT INTO `clanky` (`id_clanek`, `jazyk`, `id_autor`, `nadpis`, `perex`, `text`, `novinka`, `datum_vytvoreni`, `kategorie`, `image`) VALUES
(28212, 21, 1, 'Minikaravany a 1. sraz socialistických vozidel', '', '<p>30.5. &ndash; 1.6.2014 jsme se s&nbsp;na&scaron;im minikaravanem z&uacute;častnili 1. srazu socialistick&yacute;ch vozidel, kter&yacute; proběhnul na kempu Hnačov u Klatov.</p>', 0, '2014-09-05 07:17:42', 10, NULL),
(42003, 22, 1, 'Treffung von den Wagen aus sozialistischen Era.', 'Für zwei Tage ab 30.Mai wirde eine Treffung von den Wagen aus sozialistischen Era statt gefunden. Es war die erste Treffung und wir waren dabei.', '<p>F&uuml;r zwei Tage ab 30.Mai wirde eine Treffung von den Wagen aus sozialistischen Era statt gefunden. Es war die erste Treffung und wir waren dabei.</p>', 0, '2014-11-20 23:55:00', 12, NULL),
(51677, 21, 1, 'Minikaravany v regionální televizi', 'Regionální televize z východních Čech natočila o našich minikaravanech reportáž do svého pořadu AUTOMÁNIE. Pořad najdete ZDE, reportáž o minikaravanech začíná cca ve 12 minutě.', '<p>Region&aacute;ln&iacute; televize z v&yacute;chodn&iacute;ch Čech natočila o na&scaron;ich minikaravanech report&aacute;ž do sv&eacute;ho pořadu AUTOM&Aacute;NIE. Pořad najdete <strong><a title="ZDE" href="http://www.vctv.cz/archiv/video/automanie-04-09-2014-18-15" target="_blank">ZDE</a></strong>, report&aacute;ž o minikaravanech zač&iacute;n&aacute; cca ve 12 minutě.</p>', 0, '2014-09-11 04:28:11', 10, NULL),
(51677, 22, 1, 'Minicaravans in TV Sendung', 'In der regionalen TV Sendung konnten Sie eine Reportage sehen. HIER können Sie die Sendung sehen. Unser Spot fängt in der zwölfte Minute an.', '<p>In der regionalen TV Sendung konnten Sie eine Reportage sehen. HIER k&ouml;nnen Sie die Sendung sehen. Unser Spot f&auml;ngt in der zw&ouml;lfte Minute an.</p>', 1, '2014-11-20 23:09:46', 10, NULL),
(110990, 21, 1, 'Veletrh Lipsko', 'V listopadu budeme vystavovat na významném evropském veletrhu v Lipsku, který je zaměřený na caravaning a turistiku...', '<table>\n<tbody>\n<tr>\n<td>\n<p>Př&iacute;znivcům na&scaron;ich minikaravanů oznamujeme, že na&scaron;e modely budou k viděn&iacute; tento měs&iacute;c (listopadu 19. - 23.2014) v Lipsku (BRD) na veletrhu zaměřen&eacute;m na turistiku a caravaning. Odkaz na web lipsk&eacute;ho v&yacute;stavi&scaron;tě je zde:<a href="http://l.facebook.com/l.php?u=http%3A%2F%2Fwww.touristikundcaravaning.de%2F&amp;h=KAQH61FF6&amp;s=1">http://www.touristikundcaravaning.de/</a></p>\n</td>\n</tr>\n</tbody>\n</table>', 0, '2014-11-15 21:30:58', 12, NULL),
(136912, 22, 1, 'MINI COOPER Treffung in Peruc', 'Mini Cooper Fans hatten eine Trefung in Böhmen, in Peruc und wir waren dabei. Die treffung wurde zwischen 23. und 25.Mai statt gefunden.', '<p>Mini Cooper Fans hatten eine Trefung in B&ouml;hmen, in Peruc und wir waren dabei. Die treffung wurde zwischen 23. und 25.Mai statt gefunden.</p>', 1, '2014-11-20 23:54:25', 12, NULL),
(167679, 22, 1, 'Leipziger Messe', 'Im November wird sich unsere Firma auf der Leipziger Messe präsentieren. Die Messe spezialisiert sich für Camping und Caravaning.\nFür Minicaravan Fans melden wir, dass unsere Modelle weden ab…', '<p>Im November wird sich unsere Firma auf der Leipziger Messe pr&auml;sentieren. Die Messe spezialisiert sich f&uuml;r Camping und Caravaning.</p>\n<p>F&uuml;r Minicaravan Fans melden wir, dass unsere Modelle weden ab 19.bis 23. November in Leipzig zu sehen. Es findet sich eine Camping und Caravaning Messe statt. Link zur leipziger Messe:&nbsp;<a class="_553k" href="http://www.touristikundcaravaning.de/" target="_blank" rel="nofollow">http://www.touristikundcaravaning.de/</a></p>', 0, '2014-11-21 00:00:08', 12, NULL),
(187189, 21, 1, 'Minikaravany na výstavě Autosalon Litoměřice', 'Naše minikaravany jsme prezentovali na výstavě Autosalon na zahradě Čech, která se konala ve dnech 2. - 4. května 2014 na výstavišti v Litoměřicích. K vidění byl stylový minikaravan…', '<p>Na&scaron;e minikaravany jsme prezentovali na v&yacute;stavě Autosalon na zahradě Čech, kter&aacute; se konala ve dnech 2. - 4. května 2014 na v&yacute;stavi&scaron;ti v Litoměřic&iacute;ch. K viděn&iacute; byl stylov&yacute; minikaravan Caretta 1500 nebo mal&eacute; karavany česk&eacute; v&yacute;roby CityCaravan C5 a C6. Souč&aacute;st&iacute; na&scaron;&iacute; expozice bylo i několik vzorků audio/video syst&eacute;mů do karavanů.</p>', 0, '2014-09-04 21:13:42', 10, NULL),
(188012, 21, 1, 'Sraz MINI COOPERů na Peruci', 'Minikaravany se zúčastnily 6. Setkání příznivců vozů MINI COOPER na Peruci (okres Louny), které probíhalo ve dnech 23. – 25.5.2014.', '<p>Minikaravany se z&uacute;častnily 6. Setk&aacute;n&iacute; př&iacute;znivců vozů MINI COOPER na Peruci (okres Louny), kter&eacute; prob&iacute;halo ve dnech 23. &ndash; 25.5.2014.</p>\n<p><img src="../../www/gallery/articles/IMG_2866.JPG" alt="" width="200" height="160" />&nbsp;&nbsp;<img src="../../www/gallery/articles/IMG_2857.JPG" alt="" width="200" height="160" />&nbsp;&nbsp;<img src="../../www/gallery/articles/IMG_2898.JPG" alt="" width="200" height="160" />&nbsp;<img src="../../www/gallery/articles/IMG_2836.JPG" alt="" width="200" height="150" />&nbsp;&nbsp;<img src="../../www/gallery/articles/IMG_2856.JPG" alt="" width="200" height="150" /></p>', 0, '2014-09-25 08:03:54', 12, NULL),
(251498, 21, 1, 'Zveme vás na veletrh do Drážďan', 'Na přelomu ledna a února 2015 budeme vystavovat naše minikaravany na veletrhu cestovního ruchu v...', '<p>Zveme v&scaron;echny př&iacute;znivce na&scaron;ich minikaravanů do na&scaron;&iacute; expozice na veletrhu cestov&aacute;n&iacute;, kter&yacute; se kon&aacute; od 30.1. do 1.2.2015 na v&yacute;stavi&scaron;ti v Dr&aacute;žďanech. Budete si moct prohl&eacute;dnout modely C6, C1 a nově i outdoorovou verzi modelu C1. Info o veletrhu najdtete zde:&nbsp;<a href="http://l.facebook.com/l.php?u=http%3A%2F%2Fwww.dresdner-reisemarkt.de%2F&amp;h=PAQF_kxzX&amp;s=1">http://www.dresdner-reisemarkt.de/</a></p>', 0, '2015-01-06 14:14:06', 10, 'gallery/article/3w7or4qqq415nx107z13q34a.png'),
(251498, 22, 1, 'Wir laden Sie zur Messe nach Dresden', 'Wir möchten alle unsere Fans zu unserem Ausstellungsplatz auf dem Dresdner Reisemarkt ...', '<p>Wir m&ouml;chten alle unsere Fans zu unserem Ausstellungsplatz auf dem Dresdner Reisemarkt einzuladen. Das Reisemarkt findet sich von 30.1.2015 bis 1.2.2015 auf der dresdner Messe. Sie k&ouml;nnen die caravans C6, C1 und auch den neuen C1 - offroad. Hier gibt es ein Link f&uuml;rs Info vom dresdner Reisemarkt</p>', 0, '2015-01-06 17:40:59', 10, 'gallery/article/3w7or4qqq415nx107z13q34a.png'),
(253405, 21, 1, '1.sraz socialistických vozidel Hnačov', '30.5. – 1.6.2014 jsme se s našim minikaravanem zúčastnili 1. srazu socialistických vozidel, který proběhnul na kempu Hnačov u Klatov.', '<p>30.5. &ndash; 1.6.2014 jsme se s&nbsp;na&scaron;im minikaravanem z&uacute;častnili 1. srazu socialistick&yacute;ch vozidel, kter&yacute; proběhnul na kempu Hnačov u Klatov.</p>\n<p><img src="../../www/gallery/articles/IMG_2919.JPG" alt="" width="200" height="150" />&nbsp;&nbsp;<img src="../../www/gallery/articles/IMG_2922.JPG" alt="" width="200" height="150" /></p>', 0, '2014-09-25 08:33:23', 12, NULL),
(263151, 21, 1, 'Minikaravany na veletrhu v LIPSKU', 'V listopadu budeme vystavovat na významném evropském veletrhu v Lipsku, který je zaměřený na caravaning a turistiku...', '<p>Př&iacute;znivcům na&scaron;ich minikaravanů oznamujeme, že na&scaron;e modely budou k viděn&iacute; tento měs&iacute;c (listopadu 19. - 23.2014) v Lipsku (BRD) na veletrhu zaměřen&eacute;m na turistiku a caravaning. Odkaz na web lipsk&eacute;ho v&yacute;stavi&scaron;tě je zde:<a href="http://l.facebook.com/l.php?u=http%3A%2F%2Fwww.touristikundcaravaning.de%2F&amp;h=KAQH61FF6&amp;s=1" target="_blank" rel="nofollow nofollow">http://www.touristikundcaravaning.de/</a></p>', 0, '2014-11-15 19:20:46', 10, 'gallery/article/bp1zaiaf81vz18t3y8t9el08.jpg'),
(263151, 22, 1, 'Minicaravans auf der Leipziger Messe', 'Im November wird sich unsere Firma auf der Leipziger Messe präsentieren. Die Messe spezialisiert sich für Camping und Caravaning.\nFür Minicaravan Fans melden wir, dass unsere Modelle weden ab…', '<p>Im November wird sich unsere Firma auf der Leipziger Messe pr&auml;sentieren. Die Messe spezialisiert sich f&uuml;r Camping und Caravaning.</p>\n<p>F&uuml;r Minicaravan Fans melden wir, dass unsere Modelle weden ab 19.bis 23. November in Leipzig zu sehen. Es findet sich eine Camping und Caravaning Messe statt. Link zur leipziger Messe: <a class="_553k" href="http://www.touristikundcaravaning.de/" target="_blank" rel="nofollow">http://www.touristikundcaravaning.de/</a></p>', 1, '2014-11-20 23:28:30', 10, 'gallery/article/bp1zaiaf81vz18t3y8t9el08.jpg'),
(267949, 22, 1, 'Autosalon Louny', 'Am Anfang Juni (5.7.Juni) waren wir mit der Firma ASAS Most auf dem Autosalon in Louny. ASAS Most war der Verkäufer des Jahres 2013 in Tschechei. Fotos von diesem Autosalon finden Sie auf unserem…', '<p>Am Anfang Juni (5.7.Juni) waren wir mit der Firma ASAS Most auf dem Autosalon in Louny. ASAS Most war der Verk&auml;ufer des Jahres 2013 in Tschechei. Fotos von diesem Autosalon finden Sie auf unserem Facebook Profil.</p>', 0, '2014-11-20 23:58:09', 12, NULL),
(283076, 21, 1, 'Minikaravany na srazu MINI COOPERŮ', '', '<p>Minikaravany se z&uacute;častnily 6. Setk&aacute;n&iacute; př&iacute;znivců vozů MINI COOPER na Peruci (okres Louny), kter&eacute; prob&iacute;halo ve dnech 23. &ndash; 25.5.2014.</p>', 0, '2014-09-04 21:14:07', 10, NULL),
(283076, 22, 1, 'Minicaravans bei MINI FANS Treffung', 'Am 23 – 25.Mai waren wir an der sechsten Treffung von MINI COOPER Fans. Ein Caravan in typischen britischen Farben wurde hier vorgestellt.', '<p>Am 23 &ndash; 25.Mai waren wir an der sechsten Treffung von MINI COOPER Fans. Ein Caravan in typischen britischen Farben wurde hier vorgestellt.</p>', 1, '2014-11-20 23:07:18', 10, NULL),
(425170, 21, 1, 'Minikaravany a Víkend pro onkologicky nemocné děti', '', '<p>19. &ndash; 20.7.2014 dělaly na&scaron;e minikaravany radost onkologicky nemocn&yacute;m dětem na jejich akci Na farmě s&nbsp;želvičkou, kter&aacute; proběhla v&nbsp;Agropenzionu H&aacute;jenka ve Slavět&iacute;ně u Loun.</p>', 0, '2014-09-05 07:18:41', 10, NULL),
(425170, 22, 1, 'Minicaravans für onkologisch kranke Kinder', 'Am 19. Und 20. Juli haben wir ein Bisschen Freude gegeben und zwar den kranken Kindern. Wir nahmen an dem Programm „Auf der Farm mit Schildkröte“ teil. User Personal und Produkte waren für das…', '<p>Am 19. Und 20. Juli haben wir ein Bisschen Freude gegeben und zwar den kranken Kindern. Wir nahmen an dem Programm &bdquo;Auf der Farm mit Schildkr&ouml;te&ldquo; teil. User Personal und Produkte waren f&uuml;r das ganze Wochenende den Kindern zu Verf&uuml;gung um etwas Spa&szlig; in den schwierigen Zeiten zu &uuml;bergeben.&nbsp;</p>', 1, '2014-11-20 23:08:56', 10, NULL),
(486256, 21, 1, 'Autosalon Louny', 'Ve dnech 5.-7.6.2014 jsme vystavovali v Lounech...', '<p>V r&aacute;mci expozice firmy ASAS Most, kter&aacute; byla za rok 2013 vyhl&aacute;&scaron;ena prodejcem vozů značky KIA, jsme se z&uacute;častnili 5. &ndash; 7.6. 2014 lounsk&eacute;ho autosalonu. Fotoreport&aacute;ž z t&eacute;to akce najdete na na&scaron;em facebooku.</p>', 0, '2014-09-25 09:54:02', 12, NULL),
(492331, 22, 1, 'Autosalon Zahrada Cech', 'Unsere Caravans wurden auf der Messe in Litomerice präsentiert. Die Messe fand sich zwischen zweiten und vierten Mai statt. Ein Stylecaravan Caretta 1500 war zu sehen oder auch die Tschechische…', '<p>Unsere Caravans wurden auf der Messe in Litomerice pr&auml;sentiert. Die Messe fand sich zwischen zweiten und vierten Mai statt. Ein Stylecaravan Caretta 1500 war zu sehen oder auch die Tschechische CityCaravans C5 und C6. Wir zeigten auch verschiedene Typen von Audio und Video Systeme.</p>', 1, '2014-11-20 23:52:18', 12, NULL),
(551966, 21, 1, 'Minikaravany chystají půjčovnu', '', '<p>Od zač&aacute;tku sez&oacute;ny 2015 chyst&aacute;me spustit půjčovnu minikaravanů. K dispozici bude několik &uacute;rovn&iacute; v&yacute;bav, abychom dok&aacute;zali uspokojit různ&eacute; n&aacute;roky na&scaron;ich z&aacute;kazn&iacute;ků. V&iacute;ce informac&iacute; najdete v brzk&yacute;ch dnech na nov&eacute;m webu <a href="http://www.pujcovna-minikaravanu.cz" target="_blank">www.pujcovna-minikaravanu.cz</a>.</p>', 0, '2014-09-24 07:35:45', 10, NULL),
(551966, 22, 1, 'Caravan Verleih', 'Für  Start der Saison 2015 bereiten wir ein Caravan Verleih vor. Es werden verschiedene Typen und Ausstattungsniveau zu Verfügung. Weitere Info finden Sie an den Webseiten:…', '<p>F&uuml;r&nbsp; Start der Saison 2015 bereiten wir ein Caravan Verleih vor. Es werden verschiedene Typen und Ausstattungsniveau zu Verf&uuml;gung. Weitere Info finden Sie an den Webseiten: <a href="http://www.pujcovna-minikaravanu.cz/">www.pujcovna-minikaravanu.cz</a></p>', 1, '2014-11-20 23:10:58', 10, NULL),
(672377, 21, 1, 'Autosalon Liberec', 'Od 10. do 12. října 2014 si můžete prohlédnout naše minikaravany na...', '<p>Od 10. do 12. ř&iacute;jna 2014 si můžete prohl&eacute;dnout na&scaron;e minikaravany na v&yacute;stavě&nbsp;<a href="http://vystavy.diamantexpo.cz/kalendar/autosalon-liberec" target="_blank">Autosalon Liberec</a>.</p>', 0, '2014-09-25 12:24:44', 12, NULL),
(685703, 21, 1, 'Zveme vás na veletrh do Drážďan', 'Na přelomu ledna a února 2015 budeme vystavovat naše minikaravany na veletrhu cestovního ruchu v...', '<p>Zveme v&scaron;echny př&iacute;znivce na&scaron;ich minikaravanů do na&scaron;&iacute; expozice na veletrhu cestov&aacute;n&iacute;, kter&yacute; se kon&aacute; od 30.1. do 1.2.2015 na v&yacute;stavi&scaron;ti v Dr&aacute;žďanech. Budete si moct prohl&eacute;dnout modely C6, C1 a nově i outdoorovou verzi modelu C1. Info o veletrhu najdtete zde:&nbsp;<a href="http://l.facebook.com/l.php?u=http%3A%2F%2Fwww.dresdner-reisemarkt.de%2F&amp;h=PAQF_kxzX&amp;s=1">http://www.dresdner-reisemarkt.de/</a></p>', 0, '2015-01-06 14:22:25', 12, 'gallery/article/2lwhlbjqxc0quu42gpdpbzfe.jpg'),
(694405, 22, 1, 'Autosalon Liberec', 'Ab 10. bis 12. Oktober konnten Sie unsere Caravans auf dem Autosalon in Liberec sehen.', '<p>Ab 10. bis 12. Oktober konnten Sie unsere Caravans auf dem Autosalon in Liberec sehen.</p>', 0, '2014-11-20 23:58:39', 12, NULL),
(791857, 21, 1, 'Ochutnávka z Lipska 2014', 'Pár snímků z veletrhu v Lipsku 2014, který se zaměřuje na karavaning a cestování. Fotky najdete po kliknutí na nadpis článku.', '<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3633.JPG" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3634.JPG" alt="" width="280" height="210" /></p>\n<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3635.JPG" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp; <img src="../www/gallery/articles/IMG_3639.JPG" alt="" width="280" height="210" /></p>\n<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3649.JPG" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3650.JPG" alt="" width="280" height="210" /></p>\n<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3654.jpg" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3655.jpg" alt="" width="280" height="210" /></p>\n<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3662.jpg" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3663.jpg" alt="" width="280" height="210" /></p>\n<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3666.jpg" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3669.jpg" alt="" width="280" height="210" /></p>\n<p>&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3672.jpg" alt="" width="280" height="210" />&nbsp; &nbsp;&nbsp;<img src="../www/gallery/articles/IMG_3665.jpg" alt="" width="157" height="210" /></p>', 0, '2014-11-22 21:09:33', 10, 'gallery/article/0oywfqkfdkyq4h2llnw6322r.JPG'),
(858815, 21, 1, 'Autosalon Zahrada Čech', 'Naše minikaravany jsme prezentovali na výstavě Autosalon na zahradě Čech, která se konala ve dnech 2. - 4. května 2014 na výstavišti v Litoměřicích. K vidění byl stylový minikaravan…', '<p>Na&scaron;e minikaravany jsme prezentovali na v&yacute;stavě <a href="http://www.zahrada-cech.cz/akce/29-autosalon-na-zahrade-cech-a-veterani/" target="_blank">Autosalon na zahradě Čech</a>, kter&aacute; se konala ve dnech 2. - 4. května 2014 na v&yacute;stavi&scaron;ti v Litoměřic&iacute;ch. K viděn&iacute; byl stylov&yacute; minikaravan Caretta 1500 nebo mal&eacute; karavany česk&eacute; v&yacute;roby CityCaravan C5 a C6. Souč&aacute;st&iacute; na&scaron;&iacute; expozice bylo i několik vzorků audio/video syst&eacute;mů do karavanů.</p>\n<p>&nbsp;</p>\n<p><img src="../../www/gallery/articles/IMG_1291.jpg" alt="" width="200" height="148" />&nbsp;&nbsp;<img src="../../www/gallery/articles/IMG_1304.jpg" alt="" width="200" height="133" />&nbsp;&nbsp;<img src="../../www/gallery/articles/IMG_1307.jpg" alt="" width="200" height="113" /></p>', 0, '2014-09-25 07:21:48', 12, NULL),
(947966, 21, 1, 'Minikaravany na výstavě Autosalon Louny', '', '<p>V r&aacute;mci expozice firmy ASAS Most, kter&aacute; byla za rok 2013 vyhl&aacute;&scaron;ena prodejcem vozů značky KIA, jsme se z&uacute;častnili 5. &ndash; 7.6. 2014 lounsk&eacute;ho autosalonu. Fotoreport&aacute;ž z t&eacute;to akce najdete na na&scaron;em facebooku.</p>', 0, '2014-09-05 07:18:13', 10, NULL);

-- --------------------------------------------------------

--
-- Struktura tabulky `fotogalerie`
--

CREATE TABLE IF NOT EXISTS `fotogalerie` (
  `id_galerie` int(10) NOT NULL,
  `jazyk` int(2) NOT NULL,
  `nazev` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `popis` text CHARACTER SET utf8 COLLATE utf8_czech_ci,
  `hlavni_obrazek` varchar(255) DEFAULT NULL,
  `datum_vytvoreni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_galerie`,`jazyk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktura tabulky `galerie`
--

CREATE TABLE IF NOT EXISTS `galerie` (
  `id_foto` int(11) NOT NULL,
  `nazev` varchar(255) CHARACTER SET utf32 COLLATE utf32_czech_ci NOT NULL,
  `hlavni` tinyint(1) NOT NULL COMMENT 'Pokud je obrázek hlavní vlož 1',
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_foto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `galerie`
--

INSERT INTO `galerie` (`id_foto`, `nazev`, `hlavni`, `datum`) VALUES
(840299, '1iobx4uu2o2hejsq03lsjrfb.JPG', 0, '2014-11-15 20:00:12'),
(4258268, '7dzrp9t59uc7cqunghc5euhw.JPG', 0, '2014-09-16 12:07:11'),
(4889121, 'p61muunrs4xwsi5tss2r0rlq.JPG', 0, '2014-11-21 19:46:25'),
(5101381, 'px82c36on97mxp1skzyns83g.JPG', 0, '2014-11-21 19:23:18'),
(5766900, '9034kb1lmvgwkf4mc4ybupl9.JPG', 1, '2014-11-21 18:32:05'),
(5793368, '2tu5d02skyvqnf4bgsbdkaue.jpg', 1, '2014-11-21 18:43:06'),
(8002007, 'w3yiuw0z1k219qtx0vtt8znl.jpg', 0, '2014-11-25 18:09:13'),
(8590842, 'uhfg2oi3euucne52mf8tq5s5.jpg', 1, '2014-09-23 15:16:00'),
(8726509, '86ywtuqxt6fqzlycpqd97jex.JPG', 0, '2014-09-16 11:02:40'),
(9204381, 'v57tp1seamlzsocqm8rieusw.JPG', 0, '2014-11-15 21:21:21'),
(9705901, '3ijg95egb9ed3yby1oow9l1g.JPG', 0, '2014-11-15 21:24:01'),
(10380212, '6d8lwu31uas4b2t7q51z6l7x.jpg', 0, '2014-11-25 10:22:56'),
(10906420, '2mjqqohdc6sqetgo8rz8uudd.jpg', 0, '2014-11-21 19:18:57'),
(11554329, 'z6q27qaf46asrtpi3k21zv98.jpg', 0, '2014-11-25 18:09:12'),
(13673271, '9j7pbi70ego1915ttgti72b2.JPG', 0, '2014-11-15 21:24:23'),
(14245787, 'hmbvz1ekxl6dp6k2dbtekfso.jpg', 0, '2014-11-21 20:16:21'),
(15004607, 'g7p1rrlak9r1imijbirbazxq.jpg', 0, '2014-11-25 18:05:05'),
(16556869, 'iqn1i8zm9513w8p09vc2slqh.jpg', 0, '2014-11-25 18:09:13'),
(18110690, 'u6gzh8wmvblziwvp38bm7pp7.jpg', 0, '2014-11-25 11:30:30'),
(18392065, 't1grwa2ol76esag3em1mohof.jpg', 1, '2014-09-16 12:21:38'),
(19481376, '1swmyv6c636he4vwy2t7172z.jpg', 0, '2014-11-25 18:09:55'),
(19557313, '47ti68t7eq9kj65a5xh3h3p9.JPG', 0, '2014-11-21 19:42:13'),
(19581343, 'rqso96spu3y16xqgv077mgfw.JPG', 0, '2014-11-21 19:49:40'),
(21745766, 't0viuhq8elatvc67bavnrl5r.jpg', 0, '2014-11-25 10:17:59'),
(22795747, 'sfpwkp33v8e6t91kst5vgw1h.jpg', 0, '2014-11-25 10:17:58'),
(23218191, 'gc38o1o68wcle4ufu2a1ygnt.JPG', 0, '2014-11-15 21:20:32'),
(23689438, '89djf8hw248ycqndg5cmef1p.JPG', 1, '2014-11-21 18:29:04'),
(24528317, 'p54c9iuk21mbn0pxq2pj50ui.JPG', 0, '2014-11-15 21:24:02'),
(24954852, 'b94fjzwy494dolfc2hadd42s.JPG', 0, '2014-11-21 19:56:27'),
(25417111, 'owlyj9lrmm2pf06gjf5odem7.jpg', 0, '2014-11-25 10:17:59'),
(25593487, 'whx6xelwoh332nusr929ciyc.JPG', 0, '2014-11-21 19:39:09'),
(25842392, 'xpw646h4hzhuuebq7yytb9uh.JPG', 0, '2014-11-21 19:42:14'),
(26984932, 'ynydg8eu37rm5a7jiyjzt99c.jpg', 0, '2014-11-25 10:19:36'),
(28982617, 'zkzb30oaol9axbehhx8a15se.jpg', 0, '2014-11-25 18:09:14'),
(29328704, '5c32uy65v9ypjxuzsyhps17u.JPG', 0, '2014-11-21 19:49:41'),
(29367602, 'qk6wjjt9fp0ny2pqyypvg85d.JPG', 0, '2014-11-21 19:42:14'),
(29842353, 'dioon4jtar82uu76ntb2volp.jpg', 0, '2014-11-25 10:19:36'),
(32305030, 'w4qoj6ay1gy01eiuo88bpu9p.JPG', 0, '2014-11-15 21:24:02'),
(33689617, '3efu5yti11f2enn6ep7fu2t3.jpg', 0, '2014-11-25 10:23:17'),
(35850451, 'ffpvfji5chblp5ig0ikeio9t.JPG', 0, '2014-11-15 21:21:21'),
(40756624, 'vv0pl0pulvcuyx71ciwdwoa3.JPG', 0, '2014-11-21 19:42:15'),
(41095484, 'x1icrjs6azyg8vaq9zzded4k.jpg', 0, '2014-11-25 10:17:59'),
(41433614, 'ljpwwtebrpgjob28dwad1w8t.JPG', 0, '2014-09-16 12:21:38'),
(43048679, '3pfl2fymb9fihwuvraemwtfu.jpg', 0, '2014-11-25 18:09:14'),
(44945067, 'rawz9ppm51ltyelm4myn456o.JPG', 1, '2014-09-16 11:02:40'),
(45811511, '0obq7fgxfmhnedtrm8rsgvqf.JPG', 0, '2014-11-21 19:39:09'),
(47390344, 'a9klmm953s7dt1dj1v00rafa.jpg', 0, '2014-11-25 18:09:55'),
(47676574, 'vld809lzpntmjigxf12aiiv0.jpg', 1, '2014-11-21 17:59:28'),
(47693752, 'qs9suhsrtb7ghktfr732xd8m.jpg', 0, '2014-11-25 18:09:55'),
(49177058, 'icw107pwskc4u3y271xm0fed.JPG', 0, '2014-11-21 19:42:13'),
(49254664, 's6ge0vf1kruzj7zamdpa3t7v.JPG', 0, '2014-11-21 20:10:42'),
(50108859, '0rouknvz9p4presbu4kbedof.jpg', 0, '2014-11-21 20:16:21'),
(50130661, 'awnqkf4h6gl9xbtyhr1n55xq.jpg', 0, '2014-11-25 11:31:07'),
(50321451, 'eu1c3uwx9h6hhy9nud15hax9.jpg', 0, '2014-11-21 20:11:56'),
(50362839, 'a3tp3k4tdz3r1je6bcq97gyc.JPG', 1, '2014-11-21 18:41:26'),
(54094564, 'mvwoptso4f75vbkcez7pqnda.jpg', 0, '2014-11-25 18:09:13'),
(54439531, 'erfavruhhu64n09iq817rdca.JPG', 1, '2014-11-15 21:02:19'),
(57619184, 't46j9bx1fmf0vkheuo86k495.JPG', 0, '2014-11-15 21:22:29'),
(58976941, 'gy58ou07e6l9cz4m7pqem8wp.jpg', 0, '2014-11-25 10:17:59'),
(59035050, 'h39hsvzay7zlha8vzdk3d178.jpg', 0, '2014-11-25 10:19:36'),
(59969623, 'j5146oewbjjf548rqh0opf1s.jpg', 0, '2014-11-25 10:19:36'),
(60059630, 'd224jym7m97aibx7plvmk5nj.JPG', 0, '2014-11-21 19:49:41'),
(60538382, '682ofpckvfyuquqk7jvg33xz.jpg', 0, '2014-11-25 10:19:36'),
(61063490, 'xm9j0e4nmgopv7pdq4t1ausx.JPG', 1, '2014-11-21 18:39:32'),
(61180608, '573i8zv5ttml9vxx8v5jssjz.jpg', 0, '2014-11-25 18:09:55'),
(63273470, 'frrj2pre5vbn0rjsblwri63n.JPG', 1, '2014-11-15 19:33:09'),
(63302213, 'amw7jkfu5ngls25gzldb7bka.JPG', 0, '2014-11-15 21:22:28'),
(63538068, '5bkdpyocwgg54ovlg3kzbvta.jpg', 1, '2014-11-25 18:02:54'),
(63687461, '09de332yv6mb0tr9xsu3f7sj.JPG', 0, '2014-11-15 21:22:28'),
(64449830, 'wf0u911tupecbv479im1ptqg.jpg', 0, '2014-11-25 18:09:13'),
(65212444, 'mi0w779bs0gq5tiatf52xcm5.JPG', 0, '2014-11-21 19:46:25'),
(65727215, 'db9na15da2kxdrjofn5rmht3.jpg', 0, '2014-11-25 10:19:36'),
(66863083, 'a8zep056chsreh8yp3c9yz4d.jpg', 1, '2014-11-25 10:17:58'),
(67910645, '9ae75kcqkhichvq5yrxhuy2e.JPG', 0, '2014-11-21 20:02:54'),
(68117463, 'nq6kzscr9fwtenlwjonfb3g0.JPG', 0, '2014-11-21 19:54:59'),
(73890960, '14el76l0qpjzqrit24e1tdam.jpg', 0, '2014-11-25 18:09:55'),
(74659250, 'thf6rjryqmgg77mo4qoyflce.jpg', 0, '2014-11-25 18:09:55'),
(75482669, '7mswl85txccscy0sax2eh5zw.jpg', 0, '2014-11-25 18:09:13'),
(76137654, 'e5ido143x8oz531xwhrur9m3.JPG', 0, '2014-11-21 19:46:24'),
(76582661, 'gwr6k16s4ye4is95dz3786j0.JPG', 0, '2014-11-21 19:46:25'),
(80035324, 'h4grhxfo4us5xpeehonlh5j0.JPG', 0, '2014-11-15 21:24:23'),
(80421538, 'hyc9xwhqp5ask2dvnd54a6jv.JPG', 1, '2014-11-15 20:00:11'),
(81591353, 'gokekxj0ynh5mshust3ihf77.JPG', 0, '2014-11-21 20:11:56'),
(81639127, 'tfg00pdynos747j67b2678eq.JPG', 0, '2014-11-15 21:21:21'),
(81678122, 'ttrrggsco5si7xfzlgh85ahc.JPG', 0, '2014-11-15 21:22:28'),
(82354534, 'lw566gxb9jvhpmhuo0pm70cj.jpg', 0, '2014-09-16 11:03:13'),
(83996809, 'sby46kxd12gc1vxjszbvekq7.jpg', 0, '2014-11-25 10:19:36'),
(84298627, '833wj8uxnp2n69v8oun214pk.JPG', 0, '2014-11-15 21:20:47'),
(85906299, 'lsc24oaysf8aqsm3ih0kqgrt.JPG', 0, '2014-11-21 19:42:14'),
(86103876, 'j84r1w3l6ay1fyyvn8ctj99u.JPG', 1, '2014-09-16 12:07:11'),
(86904192, '7x44dj7qu1mywpc88owv8a40.JPG', 1, '2014-11-21 18:32:51'),
(87111579, 'eow2atct50kodw10ecqm2cxz.jpg', 0, '2014-11-25 10:17:59'),
(88795319, 'oek1o56f8o3t8wdxaxrt5r4e.jpg', 0, '2014-11-21 19:18:57'),
(88992675, 'lpwqbsdny0ps54bo7naoulgb.JPG', 0, '2014-11-21 19:49:41'),
(89060725, 'tu6ijjgejvnaqa9dz7yvnns7.JPG', 0, '2014-11-15 21:21:21'),
(89767911, '1w4dwjktyt25k697idpl32cb.jpg', 0, '2014-11-25 11:31:07'),
(93021767, 'w8f97f0yis2wgc7ysbkywquu.JPG', 0, '2014-11-15 21:24:02'),
(94998660, '5qlpj8yen8c9u2ca6dfqembj.jpg', 0, '2014-11-25 10:17:58'),
(95456004, 'xt4b7oy0q09v872dvrmxvb8y.jpg', 0, '2014-11-25 18:09:13'),
(97514143, 'z2d8q26p6wkv8z1j0epnbzj9.jpg', 0, '2014-11-25 18:09:55'),
(98164171, '886b91y6do0le8g2c19ucuvg.JPG', 0, '2014-11-15 21:24:23'),
(98794130, 'c51pkvi5nzs3doq0jk69j0ab.jpg', 0, '2014-11-25 18:09:55'),
(99780719, 'bqh8t242vgzba9fw0m9nv81f.jpg', 0, '2014-11-25 11:31:07');

-- --------------------------------------------------------

--
-- Struktura tabulky `galerie_kategorie`
--

CREATE TABLE IF NOT EXISTS `galerie_kategorie` (
  `id_kategorie` int(11) NOT NULL,
  `id_karavan` int(11) NOT NULL,
  `jazyk` int(2) NOT NULL DEFAULT '21',
  `id_foto` int(11) NOT NULL,
  KEY `id_kategorie` (`id_kategorie`),
  KEY `id_karavan` (`id_karavan`),
  KEY `id_foto` (`id_foto`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `galerie_kategorie`
--

INSERT INTO `galerie_kategorie` (`id_kategorie`, `id_karavan`, `jazyk`, `id_foto`) VALUES
(1, 812255, 21, 68706119),
(1, 812255, 21, 17123619),
(1, 812255, 21, 42709244),
(2, 812255, 21, 53774983),
(2, 812255, 21, 65298720),
(2, 812255, 21, 17996005),
(2, 812255, 21, 62778684),
(2, 812255, 21, 93684719),
(2, 812255, 21, 54940008),
(2, 812255, 21, 94447208),
(1, 494301, 21, 34891855),
(2, 494301, 21, 90851824),
(2, 494301, 21, 57488656),
(2, 494301, 21, 38342799),
(2, 494301, 21, 57188390),
(3, 494301, 21, 32205874),
(3, 494301, 21, 57805067),
(3, 494301, 21, 49073715),
(1, 494301, 21, 73041671),
(4, 494301, 21, 64710550),
(4, 494301, 21, 96559646),
(4, 494301, 21, 27454171),
(4, 494301, 21, 70329274),
(1, 360036, 21, 8726509),
(1, 360036, 21, 82354534),
(1, 205947, 21, 4258268),
(1, 435831, 21, 41433614),
(1, 611599, 21, 27454694),
(1, 75403, 21, 29011224),
(2, 225653, 21, 840299),
(2, 75403, 21, 4572828),
(2, 385290, 21, 381983),
(1, 385290, 21, 23218191),
(1, 385290, 21, 84298627),
(3, 385290, 21, 89060725),
(3, 385290, 21, 81639127),
(3, 385290, 21, 9204381),
(3, 385290, 21, 35850451),
(4, 385290, 21, 63302213),
(4, 385290, 21, 81678122),
(4, 385290, 21, 63687461),
(4, 385290, 21, 57619184),
(2, 385290, 21, 9705901),
(2, 385290, 21, 93021767),
(2, 385290, 21, 24528317),
(2, 385290, 21, 32305030),
(2, 385290, 21, 13673271),
(2, 385290, 21, 80035324),
(2, 385290, 21, 98164171),
(5, 897571, 21, 4267516),
(5, 897571, 21, 84700781),
(2, 611599, 21, 10906420),
(2, 611599, 21, 88795319),
(2, 75403, 21, 5101381),
(7, 385290, 22, 25593487),
(7, 385290, 22, 45811511),
(8, 385290, 22, 19557313),
(8, 385290, 22, 49177058),
(8, 385290, 22, 29367602),
(8, 385290, 22, 85906299),
(8, 385290, 22, 25842392),
(8, 385290, 22, 40756624),
(9, 385290, 22, 76137654),
(9, 385290, 22, 4889121),
(9, 385290, 22, 65212444),
(9, 385290, 22, 76582661),
(10, 385290, 22, 19581343),
(10, 385290, 22, 29328704),
(10, 385290, 22, 88992675),
(10, 385290, 22, 60059630),
(8, 225653, 22, 68117463),
(8, 75403, 22, 24954852),
(7, 435831, 22, 67910645),
(7, 205947, 22, 49254664),
(8, 360036, 22, 81591353),
(8, 360036, 22, 50321451),
(8, 611599, 22, 50108859),
(8, 611599, 22, 14245787),
(1, 951935, 21, 22795747),
(1, 951935, 21, 94998660),
(1, 951935, 21, 41095484),
(1, 951935, 21, 21745766),
(1, 951935, 21, 87111579),
(1, 951935, 21, 25417111),
(1, 951935, 21, 58976941),
(2, 951935, 21, 29842353),
(2, 951935, 21, 59035050),
(2, 951935, 21, 65727215),
(2, 951935, 21, 83996809),
(2, 951935, 21, 59969623),
(2, 951935, 21, 60538382),
(2, 951935, 21, 26984932),
(11, 951935, 21, 10380212),
(1, 951935, 21, 33689617),
(1, 951935, 21, 18110690),
(2, 951935, 21, 50130661),
(2, 951935, 21, 89767911),
(2, 951935, 21, 99780719),
(12, 951935, 22, 15004607),
(7, 951935, 22, 11554329),
(7, 951935, 22, 75482669),
(7, 951935, 22, 8002007),
(7, 951935, 22, 54094564),
(7, 951935, 22, 64449830),
(7, 951935, 22, 95456004),
(7, 951935, 22, 16556869),
(7, 951935, 22, 28982617),
(7, 951935, 22, 43048679),
(8, 951935, 22, 73890960),
(8, 951935, 22, 74659250),
(8, 951935, 22, 97514143),
(8, 951935, 22, 98794130),
(8, 951935, 22, 47693752),
(8, 951935, 22, 47390344),
(8, 951935, 22, 61180608),
(8, 951935, 22, 19481376);

-- --------------------------------------------------------

--
-- Struktura tabulky `hlavni_obrazky_karavany`
--

CREATE TABLE IF NOT EXISTS `hlavni_obrazky_karavany` (
  `id_foto` int(11) NOT NULL,
  `id_karavan` int(11) NOT NULL,
  `jazyk` int(2) NOT NULL DEFAULT '21',
  KEY `id_foto` (`id_foto`),
  KEY `id_karavan` (`id_karavan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `hlavni_obrazky_karavany`
--

INSERT INTO `hlavni_obrazky_karavany` (`id_foto`, `id_karavan`, `jazyk`) VALUES
(66794125, 812255, 21),
(44945067, 360036, 21),
(86103876, 205947, 21),
(18392065, 435831, 21),
(24333459, 494301, 21),
(8590842, 611599, 21),
(22549761, 933806, 21),
(88086137, 931333, 21),
(63273470, 75403, 21),
(80421538, 225653, 21),
(54439531, 385290, 21),
(2115975, 897571, 21),
(58117359, 897571, 22),
(97532147, 476345, 21),
(18776587, 476345, 22),
(24130048, 895667, 21),
(79468516, 895667, 22),
(2495527, 766967, 21),
(63199827, 766967, 22),
(47676574, 611599, 22),
(23689438, 75403, 22),
(5766900, 225653, 22),
(86904192, 385290, 22),
(61063490, 360036, 22),
(50362839, 205947, 22),
(5793368, 435831, 22),
(66863083, 951935, 21),
(63538068, 951935, 22);

-- --------------------------------------------------------

--
-- Struktura tabulky `karavany`
--

CREATE TABLE IF NOT EXISTS `karavany` (
  `id_karavan` int(11) NOT NULL,
  `jazyk` int(2) NOT NULL DEFAULT '21',
  `id_zaklad` int(11) DEFAULT NULL,
  `znacka` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `typ` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `cena` float NOT NULL COMMENT 'Kč bez DPH',
  `sirka` int(3) NOT NULL COMMENT 'cm',
  `delka` int(3) NOT NULL COMMENT 'cm',
  `vyska` int(3) NOT NULL COMMENT 'cm',
  `nastavba_sirka` int(3) DEFAULT NULL,
  `nastavba_delka` int(3) DEFAULT NULL,
  `nastavba_vyska` int(3) DEFAULT NULL,
  `vyska_vnitrni` int(3) DEFAULT '0',
  `sirka_vnitrni` int(3) DEFAULT '0',
  `luzko_delka` int(3) DEFAULT NULL COMMENT 'cm',
  `luzko_sirka` int(3) DEFAULT NULL COMMENT 'cm',
  `hmotnost_p` int(4) DEFAULT NULL COMMENT 'pohotovostni [kg]',
  `hmotnost_pb` int(4) DEFAULT NULL COMMENT 'pohotovostni brzdena [kg]',
  `hmotnost_c` int(4) DEFAULT NULL COMMENT 'celkova [kg]',
  `hmotnost_t` int(4) DEFAULT NULL COMMENT 'technicka povolena [kg]',
  `hmotnost_max` int(4) DEFAULT NULL COMMENT 'maximalni',
  `podvozek` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `exterier` text COLLATE utf8_czech_ci,
  `podvozek2` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `pneu` varchar(30) COLLATE utf8_czech_ci DEFAULT NULL,
  `napajeni` varchar(20) COLLATE utf8_czech_ci DEFAULT NULL,
  `datum_vlozeni` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `vybava` text COLLATE utf8_czech_ci NOT NULL COMMENT 'Standardní výbava',
  `popis` text COLLATE utf8_czech_ci,
  `specialni_edice` text COLLATE utf8_czech_ci,
  `barva` varchar(50) COLLATE utf8_czech_ci DEFAULT NULL,
  `eshop_link` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`id_karavan`,`jazyk`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `karavany`
--

INSERT INTO `karavany` (`id_karavan`, `jazyk`, `id_zaklad`, `znacka`, `typ`, `cena`, `sirka`, `delka`, `vyska`, `nastavba_sirka`, `nastavba_delka`, `nastavba_vyska`, `vyska_vnitrni`, `sirka_vnitrni`, `luzko_delka`, `luzko_sirka`, `hmotnost_p`, `hmotnost_pb`, `hmotnost_c`, `hmotnost_t`, `hmotnost_max`, `podvozek`, `exterier`, `podvozek2`, `pneu`, `napajeni`, `datum_vlozeni`, `vybava`, `popis`, `specialni_edice`, `barva`, `eshop_link`) VALUES
(75403, 21, NULL, 'CityCaravan', 'C6 - základní verze', 160000, 188, 368, 186, 180, 280, 130, 128, 0, 195, 180, 300, NULL, NULL, 750, 390, 'KNOTT', 'Jako doplněk lze zvolit stan, kempingový nábytek a další vybavení', '', 'R13', '220V + 12V', '2014-11-07 11:38:17', 'střešní okno s moskytiérou a noční roletkou, 2x boční okno s moskytiérou a noční roletkou, zásuvka 230 V, 1x zásuvka 12V/USB, 1x spodní boční skříňka s výsuvnou kuchyňkou, standardní lůžko 180 x 200 cm, levá horní skříňka, hlavní stropní světlo', '', '', 'bílá', ''),
(75403, 22, NULL, 'CityCaravan', 'C6 - Basic Version', 160000, 188, 368, 186, 180, 280, 130, 128, 0, 195, 180, 300, NULL, NULL, 750, 390, 'KNOTT', 'Als Sonderausstattung ist möglich ein Zelt, Campingmöbel und auch weitere Ausstattung wählen.', '', 'R13', '220V + 12V', '2014-11-20 23:50:29', 'Dachfenster mit dem Moskitonetz und mit dem Stoffrollo, 2x Seitenfenster mit dem Moskitonetz und mit dem Stoffrollo, Steckdose 230 V, 1x Steckdose 12V/USB, 1x unterer Schrank mit der ausziehbaren Küchenplatte, Standardbett 180 x 200 cm, linker Oberschrank, haupte Deckenleuchte', '', '', 'Weiß', ''),
(205947, 21, NULL, 'CityCaravan', 'C5 Light 2013 - SKLADEM (ihned k dodání)', 97695, 188, 368, 186, 180, 280, 130, 0, 0, 0, 0, 750, 0, 0, 750, 250, 'KNOTT', '', '', 'R13', '12V', '2014-09-16 11:58:17', 'rozvod a zásuvka 12V, střešní okno, stropní svítilna', '', '', 'bílá', ''),
(205947, 22, NULL, 'CityCaravan', 'C5 Light 2013 - Auf Lager (sofort verfügbar)', 97695, 188, 368, 186, 180, 280, 130, 0, 0, 0, 0, 750, NULL, NULL, 750, 250, 'KNOTT', '', '', 'R13', '12V', '2014-11-20 23:09:50', 'elektrischer Strom – Verteilung 12V, Dachhaube, Deckenleuchte', '', '', 'Weiß', ''),
(225653, 21, 75403, 'CityCaravan', 'C6 - střední verze', 200000, 188, 368, 186, 180, 280, 130, 0, 0, 195, 180, 400, NULL, NULL, 750, 460, 'KNOTT', 'Jako doplněk lze zvolit stan, kempingový nábytek a další vybavení', '', 'R13', '230V, 12V, solár', '2014-11-15 19:56:36', 'střešní okno s moskytiérou a noční roletkou, 2x boční okno s moskytiérou a noční roletkou, zásuvka 230 V, 2x zásuvky 12 V/USB, solární panel, dřevěné obložení, 2x vrchní boční skříňky, 2x spodní boční skříňky, výsuvná kuchyň, dřez, lednice campingaz 36 l, 2x matrace s roštem, 2x přenosná lampička (+ čas, datum, teplota) s USB konektorem', '', '', 'bílá', ''),
(225653, 22, 75403, 'CityCaravan', 'C6 - Mittel Version', 200000, 188, 368, 186, 180, 280, 130, 0, 0, 195, 180, 400, NULL, NULL, 750, 460, 'KNOTT', 'Als Sonderausstattung ist möglich ein Zelt, Campingmöbel und auch weitere Ausstattung wählen.', '', 'R13', '230V, 12V, solar', '2014-11-20 23:55:59', 'Dachfenster mit dem Moskitonetz und mit dem Stoffrollo, 2x Seitenfenster mit dem Moskitonetz und mit dem Stoffrollo, 2x Steckdose 12V/USB, Solarenergie, holze Auskleidung(Interier), 2x oberer Seitenschrank, 2x unterer Seitenschrank, ausziehbare Küchenplatte, Spüllebecken, Kühlschrank campingaz 36l, Matratze mit dem Rost, 2x tragbare Lampe (Zeit, Datum, Temperatur), mit dem USB Stecker', '', '', 'Weiß', ''),
(360036, 21, NULL, 'CityCaravan', 'C5 - SKLADEM (ihned k dodání)', 137980, 188, 368, 186, 180, 280, 130, 0, 0, 195, 180, 750, 0, 0, 750, 300, 'KNOTT', '', '', 'R13', '230V, 12V', '2014-09-16 11:00:58', 'polstrované sedátko se skříňkou, vrchní skříňka 28x27x65 cm, kuchyňská skříňka s chladničkou 36L, sklápěcí stůl 35x70 cm, elektrický rozvod 12V, střešní okno, další přídavné stropní okno, stropní svítilna, 2x matrace 9x90x195 cm, čelní skříňky. Zadní dveře otevírané zespoda nahoru.', '', '', 'Polep', ''),
(360036, 22, NULL, 'CityCaravan', 'C5 - Auf Lager (sofort verfügbar)', 137980, 188, 368, 186, 180, 280, 130, 0, 0, 195, 180, 750, NULL, NULL, 750, 300, 'KNOTT', '', '', 'R13', '230V, 12V', '2014-11-20 22:35:19', 'gepolsterter Schemel mit dem Schrank, Oberschrank 28x27x65 cm, Küchenschrank mit der Kühlschrank 36L, Klapptisch 35x70 cm, elektrischer Strom – Verteilung 12V, Dachhaube,  nächste Zusatz Deckenhaube, Deckenleuchte, 2x Matratze 90x90x195 cm, Frontschränke. Die Hintertür werdet es sich von unten nach oben öffnen.', '', '', 'Beklebung', ''),
(385290, 21, 75403, 'CityCaravan', 'C6 - plná verze', 240000, 188, 368, 186, 180, 280, 130, 0, 0, 195, 180, 460, NULL, NULL, 750, 460, 'KNOTT', 'Jako doplněk lze zvolit stan, kempingový nábytek a další vybavení', '', 'R13', '230V, 12V, solár', '2014-11-15 20:57:59', 'střešní okno s moskytiérou a noční roletkou, 2x boční okno s moskytiérou a noční roletkou, zásuvka 230 V, 4x zásuvky 12 V/USB, solární panel, dřevěné obložení, 2x vrchní boční skříňky, 2x spodní boční skříňky, výsuvná kuchyň, dřez, vodní systém, plynový přenosný vařič, lednice campingaz 36 l, 2x matrace s roštem, stan, 2x kempingové skládací židle, 1x kempingový stůl, 2x přenosná lampička (+ čas, datum, teplota) s USB konektorem', '', '', 'bílá', ''),
(385290, 22, 75403, 'CityCaravan', 'C6 - Voll Version', 240000, 188, 368, 186, 180, 280, 130, 0, 0, 195, 180, 460, NULL, NULL, 750, 460, 'KNOTT', 'Als Sonderausstattung ist möglich ein Zelt, Campingmöbel und auch weitere Ausstattung wählen.', '', 'R13', '230V, 12V, solar', '2014-11-20 23:59:10', 'Dachfenster mit dem Moskitonetz und mit dem Stoffrollo, 2x Seitenfenster mit dem Moskitonetz und mit dem Stoffrollo, 4x Steckdose 12V/USB, Solarenergie, holze Auskleidung(Interier), 2x oberer Seitenschrank, 2x unterer Seitenschrank, ausziehbare Küchenplatte, Spüllebecken, Wassersystem, tragbarer Gaskocher, Kühlschrank campingaz 36l, Matratze mit dem Rost, Schlauzelt, 2x Camping Klappstuhl, 1x Camping Klapptisch, 2x tragbare Lampe (Zeit, Datum, Temperatur), mit dem USB Stecker', '', '', 'Weiß', ''),
(435831, 21, NULL, 'CityCaravan', 'C5 Active 2014 polep - SKLADEM (ihned k dodání)', 133880, 188, 368, 186, 180, 280, 130, 0, 0, 0, 0, 750, 0, 0, 750, 250, 'KNOTT', '', '', 'R13', '12V', '2014-09-16 12:20:47', 'polstrované sedátko, vrchní skříňka 28x27x65 cm, kuchyňská skříňka s chladničkou 36L, sklápěcí stůl 35x70 cm, elektrický rozvod 12V, střešní okno, stropní svítilna', '', '', 'bílá + polep', ''),
(435831, 22, NULL, 'CityCaravan', 'C5 Active 2014 mit der Beklebung - Auf Lager', 133880, 188, 368, 186, 180, 280, 130, 0, 0, 0, 0, 750, NULL, NULL, 750, 250, 'KNOTT', '', '', 'R13', '12V', '2014-11-20 23:37:53', 'gepolsterter Schemel, Oberschrank 28x27x65 cm, Küchenschrank mit der Kühlschrank 36L, Klapptisch 35x70 cm, elektrischer Strom – Verteilung 12V, Dachhaube, Deckenleuchte', '', '', 'Weiß mit der Beklebung', ''),
(611599, 21, NULL, 'CityCaravan', 'C5 2013/14 -SKLADEM (ihned k dodání)', 100720, 188, 368, 186, 180, 280, 130, 0, 0, 0, 0, 750, 0, 0, 750, 250, 'KNOTT', '', '', 'R13', '12V', '2014-09-16 12:18:14', 'střešní okno, stropní svítilna', '', '', 'bílá', ''),
(611599, 22, NULL, 'CityCaravan', 'C5 2013/14 - Auf Lager (sofort verfügbar)', 100720, 188, 368, 186, 180, 280, 130, 0, 0, 0, 0, 750, NULL, NULL, 750, 250, 'KNOTT', '', '', 'R13', '12V', '2014-11-20 23:15:22', 'Dachhaube, Deckenleuchte', '', '', 'Weiß', ''),
(951935, 21, NULL, 'CityCaravan', 'C1 - Active', 129900, 178, 318, 186, 130, 200, 120, 0, 0, 195, 130, 195, NULL, NULL, 750, 190, 'KNOTT', 'Jako doplněk lze zvolit přídavný boční stolek, stan, kempingový nábytek a další vybavení', '', 'R13', '230V, 12V', '2014-11-25 10:12:27', 'postel 130 x 195 cm, úložný prostor pod postelí, část roštu posuvná, sklápěcí stůl, 2 malé skříňky u podlahy, horní skříňka, zásuvka 230V-1x, zásuvka 12V - 1x, boční okno 65x35 cm, střešní okno 25x25 cm, 13PIN zástrčka B+', '', '', 'stříbrná', ''),
(951935, 22, NULL, 'CityCaravan', 'C1 - Active', 129900, 178, 318, 186, 130, 200, 120, 0, 0, 195, 130, 195, NULL, NULL, 750, 190, 'KNOTT', 'Als Sonderausstattung ist möglich ein zusatzlicher abbklappbarer Tisch, ein Zelt, Campingmöbel und auch weitere Ausstattung wählen.', '', 'R13', '230V, 12V', '2014-11-25 17:59:28', 'Bett-Liegefläche 130 x 195 cm, Lagerfläche unter dem Bett, Teil des Rostes ist ausziehbar, Klapptisch, 2 kleine Schränke beim Boden, oberer Seitenschrank, Steckdose 230V - 1x, Seitenfenster 65 x 35 cm, Dachhaube 25 x 25 cm, 13 Poliger Stecken B+', '', '', 'stříbrná', '');

-- --------------------------------------------------------

--
-- Struktura tabulky `karavany_typy`
--

CREATE TABLE IF NOT EXISTS `karavany_typy` (
  `id_zaklad` int(11) NOT NULL,
  `id_kar` int(11) NOT NULL,
  PRIMARY KEY (`id_zaklad`,`id_kar`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `karavany_typy`
--

INSERT INTO `karavany_typy` (`id_zaklad`, `id_kar`) VALUES
(812255, 931333),
(812255, 933806);

-- --------------------------------------------------------

--
-- Struktura tabulky `karavany_vybava`
--

CREATE TABLE IF NOT EXISTS `karavany_vybava` (
  `id_karavan` int(11) NOT NULL,
  `jazyk` int(2) NOT NULL DEFAULT '21',
  `id_vybava` int(11) NOT NULL,
  KEY `id_karavan` (`id_karavan`),
  KEY `id_vybava` (`id_vybava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `karavany_vybava`
--

INSERT INTO `karavany_vybava` (`id_karavan`, `jazyk`, `id_vybava`) VALUES
(205947, 21, 1),
(617492, 21, 2),
(75403, 21, 3),
(225653, 21, 4),
(225653, 21, 5),
(225653, 21, 6),
(225653, 21, 7),
(225653, 21, 8),
(225653, 21, 9),
(225653, 21, 10),
(225653, 21, 11),
(225653, 21, 12),
(225653, 21, 13),
(225653, 21, 14),
(225653, 21, 15),
(385290, 21, 11),
(385290, 21, 18),
(385290, 21, 12),
(385290, 21, 13),
(385290, 21, 14),
(385290, 21, 15),
(75403, 21, 11),
(75403, 21, 12),
(75403, 21, 13),
(75403, 21, 14),
(75403, 21, 15),
(897571, 21, 31),
(897571, 22, 32),
(476345, 21, 33),
(951935, 21, 12),
(951935, 21, 13),
(951935, 21, 14),
(951935, 21, 15),
(435831, 22, 40),
(435831, 22, 41),
(951935, 22, 42);

-- --------------------------------------------------------

--
-- Struktura tabulky `kategorie`
--

CREATE TABLE IF NOT EXISTS `kategorie` (
  `id_kategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `poradi` int(3) NOT NULL,
  PRIMARY KEY (`id_kategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=13 ;

--
-- Vypisuji data pro tabulku `kategorie`
--

INSERT INTO `kategorie` (`id_kategorie`, `nazev`, `poradi`) VALUES
(1, 'Exteriér', 1),
(2, 'Interiér', 2),
(3, 'Kuchyň', 4),
(4, 'Stanová přístavba', 5),
(7, 'Exterieur', 1),
(8, 'Interieur', 2),
(9, 'Küche', 4),
(10, 'Vorzelt', 5),
(11, 'Doplňky', 3),
(12, 'Zubehör', 3);

-- --------------------------------------------------------

--
-- Struktura tabulky `log_prihlaseni`
--

CREATE TABLE IF NOT EXISTS `log_prihlaseni` (
  `id_log` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `ip` varchar(20) COLLATE utf8_czech_ci NOT NULL,
  `datum` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_log`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `nastaveni`
--

CREATE TABLE IF NOT EXISTS `nastaveni` (
  `id_jazyk` int(2) NOT NULL,
  `tax_rate` int(2) NOT NULL,
  `exchange_rate` float NOT NULL,
  PRIMARY KEY (`id_jazyk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `nastaveni`
--

INSERT INTO `nastaveni` (`id_jazyk`, `tax_rate`, `exchange_rate`) VALUES
(21, 21, 1),
(22, 21, 0.0377);

-- --------------------------------------------------------

--
-- Struktura tabulky `sestavy`
--

CREATE TABLE IF NOT EXISTS `sestavy` (
  `id_sestava` int(11) NOT NULL AUTO_INCREMENT,
  `id_karavan` int(11) NOT NULL,
  `cena` int(5) NOT NULL COMMENT 'Kč bez DPH',
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id_sestava`),
  KEY `id_karavan` (`id_karavan`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Struktura tabulky `sestavy_vybava`
--

CREATE TABLE IF NOT EXISTS `sestavy_vybava` (
  `id_sestava` int(11) NOT NULL,
  `id_vybava` int(11) NOT NULL,
  PRIMARY KEY (`id_sestava`,`id_vybava`),
  KEY `id_vybava` (`id_vybava`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `jmeno` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `prijmeni` varchar(30) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(50) COLLATE utf8_czech_ci NOT NULL,
  `heslo` varchar(60) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=2 ;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `jmeno`, `prijmeni`, `email`, `heslo`) VALUES
(1, 'Admin', '', 'admin@minikaravany.cz', '$2y$10$2dHW.dhnIMMtODY84UKaU...N5K5bS5tKSFa4C9NW8IDVfyeUkZZu');

-- --------------------------------------------------------

--
-- Struktura tabulky `vybava_specialni`
--

CREATE TABLE IF NOT EXISTS `vybava_specialni` (
  `id_vybava` int(11) NOT NULL AUTO_INCREMENT,
  `nazev` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `cena` int(5) NOT NULL COMMENT 'Kč bez DPH',
  `popis` text COLLATE utf8_czech_ci,
  PRIMARY KEY (`id_vybava`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=43 ;

--
-- Vypisuji data pro tabulku `vybava_specialni`
--

INSERT INTO `vybava_specialni` (`id_vybava`, `nazev`, `cena`, `popis`) VALUES
(1, 'Počet kusů', 0, 'Na skladě 3 kusy tohoto modelu.'),
(2, 'německá výbava', 41552, 'fweioih'),
(11, 'Televize 17"', 13223, ''),
(12, 'Nafukovací stan', 10901, ''),
(13, 'Campingová židle', 1149, ''),
(14, 'Campingový stůl', 1149, ''),
(15, 'Campingový vařič s kartuší', 1114, ''),
(17, 'Televize 17"', 13223, ''),
(19, 'Nafukovací stan', 10901, ''),
(20, 'Campingová židle', 1149, ''),
(21, 'Campingový stůl', 1149, ''),
(22, 'Campingový vařič s kartuší', 1114, ''),
(23, 'Campingový toastovač', 289, ''),
(24, 'Televize 17"', 13223, ''),
(25, 'Nafukovací stan', 10901, ''),
(26, 'Campingová židle', 1149, ''),
(27, 'Campingový stůl', 1149, ''),
(28, 'Campingový vařič s kartuší', 1114, ''),
(29, 'Campingový toastovač', 289, ''),
(31, 'NEJAKA VEC_TEST', 555, 'POKUS'),
(32, 'NEJAK VEC_POKUS DE', 5, 'NEMECKY'),
(33, 'TEST CZ', 555, 'cz'),
(34, 'Nafukovací stan', 10901, ''),
(35, 'Campingová židle', 1149, ''),
(36, 'Campingový stůl', 1149, ''),
(37, 'Campingový vařič s kartuší', 1114, ''),
(38, 'Campingový toastovač', 289, ''),
(39, 'Campingový toastovač', 289, ''),
(40, 'Fernseher 17"', 599, ''),
(41, 'Schlauchzelt', 498, ''),
(42, 'aaaaaaaaaa', 5555, 'hhhhhhhhhh');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
