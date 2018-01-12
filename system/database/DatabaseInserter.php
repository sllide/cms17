<?php
  class DatabaseInserter {
    function __construct($database) {
      $this->db = $database;
    }

    function tag($name, $value) {
      $q = "INSERT INTO tags (name, value) VALUES(:name, :value)";
      $s = $this->db->prepare($q);
      $s->bindParam(":name", $name);
      $s->bindParam(":value", $value);
      $s->execute();
      return $this->db->lastInsertId();
    }

    function plugin($key, $enabled) {
      $q = "INSERT INTO plugins (key, enabled) VALUES(:key, :enabled)";
      $s = $this->db->prepare($q);
      $s->bindParam(":key", $key);
      $s->bindParam(":enabled", $enabled);
      $s->execute();
      return $this->db->lastInsertId();
    }

    function user($username, $password, $level) {

      $password = password_hash($password, PASSWORD_DEFAULT);

      $q = "INSERT INTO users (username, password, level) VALUES(:username, :password, :level)";
      $s = $this->db->prepare($q);
      $s->bindParam(":username", $username);
      $s->bindParam(":password", $password);
      $s->bindParam(":level", $level);
      $s->execute();
      return $this->db->lastInsertId();
    }
  }
?>
