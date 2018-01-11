<?php
  require_once("system/classLoader.php");

  //load template engine
  $tagEngine = new tagEngine();
  $templateEngine = new templateEngine($tagEngine);

  //load all plugins
  $pluginManager = new pluginManager();
  $pluginManager->load($tagEngine);

  //build page
  $page = file_get_contents("layout/index.html");
  $output = $templateEngine->build($page);
  echo $output;
?>
