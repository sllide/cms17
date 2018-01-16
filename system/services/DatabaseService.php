<?php
  class DatabaseService extends Service {

    private $db;
    private $tables = [];

    function initialize() {
      $this->db = $this->engine->database->getDatabase();
      $struct = $this->engine->plugin->getPlugin()->data->databaseStructure;
      foreach($struct as $table => $data) {
        $this->tables[] = $table;
      }
    }

    function getTableData($table) {
      if(!is_integer(array_search($table, $this->tables))) die("plugin tried to access table it hasnt registered.");
      $key = $this->pluginKey;
      $q = "SELECT * FROM $key"."_".$table;
      $s = $this->db->prepare($q);
      $s->execute();
      return $s->fetchAll();
    }

    function insertIntoTable($table, $data) {
      if(!is_integer(array_search($table, $this->tables))) die("plugin tried to access table it hasnt registered.");
      $this->engine->database->insertIntoTable($this->pluginKey."_".$table, $data);
    }

    function insertStructIntoTable($table, $data) {
      if(!is_integer(array_search($table, $this->tables))) die("plugin tried to access table it hasnt registered.");
      $this->engine->database->insertStructIntoTable($this->pluginKey."_".$table, $data);
    }

    function getAvailableTables() {
      return $this->tables;
    }
  }
?>
