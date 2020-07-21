<?php

$createTable = "CREATE TABLE IF NOT EXISTS `movies` (

  `id` varchar(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` varchar(255)  NOT NULL default 'movie',
  `year`  varchar(20) NOT NULL,
  `poster`  varchar(255) NULL default '',
  `status`  int(11) NULL default 0,
   PRIMARY KEY  (`id`)

)";

Database::query($createTable);

?>