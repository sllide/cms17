<?php
  class RoutingEngine extends Engine {
    private $route = [];

    function initialize() {
      $path = explode ("/", strtolower($_SERVER['REQUEST_URI']));

      //path is build up like www.cms17.com/key/value/key/value
      for($i=1;$i<count($path);$i+=2) {
        //only add complete routes
        if(isset($path[$i+1])) {
          $this->route[$path[$i]] = $path[$i+1];
        }
      }

      //add page if it isnt extracted from the uri
      if(!isset($this->route['page'])) {
        $this->route['page'] = 'home';
      }
    }

    function getRoute() {
      return $this->route;
    }
  }
?>
