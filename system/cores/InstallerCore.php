<?php
  class InstallerCore extends Core {

    private $systemTables = [
      "users" => [
        "username" => "TEXT UNIQUE NOT NULL",
        "password" => "TEXT NOT NULL",
        "level" => "INT NOT NULL DEFAULT 0",
      ],
      "tags" => [
        "name" => "TEXT NOT NULL",
        "value" => "TEXT NOT NULL",
      ],
      "log" => [
        "invoker" => "TEXT NOT NULL",
        "type" => "TEXT NOT NULL",
        "message" => "TEXT NOT NULL",
      ],
      "plugins" => [
        "key" => "TEXT NOT NULL",
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

    function initialize() {
      $this->title = $this->username = $this->password = "";
      $this->titleError = $this->usernameError = $this->passwordError = "";

      $this->title = "Jari.xyz";
      $this->username = "jari";
      $this->password = "password";
      $this->installSystem();
      $this->engine->install->installPlugin('test');
      header("location:/");

      //all form data is correct, install system
      if($this->validateForm()) {
        $this->installSystem();
        header("location:/");
        die;
      }

      $this->registerTags();
    }

    function installSystem() {
      foreach($this->systemTables as $table => $structure) {
        $this->engine->database->createTable($table, $structure);
      }

      //manipulate data for insertion
      $this->username = strtolower($this->username);
      $this->password = password_hash($this->password, PASSWORD_DEFAULT);

      $data = [$this->username,$this->password,5];
      $this->engine->database->insertIntoTable('users', $data);

      $data = ['title', $this->title];
      $this->engine->database->insertIntoTable('tags', $data);

      $data = ['Home', "home", "Content will end up here!", "index", "test", 1];
      $this->engine->database->insertIntoTable('pages', $data);
    }

    function registerTags() {
      $this->engine->tag->registerDataTag('form', $this->engine->file->getTemplate("setup/form"));
      $this->engine->tag->registerDataTag("title", $this->title);
      $this->engine->tag->registerDataTag("titleError", $this->titleError);
      $this->engine->tag->registerDataTag("username", $this->username);
      $this->engine->tag->registerDataTag("usernameError", $this->usernameError);
      $this->engine->tag->registerDataTag("password", $this->password);
      $this->engine->tag->registerDataTag("passwordError", $this->passwordError);
    }

    function validateForm() {
      //if a post element is missing dont even bother checking
      if(!isset($_POST['title']) || !isset($_POST['username']) || !isset($_POST['password'])) {
        return false;
      }

      if(isset($_POST['title'])) {
        $this->title = $_POST['title'];

        if($this->title == "") {
          $this->titleError = "Please enter a title";
        }
      }

      if(isset($_POST['username'])) {
        $this->username = $_POST['username'];

        if(strlen($this->username) < 2) {
          $this->usernameError = "Username has to exist of atleast two characters";
        }
        elseif(!preg_match("/^[a-z0-9.]+$/i", $this->username)) {
          $this->usernameError = "Username can only exist out of letters and numbers";
        }
      }


      if(isset($_POST['password'])) {
        $this->password = $_POST['password'];
        if(strlen($this->password)<5) {
          $this->passwordError = "Password should exist out of atleast 5 characters";
        }
      }

      //if no error message is filled form is correct.
      if($this->titleError == "" && $this->usernameError == "" && $this->passwordError == "") {
        return true;
      }

      return false;
    }

    function build() {
      $template = $this->engine->file->getTemplate("setup/index");
      return $this->engine->template->buildTemplate($template);
    }
  }
?>
