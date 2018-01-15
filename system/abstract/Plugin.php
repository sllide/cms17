<?php
  abstract class Plugin {

    protected $service;
    public final function registerServices($service) {
      $this->service = $service;
    }

    public final function __construct() {}

    public abstract function initPlugin();
    public abstract function initConfig();
    public abstract function buildTag($tagName);
    public abstract function doPost($post);
    public abstract function doConfigPost($post);
  }
?>
