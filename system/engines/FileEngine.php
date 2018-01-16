<?php
  class FileEngine extends Engine {

    function getTemplate($path) {
      $path = "system/templates/$path.html";
      if(file_exists($path)) {
        return file_get_contents($path);
      }

      return "Template $path not found.";
    }

    function getFile($path) {
        $path = "$path.html";
        if(file_exists($path)) {
            return file_get_contents($path);
        }

        return "";
    }

    function getAllPluginNames() {
      $names = [];
      $paths = array_filter(glob('plugins/*'), 'is_dir');
      foreach($paths as $path) {
          $names[] = explode('/', $path)[1];
      }
      return $names;
    }

    function doesPluginExist($key) {
      if(file_exists("plugins/$key")) {
        return true;
      }
      return false;
    }

    function getPluginData($key) {
      if(file_exists("plugins/$key/Data.php")) {
        return require("plugins/$key/Data.php");
      }
      return false;
    }
  }
?>
