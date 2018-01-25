<?php
  return new class extends AbstractCore {

    function init() {
      $params = $this->get('router')->getParameters();

      //if not all parameters are there, return a file not found
      if($params && count($params)<2) { return; }

      //get parameters
      $systemType = $this->get('router')->getPage();
      $system = $this->get('router')->getAction();
      $fileType = $params[0];
      $fileName = $params[1];

      //construct path
      $path = "";
      switch($systemType) {
        case "core":
          $path .= "system/cores/";
          break;
        default:
          return;
      }

      $path .= $system . "/";

      switch($fileType) {
        case "image":
          $path .= "images/";
          break;
        case "css":
          $path .= "css/";
          break;
        default:
          return;
      }

      $path .= $fileName;
      if(!file_exists($path) || is_dir($path)) {
        return;
      }
      
      //set mime type accordingly
      switch($fileType) {
        case "css":
          header("Content-type: text/css");
          break;
        default:
          $mime = mime_content_type($path);
          header("Content-type: $mime");
      }

      $this->output = file_get_contents($path);
    }

    function build() {
      if(!isset($this->output)) {
        $this->show404();
      }
      return $this->output;
    }

    private function show404() {
      header("HTTP/1.0 404 Not Found");
      $this->output = "File not found.";
    }
  }
?>
