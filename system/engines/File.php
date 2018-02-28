<?php
  class File implements Engine{

    public static function __init__(){}

    public static function getTemplate($name) {
      $in = explode("/", debug_backtrace()[0]['file']);
      if(array_search('extensions', $in)) $in = explode("/", debug_backtrace()[1]['file']);
      array_pop($in);
      $out = implode("/", $in)."/templates/$name.html";
      if(file_exists($out)) {
        return file_get_contents($out);
      }
      Log::error("Template <strong>'$out'</strong> does not exist");
    }

    public static function getExtension($name) {
      $in = explode("/", debug_backtrace()[0]['file']);
      array_pop($in);
      $out = implode("/", $in)."/extensions/$name.php";
      if(file_exists($out)) {
          return require $out;
      }
      Log::error("Extension $name does not exist");
    }

    public static function doesPluginExist($name) {
      if(file_exists("plugins/$name")) {
        return true;
      }
      return false;
    }

    public static function getAllPluginNames() {
      $names = [];
      $paths = array_filter(glob('plugins/*'), 'is_dir');
      foreach($paths as $path) {
          $names[] = explode('/', $path)[1];
      }
      return $names;
    }

    public static function getPluginData($name) {
      return require("plugins/$name/Data.php");
    }
  }
?>
