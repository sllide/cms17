<?php
  return new class {
    function build() {
      Template::addTag('totalPlugins', [$this, 'totalPlugins']);
      Template::addTag('activePlugins', [$this, 'activePlugins']);
      return File::getTemplate('dashboard/index');
    }

    function totalPlugins() {
      return count(Database::$system->getAllPlugins());
    }

    function activePlugins() {
      return count(Database::$system->getEnabledPlugins());
    }
  }
?>
