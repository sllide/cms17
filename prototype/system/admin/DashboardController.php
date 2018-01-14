<?php
  class DashboardController {
    function __construct($db) {
      $this->db = $db;
    }

    function registerTags($tagEngine) {
      $tagEngine->registerData('totalPlugins', (string) count($this->db->getPlugins()));//count($this->db->getPlugins()));
      $tagEngine->registerData('activePlugins', (string) count($this->db->getActivePlugins()));
    }
  }
?>
