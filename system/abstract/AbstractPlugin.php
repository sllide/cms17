<?php
  abstract class AbstractPlugin extends AbstractBase {
    public final function __construct() {}
    abstract function init();
    abstract function install();
    abstract function build();
  }
?>
