<?php
  abstract class PluginPanel extends ConfigPanel{

    protected $service = [];

    public final function __construct() {}

    public final function registerServices($service) {
      $this->service = $service;
    }
  }
?>