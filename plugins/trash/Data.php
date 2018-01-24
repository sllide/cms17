<?php
  return new class extends PluginData {
    public $name = "Trash";
    public $description = "The purest form of garbage, like a horse with two legs. You kind of want to put it down but decide not to because you love him that damn much. Thats this plugin.";
    public $author = "Jari Stephan";
    public $version = 1;

    public $databaseStructure = [
      "fruits" => [
        "name" => "TEXT NOT NULL",
        "rating" => "INT NOT NULL",
        "combatReady" => "BOOLEAN NOT NULL",
      ],
      "cucumber" => [
        "yes" => "TEXT NOT NULL",
        "no" => "TEXT NOT NULL",
        "maybe" => "TEXT NOT NULL",
      ],
    ];
  }
?>
