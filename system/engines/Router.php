<?php
  class Router implements Engine{

    static $URI;

    static function __init__() {

      if(!isset(self::$URI)) {
        $path = trim($_SERVER['REQUEST_URI'], "/");
        self::$URI = explode("/", $path);
      }
    }

    static function getPath() {
      return self::$URI;
    }

    static function getPage() {
      if(isset(self::$URI[0]) && self::$URI[0]!="") {
        return self::$URI[0];
      }
      return "home";
    }

    static function getAction() {
      if(isset(self::$URI[1])) {
        return self::$URI[1];
      }
      return false;
    }

    static function getParameters() {
      if(isset(self::$URI[2])) {
        return array_slice(self::$URI, 2);
      }
      return false;
    }

    static function shift() {
      if(isset(self::$URI))
      array_shift(self::$URI);
    }
  }
?>
