<?php
  abstract class AbstractPlugin {
    public final function __construct() {}
    abstract function init();
    abstract function install();
    abstract function build();
  }
?>
