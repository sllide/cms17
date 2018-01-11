<?php
  require_once("system/classLoader.php");

  //initialize database
  $database = new Database();

  //load template engine
  $tagEngine = new TagEngine();
  $templateEngine = new TemplateEngine($tagEngine);

  //load all plugins
  $pluginManager = new PluginManager($database, $tagEngine);
  $pluginManager->load();

  //build page
  $page = file_get_contents("layout/index.html");
  $output = $templateEngine->build($page);
  echo $output;
?>
