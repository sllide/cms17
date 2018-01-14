<?php
  return new class extends PluginData {
    function getName() {
      return "Test plugin";
    }

    function getDescription() {
      return "A plugin to test functionality";
    }

    function getAuthor() {
      return "Jari Stephan";
    }

    function getVersion() {
      return 1;
    }

    function hasConfigPanel() {
      return true;
    }

    function getTableNames() {
      return ['table', 'table2'];
    }

    function getNeededServices() {
      return ['database'];
    }

    function getTags() {
      return['test', 'example'];
    }

    function registerTableStructure($table, Callable $f) {
      switch($table) {
        case 'table':
          $f('username', 'TEXT UNIQUE NOT NULL');
          $f('password', 'TEXT NOT NULL');
          $f('timestamp', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
          break;
        case 'table2':
          $f('usernameasdf', 'TEXT UNIQUE NOT NULL');
          $f('pasasdfsword', 'TEXT NOT NULL');
          $f('timfadsestamp', 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP');
          break;
      }
    }
  }
?>
