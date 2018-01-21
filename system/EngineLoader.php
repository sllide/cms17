<?php
  return new class {
    private $engines;

    function get($name) {
      //check if engine has been initialized before
      if(!isset($this->engines[$name])) {
        //if it isnt load the engine
        if(!$this->loadEngine($name)) {
          return false;
        }
      }
      $this->engines[$name]->who = $this->getRequestor($name);
      return $this->engines[$name];
    }

    private function loadEngine($name) {
      //check if engine exists
      if(file_exists("system/engines/$name/Engine.php")) {
        //if it does, require it and return true to notify the succes
        $engine = require_once("system/engines/$name/Engine.php");

        //only require engine if it extends AbstractEngine
        if(get_parent_class($engine) == "AbstractEngine") {
          $this->engines[$name] = $engine;
          $this->engines[$name]->loader = $this;
          $this->engines[$name]->init();
        } else {
          $this->get('log')->error("Engine $name does not extend AbstractEngine");
          return false;
        }
        return true;
      } else {
        $this->get('log')->error("Engine $name does not exist");
        return false;
      }
    }

    //return array with engine request data
    private function getRequestor($name) {
      $path = explode('\\',debug_backtrace()[1]['file']);
      if($offset = array_search("CMS17.php", $path)) {
        return ['type' => 'SYSTEM', 'system' => "CMS17"];
      }
      if($offset = array_search('cores', $path)) {
        return ['type' => 'core', 'system' => $path[$offset+1]];
      }
      if($offset = array_search('engines', $path)) {
        return ['type' => 'engine', 'system' => $path[$offset+1]];
      }
    }
  }
?>
