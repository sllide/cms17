<?php
  class InstallEngine extends Engine {
    function installPlugin($key) {
      if($this->engine->file->doesPluginExist($key)) {
        $data = require("plugins/$key/Data.php");
        $tables = $data->databaseStructure;

        foreach($tables as $table => $data) {
          $this->engine->database->createTable($key."_".$table, $data);
        }

        $this->engine->database->updatePlugin($key, true);
        $this->engine->plugin->load($key);
        $this->engine->plugin->getPlugin()->install();
        $this->engine->plugin->unload();
      }
    }
  }
?>
