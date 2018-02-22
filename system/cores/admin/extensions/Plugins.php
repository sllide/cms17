<?php
  return new class {

    function build() {
      Template::addTag('pluginList', [$this, 'buildList']);
      return File::getTemplate('plugins/index');
    }

    function buildList() {
      $data = "";
      $plugins = File::getAllPluginNames();
      foreach($plugins as $plugin) {
        $data .= $this->buildEntry($plugin);
      }
      return $data;
    }

    function buildEntry($key) {
      $pluginData = File::getPluginData($key);
      return sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>X</td></tr>", $pluginData->name(), $key, 'enabled');
    }
  }
?>
