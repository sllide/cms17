<?php
  return new class extends AbstractPlugin {
    public function init() {

    }

    public function install() {
      $this->loader->get('database')->insertIntoTable('trash__cucumber', ["YES", "NO?", "okay"]);
    }

    public function build() {
      return $this->loader->get('file')->getTemplate('index');
    }
  }
?>
