<?php
  return new class extends AbstractEngine{
    private $plugin;

    function init() {
    }

    function load($name) {
      if(isset($this->plugin)) {
        $this->get('log')->error("Trying to load $name while a plugin is already loaded");
        return false;
      }

      if(!$this->get('database')->system->isPluginEnabled($name)) {
        $this->get('log')->error("Trying to load plugin $name wich is disabled");
      }

      $plugin = require_once("plugins/$name/Plugin.php");

      if(get_parent_class($plugin) == "AbstractPlugin") {
        $this->plugin = $plugin;
        $this->plugin->get = [$this, 'get'];
        $this->plugin->init();
        return true;
      } else {
        $this->get('log')->error("Plugin $name does not extend AbstractPlugin");
        return false;
      }
    }

    function build() {
      return $this->plugin->build();
    }

    function unload() {
      unset($this->plugin);
    }

    function install($name) {
      if($this->get('file')->doesPluginExist($name)) {
        $data = require("plugins/$name/Data.php");
        $tables = $data->databaseStructure;

        foreach($tables as $table => $data) {
          $this->get('database')->createTable($name."__".$table, $data);
        }

        $this->get('database')->system->enablePlugin($name);
        if($this->load($name)) {
          $this->plugin->install();
          $this->unload();
        }
      }
    }
  }
?>
