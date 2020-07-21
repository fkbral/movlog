<?php

$addColumns = "ALTER TABLE `movies`

ADD COLUMN IF NOT EXISTS `runtime` VARCHAR(15),
ADD COLUMN IF NOT EXISTS `genre` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `rated` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `released` VARCHAR(60),
ADD COLUMN IF NOT EXISTS `actors` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `director` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `writer` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `plot` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `awards` VARCHAR(255),
ADD COLUMN IF NOT EXISTS `imdb_rating` VARCHAR(15),
ADD COLUMN IF NOT EXISTS `box_office` VARCHAR(30),
ADD COLUMN IF NOT EXISTS `total_seasons` VARCHAR(30),
ADD COLUMN IF NOT EXISTS `has_details` BOOLEAN DEFAULT 0;
";

Database::query($addColumns);

?>