-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 07. kvě 2015, 09:27
-- Verze serveru: 5.6.24
-- Verze PHP: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `hb_rocnikovka`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `articles_id` int(11) NOT NULL,
  `author_id` int(11) NOT NULL,
  `title` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(140) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `url`
--

CREATE TABLE IF NOT EXISTS `url` (
  `controller` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `alias` varchar(40) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `url`
--

INSERT INTO `url` (`controller`, `alias`) VALUES
('admin', 'admin'),
('article', 'clanek'),
('articles', 'clanky'),
('editor', 'editor'),
('error', 'chyba'),
('contact', 'kontakt'),
('settings', 'nastaveni'),
('summary', 'prehled'),
('login', 'prihlaseni'),
('register', 'registrace'),
('approve', 'schvalovani'),
('account', 'ucet'),
('user', 'uzivatel'),
('users', 'uzivatele');

-- --------------------------------------------------------

--
-- Struktura tabulky `url_commands`
--

CREATE TABLE IF NOT EXISTS `url_commands` (
  `command` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `alias` varchar(40) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `url_commands`
--

INSERT INTO `url_commands` (`command`, `alias`) VALUES
('vsechny', 'all'),
('moje', 'my'),
('remove-from-admin', 'odebrat-od-adminu'),
('logout', 'odhlasit'),
('add-to-admin', 'pridat-k-adminum'),
('delete', 'vymazat');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL,
  `nickname` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `password` char(255) COLLATE utf8_czech_ci NOT NULL,
  `email` varchar(100) COLLATE utf8_czech_ci NOT NULL,
  `admin` int(11) NOT NULL DEFAULT '0',
  `url` varchar(40) COLLATE utf8_czech_ci DEFAULT NULL,
  `description` varchar(500) COLLATE utf8_czech_ci NOT NULL,
  `motto` varchar(140) COLLATE utf8_czech_ci NOT NULL,
  `website` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `facebook` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `twitter` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `googleplus` varchar(80) COLLATE utf8_czech_ci NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`articles_id`), ADD UNIQUE KEY `unique_url` (`url`);

--
-- Klíče pro tabulku `url`
--
ALTER TABLE `url`
  ADD PRIMARY KEY (`controller`), ADD UNIQUE KEY `alias` (`alias`);

--
-- Klíče pro tabulku `url_commands`
--
ALTER TABLE `url_commands`
  ADD PRIMARY KEY (`command`), ADD UNIQUE KEY `alias` (`alias`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`users_id`), ADD UNIQUE KEY `nickname` (`nickname`), ADD UNIQUE KEY `url` (`url`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `articles`
--
ALTER TABLE `articles`
  MODIFY `articles_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=14;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
