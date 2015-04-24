-- phpMyAdmin SQL Dump
-- version 4.2.7
-- http://www.phpmyadmin.net
--
-- Machine: localhost
-- Gegenereerd op: 24 apr 2015 om 10:57
-- Serverversie: 5.5.39
-- PHP-versie: 5.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databank: `zoofzoof_project`
--

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zoof_pictures`
--

CREATE TABLE IF NOT EXISTS `zoof_pictures` (
`pid` int(11) NOT NULL,
  `tag` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uid` varchar(200) NOT NULL,
  `likes` int(11) NOT NULL,
  `url` varchar(200) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=65 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zoof_system`
--

CREATE TABLE IF NOT EXISTS `zoof_system` (
`id` int(11) NOT NULL,
  `wipetime` int(11) NOT NULL,
  `last_date_wipe` date NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zoof_userComments`
--

CREATE TABLE IF NOT EXISTS `zoof_userComments` (
`cid` int(11) NOT NULL,
  `uid` varchar(200) NOT NULL,
  `pid` int(11) NOT NULL,
  `comment` varchar(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zoof_userlist`
--

CREATE TABLE IF NOT EXISTS `zoof_userlist` (
`lid` int(11) NOT NULL,
  `uid` varchar(200) NOT NULL,
  `tag` varchar(40) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `start_photo` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=577 ;

-- --------------------------------------------------------

--
-- Tabelstructuur voor tabel `zoof_users`
--

CREATE TABLE IF NOT EXISTS `zoof_users` (
  `phone_id` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `alias` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Anonymous',
`uid` int(11) NOT NULL,
  `alias_unique` tinyint(1) NOT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=32 ;

--
-- Indexen voor geëxporteerde tabellen
--

--
-- Indexen voor tabel `zoof_pictures`
--
ALTER TABLE `zoof_pictures`
 ADD PRIMARY KEY (`pid`);

--
-- Indexen voor tabel `zoof_system`
--
ALTER TABLE `zoof_system`
 ADD PRIMARY KEY (`id`);

--
-- Indexen voor tabel `zoof_userComments`
--
ALTER TABLE `zoof_userComments`
 ADD PRIMARY KEY (`cid`);

--
-- Indexen voor tabel `zoof_userlist`
--
ALTER TABLE `zoof_userlist`
 ADD PRIMARY KEY (`lid`);

--
-- Indexen voor tabel `zoof_users`
--
ALTER TABLE `zoof_users`
 ADD PRIMARY KEY (`uid`);

--
-- AUTO_INCREMENT voor geëxporteerde tabellen
--

--
-- AUTO_INCREMENT voor een tabel `zoof_pictures`
--
ALTER TABLE `zoof_pictures`
MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=65;
--
-- AUTO_INCREMENT voor een tabel `zoof_system`
--
ALTER TABLE `zoof_system`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT voor een tabel `zoof_userComments`
--
ALTER TABLE `zoof_userComments`
MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT voor een tabel `zoof_userlist`
--
ALTER TABLE `zoof_userlist`
MODIFY `lid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=577;
--
-- AUTO_INCREMENT voor een tabel `zoof_users`
--
ALTER TABLE `zoof_users`
MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=32;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
