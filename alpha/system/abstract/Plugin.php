<?php
  abstract class Plugin {

    protected $service = [];
    public $data, $tags, $panel;

    public final function __construct() {}

    public final function registerServices($service) {
      $this->service = $service;
    }

    public final function loadFiles($key) {
      $this->data = require("plugins/$key/Data.php");
      $this->panel = require("plugins/$key/Panel.php");
      $this->tags = require("plugins/$key/Tags.php");
    }

    public abstract function install();
    public abstract function initialize();
    public abstract function build();
    public abstract function handleRequest($post);
  }
?>
