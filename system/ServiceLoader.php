<?php
  return new class {
    private $services;

    function get($name) {
      //check if service has been initialized before
      if(!isset($this->services[$name])) {
        //if it isnt load the service
        if(!$this->loadService($name)) {
          return false;
        }
      }
      $this->services[$name]->who = $this->getRequestor($name);
      return $this->services[$name];
    }

    private function loadService($name) {
      //check if service exists
      if(file_exists("system/services/$name/Service.php")) {
        //if it does, require it and return true to notify the succes
        $service = require_once("system/services/$name/Service.php");

        //only require service if it extends AbstractService
        if(get_parent_class($service) == "AbstractService") {
          $this->services[$name] = $service;
          $this->services[$name]->loader = $this;
        } else {
          $this->loader->get('log')->error("Service $name does not extend AbstractService");
          return false;
        }
        return true;
      } else {
        $this->loader->get('log')->error("Service $name does not exist");
        return false;
      }
    }

    //return array with service request data
    private function getRequestor($name) {
      $path = explode('\\',debug_backtrace()[1]['file']);
      if($offset = array_search("plugins", $path)) {
        return ['plugin' => $path[$offset+1]];
      }
    }
  }
?>
