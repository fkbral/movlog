<?php

require_once './src/config/database.php';

$dbh = new PDO(
  "mysql:host=".DatabaseConfig::$host, DatabaseConfig::$user, DatabaseConfig::$password
);

$dbh->exec("CREATE DATABASE IF NOT EXISTS ".DatabaseConfig::$dbname.";
GRANT ALL ON ".DatabaseConfig::$dbname."* TO ".DatabaseConfig::$user."@'localhost';
FLUSH PRIVILEGES;");

?>