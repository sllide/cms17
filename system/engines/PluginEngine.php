<?php
  class PluginEngine extends Engine {

    private $key, $data, $tags, $panel, $services, $plugin, $initialized;

    function load($key) {
      $this->key = $key;
    }

    function getData() {
      if(!$this->key) die("plugin not initialized");
      if(!$this->data) {
        $this->data = require("plugins/".$this->key."/Data.php");
      }
      return $this->data;
    }

    function getTags() {
      if(!$this->key) die("plugin not initialized");
      if(!$this->tags) {
        $this->tags = require("plugins/".$this->key."/Tags.php");
      }
      return $this->tags;
    }

    function getPanel() {
      if(!$this->key) die("plugin not initialized");
      if(!$this->panel) {
        $this->panel = require("plugins/".$this->key."/Panel.php");
      }
      return $this->panel;
    }

    private function getPlugin() {
      $this->getData();
      if(!$this->key) die("plugin not initialized");
      if(!$this->plugin) {
        $this->plugin = require("plugins//".$this->key."//Plugin.php");
      }
    }

    function getServices() {
      $this->getData();
      if(!$this->services) {
        $this->services = $this->engine->service->getServices($this->data->services);
        $this->plugin->registerServices($this->services);
      }

      return $this->services;
    }

    function getContent() {
      $this->getPlugin();
      $this->getServices();
      if(!$this->initialized) {
        $this->plugin->initialize();
        $this->initialized = true;
      }
      return $this->plugin->build();
    }

    function getKey() {
      if(!$this->key) die("plugin not initialized");
      return $this->key;
    }
  }
?>
