<?php
  return new class extends Plugin {

    function initPlugin() {
      $this->data = "initted";
    }

    function initConfig() {

    }

    function buildTag($tagName) {
      return "built $tagName " . $this->data;
    }

    function doPost($post) {

    }

    function doConfigPost($post) {

    }
  }
?>
