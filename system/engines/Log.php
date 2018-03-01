<?php
  class Log implements Engine{
    private static $direct = false;
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

    public static function warning($message) {
      Database::insertIntoTable('log', [self::TYPE_WARNING, $message, self::getBacktrace()]);
    }

    public static function error($message) {
      Database::insertIntoTable('log', [self::TYPE_ERROR, $message, self::getBacktrace()]);
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
