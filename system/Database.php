<?php
  class Database {
    function __construct() {
      $this->DB = new SQLite3('system/database.db');
    }
  }
?>
