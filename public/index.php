<?php
  //some things need to be setup before cms17 will be able to run. These commands should not be changed
  chdir("..");

  //setup auto loader for interfaces and engines
  function autoloader($class) {
    if(file_exists("system/interface/$class.php")) {
      require_once("system/interface/$class.php");
      return;
    }
    $lowerClass = strtolower($class);
    require_once("system/engines/$lowerClass/Engine.php");
    [$class,'__init__']();
  }
  spl_autoload_register('autoloader');

  //require cms17 and boot it!
  require_once('system/CMS17.php');
  new CMS17(); //boot CMS17!
?>
