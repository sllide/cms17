<?php
  abstract class Service {
    protected $engine = [];
    protected $pluginKey = "";

    public final function __construct(&$engine, $key) {
      $this->engine = $engine;
      $this->pluginKey = $key;
    }
  }
?>
