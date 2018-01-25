<?php
  return new class extends AbstractCore {

    private $systemTables = [
      "users" => [
        "username" => "TEXT UNIQUE NOT NULL",
        "password" => "TEXT NOT NULL",
        "level" => "INT NOT NULL DEFAULT 0",
      ],
      "log" => [
        "invoker" => "TEXT NOT NULL",
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
        "template" => "TEXT NOT NULL",
        "pluginKey" => "TEXT",
        "enabled" => "BOOLEAN NOT NULL DEFAULT 0",
      ],
    ];

    function init() {
      if($this->get('database')->system->hasData()) {
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

      $this->template = $this->get('file')->getTemplate('index');

      $this->get('template')->addDataTag("form", $this->get('file')->getTemplate('form'));
      $this->get('template')->addDataTag("username", $this->username);
      $this->get('template')->addDataTag("usernameError", $this->usernameError);
      $this->get('template')->addDataTag("password", $this->password);
      $this->get('template')->addDataTag("passwordError", $this->passwordError);
    }

    function installSystem() {
      foreach($this->systemTables as $table => $structure) {
        $this->get('database')->createTable($table, $structure);
      }

      //manipulate data for insertion
      $this->username = strtolower($this->username);
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);

      $data = [$this->username,$this->password,5];
      $this->get('database')->insertIntoTable('users', $data);

      $this->get('plugin')->install('trash');

      $data = ['Home', "home", "Content will end up here!", "index", "", 1];
      $this->get('database')->insertIntoTable('pages', $data);
      $data = ['Trash', "trash", "Look below for the trash plugin!", "index", "trash", 1];
      $this->get('database')->insertIntoTable('pages', $data);
    }

    function build() {
      return $this->get('template')->buildTemplate($this->template);
    }
  }
?>
