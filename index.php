<?php
  require_once("system/classLoader.php");

  //
  $tagEngine = new TagEngine();
  $templateEngine = new TemplateEngine($tagEngine);

  //load all plugins
  $pluginManager = new pluginManager();
  $pluginManager->load($tagEngine);

  $page = file_get_contents("layout/index.html");
  $output = $templateEngine->build($page);
  echo $output;
?>
