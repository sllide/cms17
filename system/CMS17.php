<?php
  class CMS17 {
    public function CMS17() {
      $engineLoader = require_once("system/EngineLoader.php");

      //set default core
      $coreName = "default";
      if(!$engineLoader->get('database')->system->hasData()) {
        $coreName = "setup";
      }

      //ask the router what the first parameter is to determine if its a core or not
      $router = $engineLoader->get('router');
      $page = $router->getPage();

      //check if its a core
      $corePath = "system/cores/$page/Core.php";
      if(file_exists($corePath)) {
        $coreName = $page;
        $router->shift(); //shift the path to hide the core
      }

      //load said core
      $this->core = require_once("system/cores/$coreName/Core.php");

      //pass the engineLoader to the core
      $this->core->loader = $engineLoader;

      //initialze and build!
      $this->core->init();

      //the only echo in cms17 :)
      echo $this->core->build();
    }
  }
?>
