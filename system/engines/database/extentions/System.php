<?php
  return new class {

    function hasData() {
      $q = "SELECT name FROM sqlite_master WHERE type='table'";
      $s = $this->db->prepare($q);
      $s->execute();

      $size = count($s->fetchAll());
      return ($size > 0);
    }

    function enablePlugin($name) {
      $q = "INSERT OR REPLACE INTO plugins (ROWID, name, enabled) VALUES
      ((SELECT ROWID FROM plugins WHERE name = ':name'), :name, 1)";
      $s = $this->db->prepare($q);
      $s->bindParam(":name", $name);
      $s->execute();
    }

    function disablePlugin($name) {
      $q = "INSERT OR REPLACE INTO plugins (ROWID, name, enabled) VALUES
      ((SELECT ROWID FROM plugins WHERE name = ':name'), :name, 0)";
      $s = $this->db->prepare($q);
      $s->bindParam(":name", $name);
      $s->execute();
    }

    function isPluginEnabled($name) {
      $q = "SELECT enabled FROM plugins WHERE name = :name";
      $s = $this->db->prepare($q);
      $s->bindParam(":name", $name);
      $s->execute();
      $row = $s->fetch();
      if($row) {
        return $row['enabled'];
      }
      return false;
    }

    function getPage($path) {
      $q = "SELECT * FROM pages WHERE path = :path AND enabled = 1";
      $s = $this->db->prepare($q);
      $s->bindParam(":path", $path);
      $s->execute();
      return $s->fetch();
    }

    function getEnabledPages() {
      $q = "SELECT * FROM pages WHERE enabled = 1";
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

  }
?>
