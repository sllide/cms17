<?php
  return new class implements PlugMeta {
    function name() {return "Guestbook";}
    function description() {return "Test guestbook.";}
    function author() {return "Jari Stephan";}
    function version() {return 1;}
    function structure() { return [
      "messages" => [
        "name" => "TEXT NOT NULL",
        "message" => "TEXT NOT NULL",
        "stamp" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
      ]];
    }
  }
?>
