<?php
  return new class extends AbstractEngine {

    public function init() {

      if(!isset($this->URI)) {
        $path = trim($_SERVER['REQUEST_URI'], "/");
        $this->URI = explode("/", $path);
      }
    }

    function getPath() {
      return $this->URI;
    }

    function getPage() {
      if(isset($this->URI[0]) && $this->URI[0]!="") {
        return $this->URI[0];
      }
      return "home";
    }

    function getAction() {
      if(isset($this->URI[1])) {
        return $this->URI[1];
      }
      return false;
    }

    function getParameters() {
      if(isset($this->URI[2])) {
        return array_slice($this->URI, 2);
      }
      return false;
    }

    function shift() {
      if(isset($this->URI))
      array_shift($this->URI);
    }
  }
?>
