<?php
  return new class extends AbstractService {
    public function insertIntoTable($table, $data) {
      $this->loader->get('database')->insertIntoTable($this->who."__".$table, $data);
    }

    public function getAllFromTable($table) {
      return $this->loader->get('database')->getAllFromTable($this->who."__".$table);
    }
  }
?>
