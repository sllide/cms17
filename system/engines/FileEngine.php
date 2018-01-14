<?php
  class FileEngine extends Engine {

    function getSystemTemplate($path) {
      $path = "system/templates/$path.html";
      if(file_exists($path)) {
        return file_get_contents($path);
      }
    }

    function getAllPluginNames() {
      $names = [];
      $paths = array_filter(glob('plugins/*'), 'is_dir');
      foreach($paths as $path) {
        $names[] = explode('/', $path)[1];
      }
      return $names;
    }
  }
?>
