<?php
  function systemLoader($class) {
      if(file_exists('system/services/' . $class . '.php')) include 'system/services/' . $class . '.php';
      if(file_exists('system/abstract/' . $class . '.php')) include 'system/abstract/' . $class . '.php';
      if(file_exists('system/engines/' . $class . '.php')) include 'system/engines/' . $class . '.php';
      if(file_exists('system/cores/' . $class . '.php')) include 'system/cores/' . $class . '.php';
      if(file_exists('system/' . $class . '.php')) include 'system/' . $class . '.php';
  }

  spl_autoload_register('systemLoader');
?>
