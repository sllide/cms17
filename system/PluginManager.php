<?php
  class PluginManager {

    function __construct($database) {
      $this->plugins = array();
      $this->db = $database;
    }

    function loadAll() {
      $dirs = array_filter(glob('../plugins/*'), 'is_dir');

      foreach($dirs as $dir) {
        $key = explode('/',$dir)[2];
        $plugin = require_once($dir."/plugin.php");
        $this->plugins[$key] = $plugin;
      }
    }

    function registerEnabled($tagEngine) {
      foreach($this->plugins as $key => $plugin) {
        if($this->isPluginEnabled($key)) {
          $plugin->registerTags($tagEngine);
        }
      }
    }

    function fireLogicHandlers() {
      foreach($this->plugins as $key => $plugin) {
        if($this->isPluginEnabled($key)) {
          $plugin->handleLogic($this->db->getDatabaseObject());
        }
      }
    }

    function firePanelLogicHandlers() {
      foreach($this->plugins as $key => $plugin) {
        $plugin->handlePanelLogic($this->db->getDatabaseObject());
      }
    }

    function isPluginEnabled($key) {
      $pluginRow = $this->db->getPlugin($key);

      //if plugin entry exists and is enabled say yes
      if(isset($pluginRow['enabled']) && $pluginRow['enabled'] == 1) {
        return true;
      }

      return false;
    }

    function getPlugin($key) {
      if(isset($this->plugins[$key])) {
        return $this->plugins[$key];
      }
      return false;
    }

    function getPlugins() {
      return $this->plugins;
    }
  }
?>
