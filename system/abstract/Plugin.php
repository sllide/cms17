<?php
  abstract class Plugin {

    protected $services;
    public final function registerService($name, $service) {
      $this->services[$name] = $service;
    }

    public final function __construct() {}

    public abstract function initPlugin();
    public abstract function initConfig();
    public abstract function buildTag($tagName);
    public abstract function doPost($post);
    public abstract function doConfigPost($post);
  }
?>
