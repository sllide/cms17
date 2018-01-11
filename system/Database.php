<?php
  class Database {
    function __construct() {
      $this->DB = new PDO('sqlite:system/database.db');
    }
  }
?>
