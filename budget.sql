-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 24 Paź 2021, 18:10
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `budget`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expenses`
--

CREATE TABLE `expenses` (
  `expenseID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `paymentWayID` int(11) NOT NULL,
  `data` date NOT NULL,
  `amount` float NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expense_categories`
--

CREATE TABLE `expense_categories` (
  `expenseCatID` int(11) NOT NULL,
  `expenseCatName` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `IfDefault` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `expense_categories`
--

INSERT INTO `expense_categories` (`expenseCatID`, `expenseCatName`, `IfDefault`) VALUES
(1, 'Jedzenie', 1),
(2, 'Mieszkanie', 1),
(3, 'Transport', 1),
(4, 'Telekomunikacja', 1),
(5, 'Opieka zdrowotna', 1),
(6, 'Ubranie', 1),
(7, 'Higiena', 1),
(8, 'Dzieci', 1),
(9, 'Rozrywka', 1),
(10, 'Wycieczka', 1),
(11, 'Szkolenia', 1),
(12, 'Książki', 1),
(13, 'Oszczędności', 1),
(14, 'Na emeryturę', 1),
(15, 'Spłata długów', 1),
(16, 'Darowizna', 1),
(17, 'Inne wydatki', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `expense_settings`
--

CREATE TABLE `expense_settings` (
  `expenseSetID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `incomes`
--

CREATE TABLE `incomes` (
  `incomeID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL,
  `data` date NOT NULL,
  `amount` float NOT NULL,
  `comment` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `income_categories`
--

CREATE TABLE `income_categories` (
  `incomeCatID` int(11) NOT NULL,
  `incomeCatName` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `IfDefault` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `income_categories`
--

INSERT INTO `income_categories` (`incomeCatID`, `incomeCatName`, `IfDefault`) VALUES
(1, 'Wynagrodzenie', 1),
(2, 'Odsetki bankowe', 1),
(3, 'Sprzedaż na allegro', 1),
(4, 'Inne', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `income_settings`
--

CREATE TABLE `income_settings` (
  `incomeSetID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pay_method_categories`
--

CREATE TABLE `pay_method_categories` (
  `payMethCatID` int(11) NOT NULL,
  `payMethCatName` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `IfDefault` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `pay_method_categories`
--

INSERT INTO `pay_method_categories` (`payMethCatID`, `payMethCatName`, `IfDefault`) VALUES
(1, 'Gotówka', 1),
(2, 'Karta debetowa', 1),
(3, 'Karta kredytowa', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `pay_method_settings`
--

CREATE TABLE `pay_method_settings` (
  `payMethSetID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `categoryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `userName` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `email` text CHARACTER SET utf8 COLLATE utf8_polish_ci NOT NULL,
  `password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expenseID`);

--
-- Indeksy dla tabeli `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`expenseCatID`);

--
-- Indeksy dla tabeli `expense_settings`
--
ALTER TABLE `expense_settings`
  ADD PRIMARY KEY (`expenseSetID`);

--
-- Indeksy dla tabeli `incomes`
--
ALTER TABLE `incomes`
  ADD PRIMARY KEY (`incomeID`);

--
-- Indeksy dla tabeli `income_categories`
--
ALTER TABLE `income_categories`
  ADD PRIMARY KEY (`incomeCatID`);

--
-- Indeksy dla tabeli `income_settings`
--
ALTER TABLE `income_settings`
  ADD PRIMARY KEY (`incomeSetID`);

--
-- Indeksy dla tabeli `pay_method_categories`
--
ALTER TABLE `pay_method_categories`
  ADD PRIMARY KEY (`payMethCatID`);

--
-- Indeksy dla tabeli `pay_method_settings`
--
ALTER TABLE `pay_method_settings`
  ADD PRIMARY KEY (`payMethSetID`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expenseID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `expenseCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT dla tabeli `expense_settings`
--
ALTER TABLE `expense_settings`
  MODIFY `expenseSetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `incomes`
--
ALTER TABLE `incomes`
  MODIFY `incomeID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `income_categories`
--
ALTER TABLE `income_categories`
  MODIFY `incomeCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT dla tabeli `income_settings`
--
ALTER TABLE `income_settings`
  MODIFY `incomeSetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `pay_method_categories`
--
ALTER TABLE `pay_method_categories`
  MODIFY `payMethCatID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT dla tabeli `pay_method_settings`
--
ALTER TABLE `pay_method_settings`
  MODIFY `payMethSetID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
