<?php
  class Database implements Engine {

    static $db, $system;

    static function __init__() {
      self::$db = new PDO("sqlite:system/database.db");
      self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      self::$system = File::getExtension('System');
      self::$system->db = self::$db;
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

    static function getAllFromTable($table) {
      //pdo doesnt allow binding parameters other than values
      $q = "SELECT * FROM $table";
      $s = self::$db->prepare($q);
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
  }
?>
