<?php
  return new class extends AbstractEngine{

    function init(){

    }

    private function getBasePath() {
      $type = $this->who['type'];
      $system = $this->who['system'];

      if($type == 'core') { return "system/cores/$system"; }
      if($type == 'engine') { return "system/engines/$system"; }
      if($type == 'plugin') { return "plugins/$system"; }

      $this->get('log')->error("Unhandled base path. Unknown system type $type");
    }

    public function getTemplate($name) {
      $path = $this->getBasePath();
      if(file_exists("$path/templates/$name.html")) {
        return file_get_contents("$path/templates/$name.html");
      }
      $this->get('log')->error("Cannot load template <b>$name</b>, file not found.");
    }

    public function getExtention($name) {
      $path = $this->getBasePath();
      if(file_exists("$path/extentions/$name.php")) {
        $extention = require_once("$path/extentions/$name.php");
        $extention->get = [$this, 'get'];
        return $extention;
      }
      $this->get('log')->error("Cannot load extention <b>$name</b>, file not found.");
    }

    public function doesPluginExist($name) {
      if(file_exists("plugins/$name")) {
        return true;
      }
      return false;
    }

    public function getAllPluginNames() {
      $names = [];
      $paths = array_filter(glob('plugins/*'), 'is_dir');
      foreach($paths as $path) {
          $names[] = explode('/', $path)[1];
      }
      return $names;
    }

    public function getPluginData($name) {
      return require("plugins/$name/Data.php");
    }
  }
?>
