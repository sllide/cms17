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
        $key = explode('/',$dir)[1];
        $plugin = require_once($dir."/plugin.php");
        $this->plugins[$key] = $plugin;
      }
    }

    function initializeAll() {
      foreach($this->plugins as $plugin) {
        if($this->isPluginEnabled($plugin)) {
          $plugin->initialize($this->database);
          $plugin->registerTags($this->tagEngine);
        }
      }
    }

    function isPluginEnabled($plugin) {
      $pData = $plugin->getMetaData();
      $matches = $this->database->getAllMatchesFromTable("plugins", "name = '" . $pData['name'] . "'");

      //plugin entry doesnt exist, create it with enabled status
      if(count($matches) == 0) {
      $data = [ "name" => $pData['name'], "enabled" => 1];
        $this->database->insertIntoTable("plugins",$data);
        return true;
      }

      //if plugin is found and its enable tell it so
      if($matches[0]['enabled'] == 1) {
        return true;
      }

      return false;
    }

    function getPlugins() {
      return $this->plugins;
    }
  }
?>
