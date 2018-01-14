<?php

  //So, I considered these functions save. But as it grew I stopped paying attention to it.
  //TODO: fix it.
  class Database {

    function __construct() {
      $this->db = new PDO('sqlite:../system/database/database.db');
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

      $this->helper = new DatabaseHelper($this);

      $this->insert = new DatabaseInserter($this->db);
      $this->update = new DatabaseUpdater($this->db);
    }

    function getAllTables() {
      $q = "SELECT name FROM sqlite_master WHERE type='table'";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function purgeDatabase() {
      foreach($this->getAllTables() as $row) {
        $q = "DROP TABLE IF EXISTS " . $row['name'];
        $s = $this->db->prepare($q);
        $s->execute();
      }
    }

    function getDataTags() {
      $q = "SELECT * FROM tags";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function getPlugins() {
      $q = "SELECT * FROM plugins";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function getActivePlugins() {
      $q = "SELECT * FROM plugins WHERE enabled = 1";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function getPlugin($key) {
      $q = "SELECT * FROM plugins WHERE key = :key";
      $s = $this->db->prepare($q);
      $s->bindParam(":key", $key);
      $s->execute();
      return $s->fetch();
    }

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

    function getDatabaseObject() {
      return $this->db;
    }
  }
?>
