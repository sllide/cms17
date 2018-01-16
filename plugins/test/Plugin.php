<?php
  return new class extends Plugin {

    function initialize() {
    }

    function build() {
      return $this->service->template->buildTemplate("@welcomeMessage@");
    }

    function handleRequest($post) {

    }
  }
?>
