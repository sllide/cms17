<?php
  return new class extends Plugin {

    function initialize() {
      $this->data = "@welcomeMessage@";
    }

    function build() {
      return $this->service->template->buildTemplate($this->data);
    }

    function handleRequest($post) {

    }
  }
?>
