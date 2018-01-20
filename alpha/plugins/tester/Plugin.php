<?php
  return new class extends Plugin {

    function install() {
    }

    function initialize() {
    }

    function build() {
      return $this->service->template->buildTemplate("@welcomeMessage@");
    }

    function handleRequest($post) {

    }
  }
?>
