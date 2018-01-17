<?php
  class PostEngine extends Engine {
    function processPostData() {
      $data = $this->serializePath($this->engine->routing->getPath());
      if(isset($data['panel'])) {
        return $this->sendToPanel($data);
      }
    }

    function sendToPanel($data) {
      if($data['panel'] == "tag") {
        $panel = new TagPanel($this->engine);
        return $panel->handleRequest($data);
      }
    }

    function serializePath($path) {
      $newPath = [];
      for($i=0;$i<count($path);$i+=2) {
        if(isset($path[$i]) && isset($path[$i+1])) {
          $newPath[$path[$i]] = $path[$i+1];
        }
      }
      return $newPath;
    }
  }
?>
