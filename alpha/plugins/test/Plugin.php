<?php
  return new class extends Plugin {

    function install() {
      $data = ['name' => 'Test install', 'message' => "succesful", 'magicNumber' => 420];
      $this->service->database->insertStructIntoTable('one', $data);
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
