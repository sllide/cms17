<?php
  return new class extends AbstractExtention {
    function build() {
      $this->get('template')->addTag('totalPlugins', [$this, 'totalPlugins']);
      $this->get('template')->addTag('activePlugins', [$this, 'activePlugins']);
      return $this->get('file')->getTemplate('dashboard/index');
    }

    function totalPlugins() {
      return count($this->get('database')->system->getAllPlugins());
    }

    function activePlugins() {
      return count($this->get('database')->system->getEnabledPlugins());
    }
  }
?>
