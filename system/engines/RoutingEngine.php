<?php
  class RoutingEngine extends Engine {
    private $admin, $post, $path;

    function initialize() {
      //remove outer slashes to clean the path
      $path = trim($_SERVER['REQUEST_URI'], "/");
      $this->path = explode("/", $path);

      //remove admin from route
      if(isset($this->path[0]) && $this->path[0] == 'admin') {
        array_shift($this->path);
        $this->admin = true;
      }

      if(isset($this->path[0]) && $this->path[0] == 'post') {
        array_shift($this->path);
        $this->post = true;
      }

      //add page if it isnt extracted from the uri
      if(empty($this->path[0])) {
        $this->path[0] = "home";
      }
    }

    function getPage() {
      if(isset($this->path[0])) {
        return $this->path[0];
      }
    }

    function getAction() {
      if(isset($this->path[1])) {
        return $this->path[1];
      }
    }

    function getExtra() {
      if(isset($this->path[2])) {
        return $this->path[2];
      }
    }

    function isAdmin() {
      return $this->admin;
    }

    function isPost() {
      return $this->post;
    }

    function getPath() {
      return $this->path;
    }
  }
?>
