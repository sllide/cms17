<?php
  class PluginConfigPanel extends ConfigPanel {

    function build() {
      $pluginKey = $this->engine->routing->getAction();
      if($this->engine->plugin->load($pluginKey)) {
        return $this->engine->plugin->getPlugin()->panel->build();
      }
      return "plugin $pluginKey does not exist.";
    }

    function handleRequest($post) {

    }
  }
?>