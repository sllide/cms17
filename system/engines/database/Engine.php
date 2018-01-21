<?php
  return new class extends AbstractEngine {

    function init() {
      $this->db = new PDO("sqlite:system/database.db");
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $this->system = $this->loader->get('file')->getExtention('System');
      $this->system->db = $this->db;
       
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

    function insertStructIntoTable($table, $data) {
      $q = "INSERT INTO $table (";
      foreach($data as $key => $value) {
        $q .= "" . $key . ",";
      }

      $q = substr($q,0,strlen($q)-1) . ") VALUES (";

      foreach($data as $key => $value) {
        $q .= ":" . $key . ",";
      }

      $q = substr($q,0,strlen($q)-1) . ")";

      $s = $this->db->prepare($q);

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
      return $this->db->lastInsertId();
    }
  }
?>
