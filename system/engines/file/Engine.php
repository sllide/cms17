<?php
  return new class extends AbstractEngine{

    function init(){
       
    }

    private function getBasePath() {
      $type = $this->who['type'];
      $system = $this->who['system'];

      if($type == 'core') { return "system/cores/$system"; }
      if($type == 'engine') { return "system/engines/$system"; }

      $this->loader->get('log')->error("Unhandled base path. Unknown system type $type");
    }

    public function getTemplate($name) {
      $path = $this->getBasePath();
      if(file_exists("$path/templates/$name.html")) {
        return file_get_contents("$path/templates/$name.html");
      }
      $this->loader->get('log')->error("Cannot load template <b>$name</b>, file not found.");
    }

    public function getExtention($name) {
      $path = $this->getBasePath();
      if(file_exists("$path/extentions/$name.php")) {
        return require_once("$path/extentions/$name.php");
      }
      $this->loader->get('log')->error("Cannot load extention <b>$name</b>, file not found.");
    }

    public function doesPluginExist($name) {
      if(file_exists("plugins/$name")) {
        return true;
      }
      return false;
    }
  }
?>
