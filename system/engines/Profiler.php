<?php
  class Profiler implements Engine{
    static $timers = Array();

    static function __init__() {
       
    }

    static function start($name) {
      self::$timers[$name] = microtime(true);
    }

    static function stop($name) {
      $elapsed = microtime(true) - self::$timers[$name];
      unset(self::$timers[$name]);
      return $elapsed;
    }
  }
?>
