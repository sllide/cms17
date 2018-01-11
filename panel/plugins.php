<?php
  if(isset($_GET['plugin'])) {
    $urlKey = $_GET['plugin'];
    if(file_exists("plugins/$urlKey/panel.php")) {
      require_once("plugins/$urlKey/panel.php");
    }
  }
?>
