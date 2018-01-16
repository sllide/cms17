<?php
  abstract class Core {
    protected $engine = [];

    public final function registerEngines(&$engine) {
      $this->engine = $engine;
    }

    public final function __construct() {}


    public abstract function initialize();
    public abstract function build();
  }
?>
