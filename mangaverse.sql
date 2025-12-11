-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2025 at 03:13 PM
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

--
-- Dumping data for table `chapters`
--

INSERT INTO `chapters` (`id`, `manga_id`, `chapter_number`, `chapter_title`, `images_folder`, `date_added`) VALUES
(6, 19, 1, '', 'chapters/manga_19/chapter_1', '2025-11-15 18:21:07'),
(7, 19, 2, '', 'chapters/manga_19/chapter_2', '2025-11-16 16:39:01'),
(8, 19, 3, '', 'chapters/manga_19/chapter_3', '2025-11-16 16:39:30'),
(9, 12, 1, '', 'chapters/manga_12/chapter_1', '2025-11-16 16:44:42'),
(10, 20, 1, '', 'chapters/manga_20/chapter_1', '2025-11-16 17:49:24'),
(13, 22, 1, '', 'chapters/manga_22/chapter_1', '2025-11-28 16:06:22');

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
(7, 'Kaiju no.8', 'Action, Comedy, Fantasy', 'Ongoing', '1762253615_cab048573efa.jpg', '2025-11-04 10:53:35', 'Kafka hopes to one day keep his pact with his childhood friend Mina to join the Japan Defense Force and fight by her side. But while she’s out neutralizing kaiju as Third Division captain, Kafka is stuck cleaning up the aftermath of her battles. When a sudden rule change makes Kafka eligible for the Defense Force, he decides to try out for the squad once more. There\'s just one problem. He\'s made the Defense Force\'s neutralization list under the code name Kaiju No. 8.', ''),
(8, 'Mushoku Tensei', 'Action, Adventure, Drama, Fantasy', 'Ongoing', '1762885250_94e5835430fb.jpg', '2025-11-11 18:20:50', 'An unemployed otaku has just reached the lowest point in his life. He wants nothing more than the ability to start over, but just as he thinks it may be possible…he gets hit by a truck and dies! Shockingly, he finds himself reborn into an infant’s body in a strange new world of swords and magic. His identity now is Rudeus Greyrat, yet he still retains the memories of his previous life. Reborn into a new family, Rudeus makes use of his past experiences to forge ahead in this fantasy world as a true prodigy, gifted with maturity beyond his years and a natural born talent for magic. With swords instead of chopsticks, and spell books instead of the internet, can Rudeus redeem himself in this wondrous yet dangerous land?', 'No'),
(9, 'Goblin Slayer', 'Action, Adventure, Drama, Fantasy', 'Ongoing', '1762935211_de686091b902.jpg', '2025-11-12 08:13:31', 'A young priestess has formed her first adventuring party, but almost immediately they find themselves in distress. Luckily for her, the Goblin Slayer chose that place as his next killing grounds–a man who\'s dedicated his life to the extermination of all goblins, by any means necessary. And when rumors of his feats begin to circulate, there\'s no telling who might come calling next.', 'No'),
(10, 'The Apothecary Diaries', 'Comedy, Drama, Mystery, Romance, Slice of Life', 'Ongoing', '1762935296_1971068d3c1f.jpg', '2025-11-12 08:14:56', 'Maomao, a young woman trained in the art of herbal medicine, is forced to work as a lowly servant in the inner palace. Though she yearns for life outside its perfumed halls, she isn’t long for a life of drudgery! Using her wits to break a “curse” afflicting the imperial heirs, Maomao attracts the attentions of the handsome eunuch Jinshi and is promoted to attendant food taster. But Jinshi has other plans for the erstwhile apothecary, and soon Maomao is back to brewing potions and…solving mysteries?!', 'No'),
(11, 'Who Made Me A Princess', 'Comedy, Drama, Fantasy', 'Completed', '1762935449_c561d719d9b7.jpg', '2025-11-12 08:17:29', 'When I opened my eyes, I had become a princess! But out of all the characters from this romance novel to be reborn into, why must it be the princess whose fate it is to die by the hands of her own blood-related father, the emperor?! If I want to live, I must never enter his sight. However…\r\n\r\n\"Since when did this kind of scumbag start living in my castle?\"\r\n\r\nWithout a single tear to shed nor a drop of blood to spill, that cruel and cold emperor, Claude! Will I, the Princess Athanasia who was caught by him, survive?\r\n\r\n\"I… What should I do…\"', 'No'),
(12, 'Magic Academy’s Genius Blinker', 'Action, Adventure, Fantasy, Romance', 'Ongoing', '1762935720_2b941b42929b.jpg', '2025-11-12 08:22:00', 'In the game Aether World, Baek Yuseol is considered the most useless character because he can\'t use magic like everyone else. His only skill, Blink, is a short-range teleportation ability most players consider worthless. But when he’s tasked with reaching the game\'s true ending, Baek Yuseol decides to use his unconventional skill to achieve this impossible goal.\r\n\r\nCan this so-called \"TRASH\" character outsmart his powerful peers, form unlikely alliances, and ultimately master the game?', 'No'),
(13, 'Jujutsu Kaisen', 'Action, Drama, Mystery, Thriller', 'Completed', '1762936878_3f6fa644a2c1.webp', '2025-11-12 08:41:18', 'For some strange reason, Itadori Yuuji, despite his insane athleticism, would rather just hang out with the Occult Club. However, he soon finds out that the occult is as real as it gets when his fellow club members are attacked!\r\n\r\nMeanwhile, the mysterious Fushiguro Megumi is tracking down a special-grade cursed object, and his search leads him to Itadori…', 'No'),
(14, 'Rebuild World', 'Action, Adventure, Mystery, Sci-Fi', 'Ongoing', '1762946395_bfca929f5669.jpg', '2025-11-12 11:19:55', 'At the risk of his own life, a young man sets foot in the ruins of a devastated old world. His name is Akira, and in order to claw his way out of the hellhole that is his birthplace of Slumtown, the boy became a hunter. In the wastelands he happens upon a strange woman, standing perfectly still, stark naked.\r\nShe is beautiful, but it seems that only he can see her. She exists incorporeal, tantalizingly beyond any touch, and she tells him her name is Alpha.\r\nAlpha won’t show even a sliver of her real intentions, but with a wide smile, she brings Akira his first commission as a hunter. Akira takes the task, if only to become a stronger hunter, and having entered a contract, their dramatic lives in the hunting profession was set to begin.', 'No'),
(15, 'Overlord', 'Action, Adventure, Comedy, Drama, Sci-Fi, Thriller', 'Ongoing', '1763092505_8ce8a9184921.webp', '2025-11-14 03:55:05', 'The final hour of the popular virtual reality game Yggdrasil has come. However, Momonga, a powerful wizard and master of the dark guild Ainz Ooal Gown, decides to spend his last few moments in the game as the servers begin to shut down. To his surprise, despite the clock having struck midnight, Momonga is still fully conscious as his character and, moreover, the non-player characters appear to have developed personalities of their own!\r\n\r\nConfronted with this abnormal situation, Momonga commands his loyal servants to help him investigate and take control of this new world, with the hopes of figuring out what has caused this development and if there may be others in the same predicament.', 'No'),
(16, 'That Time i Got Reincarnated as a Slime', 'Action, Comedy, Fantasy', 'Ongoing', '1763092654_79ee6c805d67.jpg', '2025-11-14 03:57:34', 'The ordinary Mikami Satoru found himself dying after being stabbed by a slasher. It should have been the end of his meager 37 years, but he found himself deaf and blind after hearing a mysterious voice.\r\nHe had been reincarnated into a slime!\r\n\r\nWhile complaining about becoming the weak but famous slime and enjoying the life of a slime at the same time, Mikami Satoru met with the Catastrophe-level monster “Storm Dragon Veldora”, and his fate began to move.', 'No'),
(17, 'Trapped in a Dating Sim: The World of Otome Games Is Tough for Mobs', 'Action, Adventure, Comedy, Drama, Romance, Sci-Fi', 'Ongoing', '1763092857_a5800580801a.webp', '2025-11-14 04:00:57', 'Leon, a former Japanese worker, was reincarnated into an “otome game” world, and despaired at how it was a world where females hold dominance over males. It was as if men were just livestock that served as stepping stones for females in this world. The only exceptions were the game’s romantic targets, a group of handsome men led by the crown prince. In these bizarre circumstances, Leon held one weapon: his knowledge from his previous world, where his brazen sister had forced him to complete this game. This is a story about his adventure to survive and thrive in this world.', 'No'),
(18, 'My Dress-up Darling', 'Comedy, Drama, Romance, Slice of Life', 'Ongoing', '1763093012_00513d3760c5.jpg', '2025-11-14 04:03:32', 'Wakana Gojou is a fifteen year old high-school boy who was socially traumatized in the past due to his passions. That incident left a mark on him that made him into a social recluse. Until one day he had an encounter with Kitagawa who is a sociable gyaru, who is the complete opposite of him. They soon share their passions with one another which leads to their odd relationship.', 'No'),
(19, 'Oshi no ko', 'Comedy, Drama, Romance, Slice of Life, Supernatural', 'Completed', '1763093223_c27b15163a89.jpg', '2025-11-14 04:07:03', 'The story begins with a beautiful girl, her perfectly fake smile, and the people who love her selfishly for it.\r\n\r\nWhat transpires behind the scenes of the glittering showbiz industry? How far would you go for the sake of your beloved idol? What would you do if you found out reincarnation was real? The star of the show is Aquamarine Hoshino and the stage is but a mere facade. Will he manage to reach the climax before the world of glamour swallows him whole?', 'No'),
(20, '86 EIGHTY SIX', 'Action, Drama, Sci-Fi', 'Ongoing', '1763093408_e1ecd5f8b942.jpg', '2025-11-14 04:10:08', 'The Republic of San Magnolia has long been under attack from the neighboring Giadian Empire\'s army of unmanned drones known as the Legion. After years of painstaking research, the Republic finally developed autonomous drones of their own, turning the one-sided struggle into a war without casualties—or at least, that\'s what the government claims.\r\n\r\nIn truth, there is no such thing as a bloodless war. Beyond the fortified walls protecting the eighty-five Republic territories lies the \"nonexistent\" Eighty-Sixth Sector. The young men and women of this forsaken land are branded the Eighty-Six and, stripped of their humanity, pilot the \"unmanned\" weapons into battle…', 'No'),
(21, 'Demon Slayer: Kimetsu no Yaiba', 'Action, Adventure, Comedy, Drama', 'Completed', '1763093560_4ac2982ff096.jpg', '2025-11-14 04:12:40', '', 'No'),
(22, 'Wistoria: Wand and Sword', 'Action, Adventure, Fantasy', 'Ongoing', '1763093736_a01c152f4a7a.jpg', '2025-11-14 04:15:36', 'Seeking to fulfill a promise to a childhood friend, Will Serfort enters Regarden Magical Academy with the goal of making it to the top of the magical world. There\'s just one problem: he can\'t use magic! Will his sword skills be the key to unlocking his true potential?', 'No'),
(23, 'Hell\'s Paradise', 'Action, Adventure, Drama, Fantasy', 'Completed', '1763315775_38018403fe91.jpg', '2025-11-16 17:56:15', 'Gabimaru the Empty, a former ninja assassin feared as a heartless husk of a man, spends his days on death row wondering when an executioner skilled enough to so much as harm him will arrive, as he thinks nothing of seeing an end to his meaningless existence… Or so he thought.\r\nThen the lady executioner, Asaemon the Beheader, rekindles his hope with an astounding proposition.\r\nIf he ever wishes to see his beloved wife again, he must embark under the auspices of the shogunate on a perilous voyage to the mysterious mystic island said to house the elixir of immortality.\r\nShould he be the one among many rival death-row fiends and scoundrels to find the elixir, he\'ll earn a full exoneration, and, more importantly, a chance at an ordinary married life with the light of his life: the woman who made the world seem not so ugly.\r\nWhat awaits them is a journey like no other!', 'No'),
(24, 'GACHIAKUTA', 'Action, Comedy, Drama, Fantasy', 'Ongoing', '1763621969_041985565367.webp', '2025-11-20 06:59:29', 'Rudo lives in the slums of a floating town, where the poor scrape by under the shadow of the rich who live a sumptuous life, simply casting their garbage off the side, into the abyss. Then one day, he’s falsely accused of murder, and his wrongful conviction leads to an unimaginable punishment—exile off the edge, with the rest of the trash. Down on the surface, the cast-off waste of humanity has bred vicious monsters, and if Rudo wants to have any hope of discovering the truth and seeking vengeance against those who cast him into Hell, he will have to master a new power and join a group known as the Cleaners who battle the hulking trash beasts of the Pit!', 'No'),
(25, 'My Hero Academia', 'Action, Comedy, Drama, Slice of Life', 'Ongoing', '1763622129_ffb77cbe6610.jpg', '2025-11-20 07:02:09', 'One day, a four-year-old boy came to a sudden realization: the world is not fair. Eighty percent of the world\'s population wield special abilities, known as \"quirks,\" which have given many the power to make their childhood dreams of becoming a superhero a reality. Unfortunately, Izuku Midoriya was one of the few born without a quirk, suffering from discrimination because of it. Yet, he refuses to give up on his dream of becoming a hero; determined to do the impossible, Izuku sets his sights on the elite hero training academy, UA High.\r\n\r\nHowever, everything changes after a chance meeting with the number one hero and Izuku\'s idol, All Might. Discovering that his dream is not a dead end, the powerless boy undergoes special training, working harder than ever before. Eventually, this leads to him inheriting All Might\'s power, and with his newfound abilities, gets into his school of choice, beginning his grueling journey to become the successor of the best hero on the planet.', 'No'),
(26, 'Sakamoto Days', 'Action, Comedy, Drama, Sci-Fi, Slice of Life', 'Ongoing', '1763622229_54aaad4790f7.webp', '2025-11-20 07:03:49', 'Taro Sakamoto was the ultimate assassin, feared by villains and admired by hitmen. But one day... he fell in love! Retirement, marriage, fatherhood and then... Sakamoto gained weight! The chubby guy who runs the neighborhood store is actually a former legendary hitman! Can he protect his family from danger?', 'No'),
(27, 'Kagurabachi', 'Action, Comedy, Mystery', 'Ongoing', '1763622345_6e501ac6518c.jpg', '2025-11-20 07:05:45', 'Young Chihiro spends his days training under his famous swordsmith father. One day he hopes to become a great sword-maker himself. The goofy father and the serious son--they thought these days would last forever. But suddenly, tragedy strikes. A dark day soaked in blood. Chihiro and his blade now live only for revenge.', 'No'),
(28, 'The Case Study of Vanitas', 'Action, Adventure, Drama, Supernatural', 'Ongoing', '1763903507_725cba25e511.jpg', '2025-11-23 13:11:47', 'Rumors revolving around the Book of Vanitas, a clockwork grimoire of dubious reputation, draw Noé, a young vampire in search of a friend\'s salvation, to Paris. What awaits him in the City of Flowers, however, is not long hours treading the pavement or rifling through dusty bookshops in search of the tome. Instead, his quarry comes to him...in the arms of a man claiming to be a vampire doctor! Thrust into a conflict that threatens the peace between humans and vampires, will Noé cast in his lot with the curious and slightly unbalanced Vanitas and his quest to save vampirekind?', 'No'),
(29, 'Isekai Apocalypse MYNOGHRA', 'Adventure, Comedy, Fantasy', 'Ongoing', '1763903648_9cc064987153.jpg', '2025-11-23 13:14:08', 'Bedridden and abandoned, Takuto Ira spent his days in the hospital trying to beat the illness that was slowly killing him. His only solace lay in the nation management strategy game Eternal Nations, where he had built a reputation as the greatest player to ever live.\r\n\r\nAfter succumbing to his disease, Takuto awoke within the game next to Atou — the Hero unit for his favorite civilization, Mynoghra. Now they’ll set out to conquer the world together (again), one unit, settlement, and level at a time!', 'No');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `profile_pic` varchar(255) DEFAULT 'uploads/default.png',
  `background_pic` varchar(255) DEFAULT 'uploads/default_bg.png',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `nickname`, `profile_pic`, `background_pic`, `created_at`, `updated_at`) VALUES
(1, 3, 'Narwyne', 'uploads/pp_3_1764422201.jpg', 'uploads/bg_3_1764422272.png', '2025-11-29 13:16:41', '2025-11-29 13:19:04');

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
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `manga`
--
ALTER TABLE `manga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `profile`
--
ALTER TABLE `profile`
  ADD CONSTRAINT `profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
