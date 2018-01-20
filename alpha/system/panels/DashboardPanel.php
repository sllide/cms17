<?php
  class DashboardPanel extends ConfigPanel {

    function build() {
      $this->engine->tag->registerDataTag('totalPlugins', 'x');
      $this->engine->tag->registerDataTag('activePlugins', 'y');
      return $this->engine->file->getTemplate("admin/dashboard/panel");
    }

    function handleRequest($post) {

    }
  }
?>
