<?php
  class DatabaseHelper {

    function __construct($db) {
      $this->db = $db;
    }

    function validateDataStructure($struct) {
      foreach($struct as $table => $data) {
        //find table
        if(!$this->db->doesTableExist($table)) {
          return false;
        };
        foreach($data as $name => $value) {
          if(!$this->db->doesColumnExist($table,$name)) {
            return false;
          }
        }
      }
      return true;
    }

    function buildDataStructure($struct) {
      foreach($struct as $table => $data) {
        $this->db->createTable($table);
        foreach($data as $name => $value) {
          $this->db->createColumn($table, $name, $value);
        }
      }
    }
  }
?>
