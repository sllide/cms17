<?php
  class PluginManager {

    private $plugins = array();

    function __construct($database, $tagEngine) {
      $this->database = $database;
      $this->tagEngine = $tagEngine;
    }

    function load() {
      $dirs = array_filter(glob('plugins/*'), 'is_dir');

      foreach($dirs as $dir) {
        $plugin = require_once($dir."/plugin.php");
        $this->plugins[] = $plugin;
      }
    }

    function initializeAll() {
      foreach($this->plugins as $plugin) {
        $plugin->initialize($this->database);
        $plugin->registerTags($this->tagEngine);
      }
    }

    function getPlugins() {
      return $this->plugins;
    }
  }
?>
