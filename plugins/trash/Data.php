<?php
  return new class implements PlugMeta {
    function name() {return "Trash";}
    function description() {return "The purest form of garbage, like a horse with two legs. You kind of want to put it down but decide not to because you love him that damn much. Thats this plugin.";}
    function author() {return "Jari Stephan";}
    function version() {return 1;}
    function structure() { return [
      "fruits" => [
        "name" => "TEXT NOT NULL",
        "rating" => "INT NOT NULL",
        "combatReady" => "BOOLEAN NOT NULL",
      ],
      "cucumber" => [
        "yes" => "TEXT NOT NULL",
        "no" => "TEXT NOT NULL",
        "maybe" => "TEXT NOT NULL",
      ]];
    }
  }
?>
