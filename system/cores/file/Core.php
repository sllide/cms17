<?php
  return new class implements Core {

    private $output;

    function init() {
      //disable direct logging so it doesnt mess with the file contents
      Log::setDirectLog(false);
      $file = Router::getPage();
      $path = "system/files/$file";
      if(file_exists($path)) {
        $mime = $this->getType($path);
        header("Content-type: $mime");
        $this->output = file_get_contents($path);
      }
    }

    function getType($path) {
      //css doesnt get picked up by mime_content_type :(
      if(substr($path, count($path)-4) === "css") {
        return "text/css";
      }
      return mime_content_type($path);
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
