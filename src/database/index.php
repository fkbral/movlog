<?php 

require_once './src/config/database.php';

class Database {

  private static function connect(){
    $pdo = new PDO("mysql:host=".DatabaseConfig::$host.";dbname="
    .DatabaseConfig::$dbname, DatabaseConfig::$user, DatabaseConfig::$password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }

  public static function query($query, $params=[]) {
    $connection = self::connect();
    $statement = $connection->prepare($query);
    $statement->execute($params);

    $isSelect = (explode(' ',$query)[0]) === 'SELECT';

    if($isSelect){
      $data = $statement->fetchAll(PDO::FETCH_ASSOC);
      return $data;
    }

    $connection = null;
  }

}
?>