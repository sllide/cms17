<?php
  class PluginsPanel extends ConfigPanel {

    function build() {
      $this->engine->tag->registerFunctionTag('pluginList', [$this, 'buildList']);
      return $this->engine->file->getTemplate('admin/plugins/panel');
    }

    function buildList() {
      $data = "";
      $plugins = $this->engine->file->getAllPluginNames();
      foreach($plugins as $plugin) {
        $data .= $this->buildEntry($plugin);
      }
      return $data;
    }

    function buildEntry($key) {
      $pluginData = $this->engine->file->getPluginData($key);
      return sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>X</td></tr>", $pluginData->name, $key, 'enabled');
    }

    function handleRequest($post) {

    }
  }
?>
