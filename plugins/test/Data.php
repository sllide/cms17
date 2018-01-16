<?php
  return new class extends PluginData {
    public $name = "Test plugin";
    public $description = "A test plugin.";
    public $author = "Jari Stephan";
    public $version = 1;

    public $databaseStructure = [
      "testTableOne" => [
        "name" => "TEXT NOT NULL",
        "message" => "TEXT NOT NULL",
        "magicNumber" => "INT NOT NULL",
        "timestamp" => "DATETIME DEFAULT CURRENT_TIMESTAMP",
      ],
      "testTableTwo" => [
        "abc" => "TEXT NOT NULL",
        "def" => "TEXT NOT NULL",
        "ghi" => "TEXT NOT NULL",
      ],
    ];

    public $services = ['template', 'file'];
  }
?>
