<?php
  class Plugin implements Engine{
    private static $plugin;

    static function __init__() {

    }

    static function load($name) {
      if(self::$plugin) {
        Log::error("Trying to load $name while a plugin is already loaded");
        return false;
      }

      if(!Database::$system->isPluginEnabled($name)) {
        Log::error("Trying to load plugin $name which is disabled");
      }

      $plugin = require_once("plugins/$name/Plugin.php");
      echo get_parent_class($plugin);
      if(in_array("Plug", class_implements($plugin))) {
        self::$plugin = $plugin;
        self::$plugin->init();
        return true;
      } else {
        Log::error("Plugin $name does not implement Plug");
        return false;
      }
    }

    static function build() {
      return self::$plugin->build();
    }

    static function unload() {
      self::$plugin = false;
    }

    static function install($name) {
      if(File::doesPluginExist($name)) {
        $data = require("plugins/$name/Data.php");
        $tables = $data->structure();

        foreach($tables as $table => $data) {
          Database::createTable($name."__".$table, $data);
        }

        Database::$system->enablePlugin($name);
        if(self::load($name)) {
          self::$plugin->install();
          self::unload();
        }
      }
    }
  }
?>
