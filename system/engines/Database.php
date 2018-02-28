<?php
  class Database implements Engine {

    static $db;

    static function __init__() {
      self::$db = new PDO("sqlite:user/database.db");
      self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    static function createTable($table, $data) {
      //pdo doesnt allow binding parameters other than values
      $q = "CREATE TABLE IF NOT EXISTS $table (";
      foreach($data as $key => $value) {
        $q .= "$key $value,";
      }
      $q = substr($q,0,strlen($q)-1) . ")";

      $s = self::$db->prepare($q);
      $s->execute();
    }

    static function getFromTable($table) {
      //pdo doesnt allow binding parameters other than values
      $q = "SELECT * FROM $table";
      $s = self::$db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    static function getFromTableMatching($table, $key, $value) {
      $q = "SELECT * FROM $table WHERE $key = ?";
      $s = self::$db->prepare($q);
      $s->bindParam(1, $value);
      $s->execute();
      return $s->fetchAll();
    }

    static function insertIntoTable($table, $data) {
      $q = "INSERT INTO $table VALUES(";
      for($i=0;$i<count($data);$i++) {
        $q .= "?,";
      }
      $q = substr($q,0,strlen($q)-1) . ")";

      $s = self::$db->prepare($q);

      //bind data
      for($i=0;$i<count($data);$i++) {
        $s->bindParam($i+1, $data[$i]);
      }

      $s->execute();
      return self::$db->lastInsertId();
    }

    static function insertStructIntoTable($table, $data) {
      $q = "INSERT INTO $table (";
      foreach($data as $key => $value) {
        $q .= "" . $key . ",";
      }

      $q = substr($q,0,strlen($q)-1) . ") VALUES (";

      foreach($data as $key => $value) {
        $q .= ":" . $key . ",";
      }

      $q = substr($q,0,strlen($q)-1) . ")";

      $s = self::$db->prepare($q);

      $i = 0;
      $keys = [];
      $values = [];
      foreach($data as $key => $value) {
        $keys[$i] = $key;
        $values[$i] = $value;
        $s->bindParam(":".$keys[$i], $values[$i]);
        $i++;
      }

      $s->execute();
      return self::$db->lastInsertId();
    }

    static function hasData() {
      $q = "SELECT name FROM sqlite_master WHERE type='table'";
      $s = self::$db->prepare($q);
      $s->execute();

      $size = count($s->fetchAll());
      return ($size > 0);
    }

    static function executeQuery($q, $params = []) {
      $s = self::$db->prepare($q);
      $s->execute($params);
      return $s->fetchAll();
    }

    static function executeQuerySingle($q, $params = []) {
      $s = self::$db->prepare($q);
      $s->execute($params);
      return $s->fetch();
    }
  }
?>
