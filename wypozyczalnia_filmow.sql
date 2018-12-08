-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Gru 2018, 17:27
-- Wersja serwera: 10.1.34-MariaDB
-- Wersja PHP: 7.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wypozyczalnia_filmow`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `egzemplarz`
--

CREATE TABLE `egzemplarz` (
  `id_egzemplarz` int(11) NOT NULL,
  `id_film` int(11) NOT NULL,
  `status` char(1) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `egzemplarz`
--

INSERT INTO `egzemplarz` (`id_egzemplarz`, `id_film`, `status`) VALUES
(1, 1, 'w'),
(2, 1, 'w'),
(3, 1, 'w'),
(4, 2, 'w'),
(5, 3, 'w');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `film`
--

CREATE TABLE `film` (
  `id_film` int(11) NOT NULL,
  `tytul` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `rezyser` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `rok_produkcji` year(4) NOT NULL,
  `gatunek` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `film`
--

INSERT INTO `film` (`id_film`, `tytul`, `rezyser`, `rok_produkcji`, `gatunek`) VALUES
(1, 'Ip Man', 'Wilson Yip', 2008, 'Biograficzny'),
(2, 'Ojciec chrzestny', 'Francis Coppola', 1972, 'Dramat'),
(3, 'Król Lew', 'Rob Minkoff', 1994, 'Animacja'),
(4, 'Pulp Fiction', 'Quentin Tarrantino', 1995, 'Gangsterski'),
(5, 'Fight Club', 'David Fincher', 2000, 'Thriller'),
(6, 'Piękny umysł', 'Ron Howard', 2002, 'Biograficzny'),
(7, 'Pianista', 'Roman Polański', 2002, 'Dramat'),
(8, 'Milczenie owiec', 'Jonathan Demme', 1991, 'Thriller');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `klient`
--

CREATE TABLE `klient` (
  `id_klienta` int(11) NOT NULL,
  `imie` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `nazwisko` varchar(30) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` varchar(40) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `login` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `haslo` varchar(20) CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `wiek` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `klient`
--

INSERT INTO `klient` (`id_klienta`, `imie`, `nazwisko`, `email`, `login`, `haslo`, `wiek`) VALUES
(1, 'Jan', 'Kowalski', '', 'janekthebest', 'tajnehaslo', 21),
(2, 'Paweł', 'Mazur', '', 'Mazurek', 'mazurekogorek', 40),
(3, 'Wiktor', 'Bąk', '', 'wiktooor', 'jemnalesniki1234', 9),
(4, 'Piotr', 'Kwiecień', '', 'Piter123', 'plecien', 31);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pracownik`
--

CREATE TABLE `pracownik` (
  `id_paracownik` int(11) NOT NULL,
  `imie` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `nazwisko` varchar(30) COLLATE utf8mb4_polish_ci NOT NULL,
  `login` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL,
  `haslo` varchar(20) COLLATE utf8mb4_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `pracownik`
--

INSERT INTO `pracownik` (`id_paracownik`, `imie`, `nazwisko`, `login`, `haslo`) VALUES
(1, 'Arnold', 'Boczek', 'boczus', 'mojehaslo'),
(2, 'Tadeusz', 'Norek', 'tadzio1', 'kanalizacja89');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recenzja`
--

CREATE TABLE `recenzja` (
  `id_recenzja` int(11) NOT NULL,
  `ocena` smallint(6) NOT NULL,
  `opis` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `id_klient` int(11) NOT NULL,
  `id_film` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Zrzut danych tabeli `recenzja`
--

INSERT INTO `recenzja` (`id_recenzja`, `ocena`, `opis`, `id_klient`, `id_film`) VALUES
(1, 4, 'Swietny film, ale słabe zakończenie', 1, 3),
(2, 1, 'Beznadzieja, szkoda czasu', 2, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `wypozyczenie`
--

CREATE TABLE `wypozyczenie` (
  `id_wypozyczenie` int(11) NOT NULL,
  `id_egzemplarz` int(11) NOT NULL,
  `data_wypozyczenia` date NOT NULL,
  `data_oddania` date DEFAULT NULL,
  `id_klienta` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_polish_ci;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `egzemplarz`
--
ALTER TABLE `egzemplarz`
  ADD PRIMARY KEY (`id_egzemplarz`);

--
-- Indeksy dla tabeli `film`
--
ALTER TABLE `film`
  ADD PRIMARY KEY (`id_film`);

--
-- Indeksy dla tabeli `klient`
--
ALTER TABLE `klient`
  ADD PRIMARY KEY (`id_klienta`),
  ADD UNIQUE KEY `Login` (`login`);

--
-- Indeksy dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  ADD PRIMARY KEY (`id_paracownik`);

--
-- Indeksy dla tabeli `recenzja`
--
ALTER TABLE `recenzja`
  ADD PRIMARY KEY (`id_recenzja`);

--
-- Indeksy dla tabeli `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  ADD PRIMARY KEY (`id_wypozyczenie`),
  ADD UNIQUE KEY `id_egzemplarz` (`id_egzemplarz`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT dla tabeli `egzemplarz`
--
ALTER TABLE `egzemplarz`
  MODIFY `id_egzemplarz` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT dla tabeli `film`
--
ALTER TABLE `film`
  MODIFY `id_film` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT dla tabeli `klient`
--
ALTER TABLE `klient`
  MODIFY `id_klienta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `pracownik`
--
ALTER TABLE `pracownik`
  MODIFY `id_paracownik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `recenzja`
--
ALTER TABLE `recenzja`
  MODIFY `id_recenzja` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT dla tabeli `wypozyczenie`
--
ALTER TABLE `wypozyczenie`
  MODIFY `id_wypozyczenie` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
