<?php
  abstract class PluginTags {

    protected $service = [];

    public final function __construct() {}

    public final function registerServices($service) {
      $this->service = $service;
    }
  }
?>
