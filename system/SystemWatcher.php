<?php
  class SystemWatcher {

    private $systemDataStructure = [
      "users" => [
        "username" => "TEXT",
        "password" => "TEXT",
      ],
      "tags" => [
        "name" => "TEXT",
        "value" => "TEXT",
      ],
      "plugins" => [
        "name" => "TEXT",
        "enabled" => "INT",
      ],
      "visits" => [
        "page" => "TEXT",
        "date" => "DATETIME",
        "visits" => "INT",
      ]
    ];

    function __construct($database, $databaseHelper) {
      $this->database = $database;
      $this->databaseHelper = $databaseHelper;
    }

    function validateSystem() {
      return $this->databaseHelper->validateDataStructure($this->systemDataStructure);
    }

    function buildSystem($title, $username, $password) {
      $this->database->purgeDatabase();
      $this->databaseHelper->buildDataStructure($this->systemDataStructure);
      $data = [ "username" => $username, "password" => password_hash($password, PASSWORD_DEFAULT)];
      $this->database->insertIntoTable("users", $data);
      $data = [ "name" => "title", "value" => $title];
      $this->database->insertIntoTable("tags", $data);
    }
  }
?>
