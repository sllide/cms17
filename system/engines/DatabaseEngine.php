<?php
  class DatabaseEngine extends Engine {

    private $db;

    function connect($path) {
      $this->db = new PDO("sqlite:$path.db");
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

    function getDatabase() {
      return $this->db;
    }

    function getAllTags() {
      $q = "SELECT * FROM tags";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function getEnabledPages() {
      $q = "SELECT * FROM pages WHERE enabled = 1";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function getEnabledPlugins() {
      $q = "SELECT * FROM plugins WHERE enabled = 1";
      $s = $this->db->prepare($q);
      $s->execute();
      $data = $s->fetchAll();
      $tags = [];
      foreach($data as $row) {
        $tags[] = $row['key'];
      }
      return $tags;
    }

    function getPageByKey($key) {
      $q = "SELECT * FROM pages WHERE path = ?";
      $s = $this->db->prepare($q);
      $s->bindParam(1,$key);
      $s->execute();
      return $s->fetch();
    }

    function doesPluginExist($key) {
        $q = "SELECT * FROM plugins WHERE key = ?";
        $s = $this->db->prepare($q);
        $s->bindParam(1,$key);
        $s->execute();
        return (bool) count($s->fetchAll());
    }

    function updatePlugin($key, $enabled) {
        if($this->doesPluginExist($key)) {
          $q = "UPDATE plugins SET enabled = ? WHERE key = ?";
          $s = $this->db->prepare($q);
          $s->bindParam(1,$enabled);
          $s->bindParam(2,$key);
          $s->execute();
        } else {
          $q = "INSERT INTO plugins (key, enabled) VALUES(?,?)";
          $s = $this->db->prepare($q);
          $s->bindParam(2,$enabled);
          $s->bindParam(1,$key);
          $s->execute();
        }
    }

    function isPluginEnabled($key) {
      $q = "SELECT * FROM plugins WHERE enabled = 1 AND key = ?";
      $s = $this->db->prepare($q);
      $s->bindParam(1,$key);
      $s->execute();
      return (bool) count($s->fetchAll());
    }

    function attachPluginDatabase($key) {
      $q = "ATTACH DATABASE $key AS plugin";
      $s = $this->db->prepare($q);
      $s->execute();
      return (bool) count($s->fetchAll());
    }
  }
?>
