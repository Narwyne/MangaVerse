-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 12, 2025 at 07:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mangaverse`
--

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE `chapters` (
  `id` int(11) NOT NULL,
  `manga_id` int(11) NOT NULL,
  `chapter_number` int(11) NOT NULL,
  `chapter_title` varchar(255) NOT NULL,
  `images_folder` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `manga`
--

CREATE TABLE `manga` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `genres` varchar(255) NOT NULL,
  `status` enum('Ongoing','Completed') NOT NULL,
  `photo` varchar(255) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `description` text NOT NULL,
  `hiatus` enum('Yes','No') DEFAULT 'No'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `manga`
--

INSERT INTO `manga` (`id`, `title`, `genres`, `status`, `photo`, `date_added`, `description`, `hiatus`) VALUES
(1, 'Chainsawman', 'Action, Adventure, Romance', 'Ongoing', 'chainsaw-man-1-kaze.jpg', '2025-10-28 10:43:10', '', 'No'),
(6, 'Fire Punch', 'Action, Comedy, Adventure', 'Ongoing', '1762253222_6622eecc8f9b.jpg', '2025-11-04 10:47:02', 'W fire Punch', ''),
(7, 'Kaiju no.8', 'Action, Comedy, Fantasy', 'Ongoing', '1762253615_cab048573efa.jpg', '2025-11-04 10:53:35', 'asdasdasd', ''),
(8, 'Mushoku Tensei', 'Action, Adventure, Drama, Fantasy', 'Ongoing', '1762885250_94e5835430fb.jpg', '2025-11-11 18:20:50', 'An unemployed otaku has just reached the lowest point in his life. He wants nothing more than the ability to start over, but just as he thinks it may be possible…he gets hit by a truck and dies! Shockingly, he finds himself reborn into an infant’s body in a strange new world of swords and magic. His identity now is Rudeus Greyrat, yet he still retains the memories of his previous life. Reborn into a new family, Rudeus makes use of his past experiences to forge ahead in this fantasy world as a true prodigy, gifted with maturity beyond his years and a natural born talent for magic. With swords instead of chopsticks, and spell books instead of the internet, can Rudeus redeem himself in this wondrous yet dangerous land?', 'No'),
(9, 'Goblin Slayer', 'Action, Adventure, Drama, Fantasy', 'Ongoing', '1762935211_de686091b902.jpg', '2025-11-12 08:13:31', 'A young priestess has formed her first adventuring party, but almost immediately they find themselves in distress. Luckily for her, the Goblin Slayer chose that place as his next killing grounds–a man who\'s dedicated his life to the extermination of all goblins, by any means necessary. And when rumors of his feats begin to circulate, there\'s no telling who might come calling next.', 'No'),
(10, 'The Apothecary Diaries', 'Comedy, Drama, Mystery, Romance, Slice of Life', 'Ongoing', '1762935296_1971068d3c1f.jpg', '2025-11-12 08:14:56', 'Maomao, a young woman trained in the art of herbal medicine, is forced to work as a lowly servant in the inner palace. Though she yearns for life outside its perfumed halls, she isn’t long for a life of drudgery! Using her wits to break a “curse” afflicting the imperial heirs, Maomao attracts the attentions of the handsome eunuch Jinshi and is promoted to attendant food taster. But Jinshi has other plans for the erstwhile apothecary, and soon Maomao is back to brewing potions and…solving mysteries?!', 'No'),
(11, 'Who Made Me A Princess', 'Comedy, Drama, Fantasy', 'Completed', '1762935449_c561d719d9b7.jpg', '2025-11-12 08:17:29', 'When I opened my eyes, I had become a princess! But out of all the characters from this romance novel to be reborn into, why must it be the princess whose fate it is to die by the hands of her own blood-related father, the emperor?! If I want to live, I must never enter his sight. However…\r\n\r\n\"Since when did this kind of scumbag start living in my castle?\"\r\n\r\nWithout a single tear to shed nor a drop of blood to spill, that cruel and cold emperor, Claude! Will I, the Princess Athanasia who was caught by him, survive?\r\n\r\n\"I… What should I do…\"', 'No'),
(12, 'Magic Academy’s Genius Blinker', 'Action, Adventure, Fantasy, Romance', 'Ongoing', '1762935720_2b941b42929b.jpg', '2025-11-12 08:22:00', 'In the game Aether World, Baek Yuseol is considered the most useless character because he can\'t use magic like everyone else. His only skill, Blink, is a short-range teleportation ability most players consider worthless. But when he’s tasked with reaching the game\'s true ending, Baek Yuseol decides to use his unconventional skill to achieve this impossible goal.\r\n\r\nCan this so-called \"TRASH\" character outsmart his powerful peers, form unlikely alliances, and ultimately master the game?', 'No'),
(13, 'Jujutsu Kaisen', 'Action, Drama, Mystery, Thriller', 'Completed', '1762936878_3f6fa644a2c1.webp', '2025-11-12 08:41:18', 'For some strange reason, Itadori Yuuji, despite his insane athleticism, would rather just hang out with the Occult Club. However, he soon finds out that the occult is as real as it gets when his fellow club members are attacked!\r\n\r\nMeanwhile, the mysterious Fushiguro Megumi is tracking down a special-grade cursed object, and his search leads him to Itadori…', 'No'),
(14, 'Rebuild World', 'Action, Adventure, Mystery, Sci-Fi', 'Ongoing', '1762946395_bfca929f5669.jpg', '2025-11-12 11:19:55', 'At the risk of his own life, a young man sets foot in the ruins of a devastated old world. His name is Akira, and in order to claw his way out of the hellhole that is his birthplace of Slumtown, the boy became a hunter. In the wastelands he happens upon a strange woman, standing perfectly still, stark naked.\r\nShe is beautiful, but it seems that only he can see her. She exists incorporeal, tantalizingly beyond any touch, and she tells him her name is Alpha.\r\nAlpha won’t show even a sliver of her real intentions, but with a wide smile, she brings Akira his first commission as a hunter. Akira takes the task, if only to become a stronger hunter, and having entered a contract, their dramatic lives in the hunting profession was set to begin.', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`) VALUES
(1, 'user', 'user@gmail.com', '$2y$10$QGvP/sarLddSNb/zM1uDD.vrZvwj.Y7Yjnq7Ducc1.O4gXoBjNfyO', 'user'),
(3, 'admin', 'admin@gmail.com', '$2y$10$xg9hfSk2v8NH0YJHiILTYui6joieBghQQ1MDcEYeNEFRDR/tDz1JK', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapters`
--
ALTER TABLE `chapters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indexes for table `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapters`
--
ALTER TABLE `chapters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `manga`
--
ALTER TABLE `manga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
