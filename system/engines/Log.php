<?php
  class Log implements Engine{
    private static $direct = true;
    private static $backtrace = false;

    const TYPE_DEBUG = 0;
    const TYPE_NOTICE = 1;
    const TYPE_WARNING = 2;
    const TYPE_ERROR = 3;
    const TYPE_PHP_NOTICE = 4;
    const TYPE_PHP_WARNING = 5;
    const TYPE_PHP_ERROR = 6;

    public static function __init__() {

    }

    public static function setDirectLog($value) {
      self::$direct = $value;
    }

    public static function debug($message) {
      $invoker = debug_backtrace()[1]['class'];
      if(self::$direct) {
        self::directLog($invoker, self::TYPE_DEBUG, "<pre>".print_r($message, true)."</pre>");
      }
    }

    public static function notice($message) {
      $invoker = debug_backtrace()[1]['class'];
      if(self::$direct) {
        self::directLog($invoker, self::TYPE_NOTICE, $message);
      }
    }

    public static function warning($message) {
      $invoker = debug_backtrace()[1]['class'];
      if(self::$direct) {
        self::directLog($invoker, self::TYPE_WARNING, $message);
      }
      Database::insertIntoTable('log', [self::TYPE_WARNING, $message, self::getBacktrace()]);
    }

    public static function error($message) {
      $invoker = debug_backtrace()[1]['class'];
      if(self::$direct) {
        self::directLog($invoker, self::TYPE_ERROR, $message);
      }
      Database::insertIntoTable('log', [self::TYPE_ERROR, $message, self::getBacktrace()]);
    }

    private static function directLog($invoker, $type, $message) {
      $color = self::getMessageColor($type);
      $error = self::getMessageTitle($type);

      echo "<div style='padding: 2px 0px 5px 5px; margin:0px; background-color: $color;'>";
        echo "<div style='padding-bottom: 3px; color: white;'><b>$invoker</b> raised $error</div>";
        echo "<div style='padding: 2px; background-color: white'>$message</div>";
        if(self::$backtrace && $type != self::TYPE_DEBUG) {
          echo "<pre style='padding: 2px; background-color: white'>";
          echo self::getBacktrace();
          echo "</pre>";
        }
      echo "</div>";
    }

    private static function getBacktrace() {
      $trace = "";
      $skip = true;
      foreach(debug_backtrace() as $step) {
        if($skip) {
          $skip = false;
        } else {
          $line = $step['line'];
          $path = explode("cms17",$step['file'])[1];
          $function = $step['function'];
          $trace .= "$path [$line: $function]<br />";
        }
      }
      return $trace;
    }

    private static function getMessageColor($type) {
      switch($type) {
        case self::TYPE_DEBUG:
          return 'Black';
        case self::TYPE_NOTICE:
        case self::TYPE_PHP_NOTICE:
          return 'ForestGreen';
        case self::TYPE_WARNING:
        case self::TYPE_PHP_WARNING:
          return 'GoldenRod';
        case self::TYPE_ERROR:
        case self::TYPE_PHP_ERROR:
          return 'DarkRed';
        default:
          return 'Black';
      }
    }

    private static function getMessageTitle($type) {
      switch($type) {
        case self::TYPE_DEBUG:
          return 'Debug';
        case self::TYPE_NOTICE:
          return 'System notice';
        case self::TYPE_WARNING:
          return 'System warning';
        case self::TYPE_ERROR:
          return 'System error';
        case self::TYPE_PHP_NOTICE:
          return 'PHP notice';
        case self::TYPE_PHP_WARNING:
          return 'PHP warning';
        case self::TYPE_PHP_ERROR:
          return 'PHP error';
        default:
          return 'Unknown error type';
      }
    }
  }
?>
