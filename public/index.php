<?php
  //some things need to be setup before cms17 will be able to run. These commands should not be changed
  chdir("..");

  //setup auto loader for abstract classes
  function autoloader($class) {
    require_once("system/abstract/$class.php");
  }
  spl_autoload_register('autoloader');

  //require cms17 and boot it!
  require_once('system/CMS17.php');
  new CMS17(); //boot CMS17!
?>
