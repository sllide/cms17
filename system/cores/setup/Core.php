<?php
  return new class implements Core {
    private $systemTables = [
      "users" => [
        "username" => "TEXT UNIQUE NOT NULL",
        "password" => "TEXT NOT NULL",
        "level" => "INT NOT NULL DEFAULT 0",
      ],
      "log" => [
        "type" => "TEXT NOT NULL",
        "message" => "TEXT NOT NULL",
        "backtrace" => "TEXT NOT NULL",
      ],
      "plugins" => [
        "name" => "TEXT NOT NULL",
        "enabled" => "BOOLEAN NOT NULL",
      ],
      "pages" => [
        "title" => "TEXT NOT NULL",
        "path" => "TEXT NOT NULL",
        "content" => "TEXT NOT NULL",
        "pluginKey" => "TEXT",
        "enabled" => "BOOLEAN NOT NULL DEFAULT 0",
      ],
      "tags" => [
        "name" => "TEXT NOT NULL",
        "eval" => "BOOLEAN NOT NULL",
        "content" => "TEXT",
      ],
      "settings" => [
        "key" => "TEXT NOT NULL",
        "value" => "TEXT",
      ],
    ];

    function init() {
      if(Database::hasData()) {
        header('location:/');
        die;
      }

      $this->username = $this->password = "";
      $this->usernameError = $this->passwordError = "";

      $this->username = "jari";
      $this->password = "password";
      $this->installSystem();
      header('location:/');
      die;

      $this->template = File::getTemplate('index');

      Template::addDataTag("form", File::getTemplate('form'));
      Template::addDataTag("username", $this->username);
      Template::addDataTag("usernameError", $this->usernameError);
      Template::addDataTag("password", $this->password);
      Template::addDataTag("passwordError", $this->passwordError);
    }

    function installSystem() {
      foreach($this->systemTables as $table => $structure) {
        Database::createTable($table, $structure);
      }

      //manipulate data for insertion
      $this->username = strtolower($this->username);
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);

      $data = [$this->username,$this->password,5];
      Database::insertIntoTable('users', $data);

      Plugin::install('trash');
      Plugin::install('guestbook');

      $data = ['Home', "home", "Content will end up here!", "", 1];
      Database::insertIntoTable('pages', $data);
      $data = ['Trash', "trash", "Look below for the trash plugin!", "trash", 1];
      Database::insertIntoTable('pages', $data);
      $data = ['Guestbook', "guest", "guestbook stilo", "guestbook", 1];
      Database::insertIntoTable('pages', $data);
      $data = ['title', 0, 'Jari.xyz'];
      Database::insertIntoTable('tags', $data);
    }

    function build() {
      return Template::buildTemplate($this->template);
    }
  }
?>
