<?php
  return new class {

    function build() {
      Template::addTag('list', [$this, 'buildList']);
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
      $entry = "
        <tr><td>%s</td><td>%s</td><td>%s</td><td>
        <span uk-icon='icon: close'></span>
        <span uk-icon='icon: trash'></span>
        </td></tr>
      ";
      return sprintf($entry, $pluginData->name(), $key, 'enabled');
    }
  }
?>
