<?php
  return new class {

    function build() {
      $this->loader->get('template')->addSingleUseTag('pluginList', [$this, 'buildList']);
      return $this->loader->get('file')->getTemplate('plugins/index');
    }

    function buildList() {
      $data = "";
      $plugins = $this->loader->get('file')->getAllPluginNames();
      foreach($plugins as $plugin) {
        $data .= $this->buildEntry($plugin);
      }
      return $data;
    }

    function buildEntry($key) {
      $pluginData = $this->loader->get('file')->getPluginData($key);
      return sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>X</td></tr>", $pluginData->name, $key, 'enabled');
    }
  }
?>
