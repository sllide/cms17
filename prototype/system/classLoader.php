<?php
  function systemLoader($class) {
      if(file_exists('../system/' . $class . '.php')) include '../system/' . $class . '.php';
      if(file_exists('../system/database/' . $class . '.php'))include '../system/database/' . $class . '.php';
      if(file_exists('../system/admin/' . $class . '.php'))include '../system/admin/' . $class . '.php';
  }

  spl_autoload_register('systemLoader');
?>
