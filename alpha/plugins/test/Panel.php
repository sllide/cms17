<?php
  return new class extends PluginPanel {

    function build() {
      return "Hello from test plugin panel.";
    }

    function handleRequest($post) {

    }
  }
?>
