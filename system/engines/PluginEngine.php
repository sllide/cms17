<?php
  class PluginEngine extends Engine {

    private $key, $plugin;

    function load($key) {
      if(!$this->key) {
        $this->key = $key;
        $this->plugin = require("plugins//".$this->key."//Plugin.php");
        $this->plugin->loadFiles($key);
        $services = $this->engine->service->getServices($this->plugin->data->services);
        $this->plugin->registerServices($services);
      }
    }

    function getPlugin() {
      if(!$this->key) die("plugin not initialized");
      return $this->plugin;
    }

    function getKey() {
      if(!$this->key) die("plugin not initialized");
      return $this->key;
    }
  }
?>
