<?php
  class Database {
    function __construct() {
      $this->db = new PDO('sqlite:system/database.db');
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function getAllTables() {
      $q = "SELECT name FROM sqlite_master WHERE type='table'";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function purgeDatabase() {
      foreach($this->getAllTables as $row) {
        $q = "DROP TABLE IF EXISTS " . $row['name'];
        $s = $this->db->prepare($q);
        $s->execute();
      }
    }
    //I consider these safe even tho parameters arent bound by pdo
    //these functions are not supposed to be used outside of intialization

    function doesTableExist($table) {
      $q = "SELECT name FROM sqlite_master WHERE type='table' AND name='$table'";
      $s = $this->db->prepare($q);
      $s->execute();
      $count = count($s->fetchAll());
      if($count>0) return true;
      return false;
    }

    function doesColumnExist($table, $name) {
      $q = "pragma table_info($table)";
      $s = $this->db->prepare($q);
      $s->execute();
      $columns = $s->fetchAll();
      foreach($columns as $column) {
        if($column['name'] == $name) {
          return true;
        }
      }
      return false;
    }

    function createTable($table) {
      //pdo doesnt allow binding parameters other than values
      $q = "CREATE TABLE IF NOT EXISTS $table (id INTEGER PRIMARY KEY)";
      $s = $this->db->prepare($q);
      $s->execute();
    }

    function createColumn($table, $name,  $value) {
      //pdo doesnt allow binding parameters other than values
      $q = "ALTER TABLE $table ADD COLUMN $name $value";
      try{
        $s = $this->db->prepare($q);
        $s->execute();
      }catch(Exception $e){
        //just go on with execution since the column most likely exists already
      }
    }

    function insertIntoTable($table, $data) {
      $keys = [];
      foreach($data as $key => $value) {
        $keys[] = ":" . $key;
      }

      $q = "INSERT INTO $table (";
      foreach($data as $key => $value) {
        $q .= $key . ",";
      }

      $q = substr($q,0,strlen($q)-1) . ") VALUES(";
      foreach($keys as $key) {
        $q .= $key . ",";
      }

      $q = substr($q,0,strlen($q)-1) . ")";
      $s = $this->db->prepare($q);

      $i=0;
      foreach($data as $key => $value) {
        $s->bindParam($keys[$i++], $data[$key]);
      }

      $s->execute();
    }

    function getAllFromTable($table) {
      $q = "SELECT * FROM $table";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function getAllMatchesFromTable($table, $condition) {
      $q = "SELECT * FROM $table WHERE $condition";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }
  }
?>
