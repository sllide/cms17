<?php
  class pluginLoader {

    private $plugins = array();

    function load($tagEngine) {
      $dirs = array_filter(glob('plugins/*'), 'is_dir');

      foreach($dirs as $dir) {
        echo "loading " . $dir;
        $plugin = require_once($dir."/plugin.php");
        $plugin->registerTags($tagEngine);
        $plugins[] = $plugin;
      }
    }
  }
?>
