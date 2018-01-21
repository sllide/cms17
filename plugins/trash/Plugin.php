<?php
  return new class extends AbstractPlugin {
    public function init() {

    }

    public function install() {
      echo "installing";
      $this->loader->get('database')->insertIntoTable('cucumber', ["YES", "NO?", "okay"]);
    }
  }
?>
