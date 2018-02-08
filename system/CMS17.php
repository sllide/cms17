<?php
  class CMS17 {
    public function __construct() {
      //set default core
      $coreName = "default";
      if(!Database::$system->hasData()) {
        $coreName = "setup";
      }

      //ask the router what the first parameter is to determine if its a core or not
      $page = Router::getPage();

      //check if its a core
      $corePath = "system/cores/$page/Core.php";
      if(file_exists($corePath)) {
        $coreName = $page;
        Router::shift(); //shift the path to hide the core
      }

      //load said core
      $this->core = require_once("system/cores/$coreName/Core.php");

      //initialze and build!
      $this->core->init();

      echo $this->core->build();
    }
  }
?>
