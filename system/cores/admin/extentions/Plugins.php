<?php
  return new class extends AbstractExtention {

    function build() {
      $this->get('template')->addSingleUseTag('pluginList', [$this, 'buildList']);
      return $this->get('file')->getTemplate('plugins/index');
    }

    function buildList() {
      $data = "";
      $plugins = $this->get('file')->getAllPluginNames();
      foreach($plugins as $plugin) {
        $data .= $this->buildEntry($plugin);
      }
      return $data;
    }

    function buildEntry($key) {
      $pluginData = $this->get('file')->getPluginData($key);
      return sprintf("<tr><td>%s</td><td>%s</td><td>%s</td><td>X</td></tr>", $pluginData->name, $key, 'enabled');
    }
  }
?>
