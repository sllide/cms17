<?php
  class DatabaseUpdater {
    function __construct($database) {
      $this->db = $database;
    }

    function plugin($key, $enabled) {
      $q = "UPDATE plugins SET enabled = :enabled WHERE key = :key";
      $s = $this->db->prepare($q);
      $s->bindParam(":key", $key);
      $s->bindParam(":enabled", $enabled);
      $s->execute();
    }
  }
?>
