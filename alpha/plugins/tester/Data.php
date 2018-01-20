<?php
  return new class extends PluginData {
    public $name = "Tester plugin";
    public $description = "An even test'ier plugin.";
    public $author = "Jari Stephan";
    public $version = 1;

    public $databaseStructure = [
      "one" => [
        "name" => "TEXT NOT NULL",
        "message" => "TEXT NOT NULL",
        "magicNumber" => "INT NOT NULL",
        "timestamp" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
      ],
      "two" => [
        "abc" => "TEXT NOT NULL",
        "def" => "TEXT NOT NULL",
        "ghi" => "TEXT NOT NULL",
      ],
    ];

    public $services = ['template', 'file', 'database'];
  }
?>
