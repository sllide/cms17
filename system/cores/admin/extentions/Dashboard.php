<?php
  return new class {
    function build() {
      $this->loader->get('template')->addSingleUseTag('totalPlugins', [$this, 'totalPlugins']);
      $this->loader->get('template')->addSingleUseTag('activePlugins', [$this, 'activePlugins']);
      return $this->loader->get('file')->getTemplate('dashboard/index');
    }

    function totalPlugins() {
      return count($this->loader->get('database')->system->getAllPlugins());
    }

    function activePlugins() {
      return count($this->loader->get('database')->system->getEnabledPlugins());
    }
  }
?>
