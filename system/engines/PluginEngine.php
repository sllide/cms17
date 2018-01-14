<?php
  class PluginEngine extends Engine {

    private $pluginList= [];

    function loadPlugins($keyList) {
      foreach($keyList as $key => $value)
      $this->loadPlugin($value['key']);
    }

    function loadPlugin($key) {
      $this->pluginList[$key] = [];
      $this->pluginList[$key]['data'] = require("plugins/$key/PluginData.php");
    }

    function getPlugin($key) {
      return $this->pluginList[$key];
    }

    function getPlugins() {
      return $this->pluginList;
    }

    function getPluginTagValue($key, $tag) {
      //plugin not found
      if(!isset($this->pluginList[$key])) {
        return "$key not found.";
      }

      //plugin not initialized
      if(!isset($this->pluginList[$key]['plugin'])) {
        $this->initializePlugin($key);
      }


      return $this->pluginList[$key]['plugin']->buildTag($tag);
    }

    function initializePlugin($key) {
      $this->pluginList[$key]['plugin'] = require("plugins/$key/Plugin.php");
      $this->pluginList[$key]['plugin']->initPlugin();
    }
  }
?>
