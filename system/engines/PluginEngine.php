<?php
  class PluginEngine extends Engine {

    private $key, $plugin;

    function load($key) {
      if(!$this->key) {
        if(!$this->engine->database->isPluginEnabled($key)) return false;
        $this->key = $key;
        $this->plugin = require("plugins/" . $this->key . "/Plugin.php");
        $this->plugin->loadFiles($key);
        $services = $this->engine->service->getServices($this->plugin->data->services, $this->key);
        $this->plugin->registerServices($services);
        $this->plugin->tags->registerServices($services);
      }
      return true;
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
