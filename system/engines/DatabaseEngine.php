<?php
  class DatabaseEngine extends Engine {

    private $db;

    function connect() {
      $this->db = new PDO('sqlite:system/database.db');
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function hasData() {
      $q = "SELECT name FROM sqlite_master WHERE type='table'";
      $s = $this->db->prepare($q);
      $s->execute();

      $size = count($s->fetchAll());
      return ($size > 0);
    }

    function createTable($table, $data) {
      //pdo doesnt allow binding parameters other than values
      $q = "CREATE TABLE IF NOT EXISTS $table (";
      foreach($data as $key => $value) {
        $q .= "$key $value,";
      }
      $q = substr($q,0,strlen($q)-1) . ")";

      $s = $this->db->prepare($q);
      $s->execute();
    }

    function insertIntoTable($table, $data) {
      //pdo doesnt allow binding parameters other than values
      $q = "INSERT INTO $table VALUES(";
      for($i=0;$i<count($data);$i++) {
        $q .= "?,";
      }
      $q = substr($q,0,strlen($q)-1) . ")";

      $s = $this->db->prepare($q);

      //bind data
      for($i=0;$i<count($data);$i++) {
        $s->bindParam($i+1, $data[$i]);
      }

      $s->execute();
      return $this->db->lastInsertId();
    }

    function findSingleInTable($table, $column, $value) {
      $column = preg_replace("/[^A-Za-z]/", '', $column);
      $q = "SELECT rowid, * FROM $table WHERE $column = ?";
      $s = $this->db->prepare($q);
      $s->bindParam(1, $value);
      $s->execute();
      return $s->fetch();
    }


    function findInTable($table, $column, $value) {
      $column = preg_replace("/[^A-Za-z]/", '', $column);
      $q = "SELECT rowid, * FROM $table WHERE $column = ?";
      $s = $this->db->prepare($q);
      $s->bindParam(1, $value);
      $s->execute();
      return $s->fetchAll();
    }

    function getAllFromTable($table) {
      $q = "SELECT rowid, * FROM $table";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }
  }
?>
