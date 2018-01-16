<?php
  class PluginsPanel extends ConfigPanel {

    function build() {
      $this->engine->tag->registerFunctionTag('pluginList', [$this, 'buildList']);

      return $this->engine->file->getTemplate('admin/plugins');
    }

    function buildList() {
      $data = "";
      for($i=0;$i<10;$i++) {
        $data .= $this->buildEntry();
      }
      return $data;
    }

    function buildEntry() {
      return "
        <tr>
          <td>1</td>
          <td>2</td>
          <td>3</td>
          <td></td>
        </tr>
        ";
    }

    function handleRequest($post) {

    }
  }
?>
