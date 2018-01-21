<?php
  return new class extends AbstractEngine{
    private $timers = [];

    function init() {
       
    }

    function start($name) {
      $this->timers[$name] = microtime(true);
    }

    function stop($name) {
      $elapsed = microtime(true) - $this->timers[$name];
      unset($this->timers[$name]);
      $this->loader->get('log')->notice("Timer with name <b>$name</b> clocked in at $elapsed seconds");
      return $elapsed;
    }
  }
?>
