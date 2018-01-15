<?php
  class RoutingEngine extends Engine {
    private $page, $action, $extra;

    function initialize() {
      //initialize route as "" to ensure it doesnt return invalid values
      $this->page = $this->action = $this->extra = "";

      //remove outer slashes to clean the path
      $path = trim($_SERVER['REQUEST_URI'], "/");
      $path = explode("/", $path);

      //remove admin from route
      if(isset($path[0]) && $path[0] == 'admin') {
        array_shift($path);
      }

      if(isset($path[0])) {
        $this->page = $path[0];

        if(isset($path[1])) {
          $this->action = $path[1];

          if(isset($path[2])) {
            $this->extra = $path[2];
          }
        }
      }

      //add page if it isnt extracted from the uri
      if($this->page == "") {
        $this->page = 'home';
      }
    }

    function getPage() {
      return $this->page;
    }

    function getAction() {
      return $this->action;
    }

    function getExtra() {
      return $this->extra;
    }
  }
?>
