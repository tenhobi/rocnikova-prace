-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Počítač: localhost
-- Vygenerováno: Pon 04. kvě 2015, 11:06
-- Verze serveru: 5.1.73-14.12-log
-- Verze PHP: 5.3.10-1ubuntu3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `HB_rocnikovka`
--
CREATE DATABASE IF NOT EXISTS `HB_rocnikovka` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `HB_rocnikovka`;

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `articles_id` int(11) NOT NULL AUTO_INCREMENT,
  `author_id` int(11) NOT NULL,
  `title` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(140) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `content` text COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`articles_id`),
  UNIQUE KEY `unique_url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=10 ;

--
-- Vypisuji data pro tabulku `articles`
--

INSERT INTO `articles` (`articles_id`, `author_id`, `title`, `url`, `description`, `keywords`, `content`) VALUES
(6, 2, 'První článek od ne-admina', 'pisu-clanek-a-nejsem-admin', 'clanek od neadmina, který má velký úspěch', '', '<p>Nejlepší článek, a to je dokonce od <strong>neadmina</strong>!</p>'),
(7, 2, 'Ahojda s ID', 'ahojda-s-idckem-lasko', 'aaa', '', '<p>b<strong>v</strong>bb</p>'),
(8, 1, 'aaaaa', 'AAaaa', 'adfafdassdfasdfasdfasdfsadfasdfas', '', '<p>asdfasdfsadf asdf a<strong>sdf as</strong>df asdf asdadsfasdf</p>'),
(9, 13, 'Tomášek je nej', 'dezavi.cz', 'joooo má svůj web a hobi je nej :D', '', '<p>joooo má svůj web a hobi je nej :D</p>');

-- --------------------------------------------------------

--
-- Struktura tabulky `url`
--

CREATE TABLE IF NOT EXISTS `url` (
  `controller` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  `alias` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`controller`),
  UNIQUE KEY `alias` (`alias`)
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
  `alias` varchar(40) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`command`),
  UNIQUE KEY `alias` (`alias`)
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
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `googleplus` varchar(80) COLLATE utf8_czech_ci NOT NULL,
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `nickname` (`nickname`),
  UNIQUE KEY `url` (`url`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci AUTO_INCREMENT=14 ;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`users_id`, `nickname`, `password`, `email`, `admin`, `url`, `description`, `motto`, `website`, `facebook`, `twitter`, `googleplus`) VALUES
(2, 'HoBi', '$2y$10$H39w6z0yIA6vK./aAXGveune0mA9hZvcyyVQGwAt3ES9SXivQyV9u', '', 1, 'hobi', 'popisek', 'motto je nej', 'webovka', 'fb', 'twitter', 'gplus'),
(12, 'Batman', '$2y$10$eUvw3LulaGWEAJQep6KaV.qw0e8Obe0JHoZSLmrA6.nq9dA689igi', '', 0, 'batman', '', '', '', '', '', ''),
(13, 'tomas', '$2y$10$O1hibGQNLhO0544Z8haCq.U4eciGbL92z.KO.ZYcU.gwVd1FdW5A2', '', 1, 'tomas', '', '', '', '', '', '');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
