--
-- Database: `labtask`
--

CREATE TABLE `category` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` double NOT NULL,
  `rate` double NOT NULL
);

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `cat_name` varchar(255) NOT NULL,
  `value` double NOT NULL,
  `result` double NOT NULL
);

ALTER TABLE `category` ADD PRIMARY KEY (`id`);
ALTER TABLE `history` ADD PRIMARY KEY (`id`);
COMMIT;