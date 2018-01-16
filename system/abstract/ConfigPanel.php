<?php
  abstract class ConfigPanel {

    protected $engine;

    public function __construct($engine){
      $this->engine = $engine;
    }

    abstract function build();
    abstract function handleRequest($post);
  }
?>
