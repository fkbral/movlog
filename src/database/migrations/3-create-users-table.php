<?php

$createTable = "CREATE TABLE IF NOT EXISTS `users` (

  `id` int(11) NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
   PRIMARY KEY  (`id`)

)";

Database::query($createTable);

?>