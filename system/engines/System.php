<?php
  class System implements Engine {

    static function __init__() {
    
    }

    static function enablePlugin($name) {
      $q = "INSERT OR REPLACE INTO plugins (ROWID, name, enabled) VALUES
      ((SELECT ROWID FROM plugins WHERE name = ':name'), :name, 1)";
      Database::executeQuery($q,[':name' => $name]);
    }

    static function disablePlugin($name) {
      $q = "INSERT OR REPLACE INTO plugins (ROWID, name, enabled) VALUES
      ((SELECT ROWID FROM plugins WHERE name = ':name'), :name, 0)";
      Database::executeQuery($q, [':name' => $name]);
    }

    static function isPluginEnabled($name) {
      $q = "SELECT enabled FROM plugins WHERE name = :name";
      $r = Database::executeQuerySingle($q,[':name' => $name]);
      if($r) {
        return $r['enabled'];
      }
      return false;
    }

    static function getEnabledPlugins() {
      $q = "SELECT * FROM plugins WHERE enabled = 1";
      return Database::executeQuery($q);
    }

    static function getAllPlugins() {
      $q = "SELECT * FROM plugins";
      return Database::executeQuery($q);
    }

    static function getPage($path) {
      $q = "SELECT * FROM pages WHERE path = :path AND enabled = 1";
      return Database::executeQuerySingle($q,[':path'=>$path]);
    }

    static function getEnabledPages() {
      $q = "SELECT * FROM pages WHERE enabled = 1";
      return Database::executeQuery($q);
    }
  }
?>
