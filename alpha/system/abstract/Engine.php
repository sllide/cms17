<?php
  abstract class Engine {
    protected $engine = [];

    public final function __construct(&$engine) {
      $this->engine = $engine;
    }
  }
?>
