<?php
  class PostCore extends Core {
    function initialize() {
      header('Content-Type: application/json');
      $returnData = $this->engine->post->processPostData();
      echo json_encode($returnData);
    }

    function build() {

    }
  }
?>
