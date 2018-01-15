<?php
  abstract class Plugin {

    protected $service = [];

    public final function __construct() {}

    public final function registerServices($service) {
      $this->service = $service;
    }

    public abstract function initialize();
    public abstract function build();
    public abstract function handleRequest($post);
  }
?>
