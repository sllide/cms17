<?php
  function systemLoader($class) {
      include 'system/' . $class . '.php';
  }

  spl_autoload_register('systemLoader');
?>
