<?php
  abstract class PluginData {
    public final function __construct() {}

    public $name = "Something";
    public $description = "Has a purpose";
    public $author = "Somebody";
    public $version = 9001;

    public $databaseStructure = [];
    public $services = [];
  }
?>
