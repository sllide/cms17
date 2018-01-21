<?php
  abstract class AbstractCore {
    public final function __construct() {}

    //functions needed to make core work
    public abstract function init();
    public abstract function build();
  }
?>
