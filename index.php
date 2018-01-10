<?php
  // require_once("system/superPlugin.php");
  // $plugin = require_once("plugins/page/plugin.php");
  // $tagEngine = require_once("system/tagEngine.php");
  // $plugin->registerTags($tagEngine);
  // echo $tagEngine->getTagMethod("page")();
  // require_once("system/superPlugin.php");
  // require_once("plugins/page/plugin.php");
  // require_once("system/tagEngine.php");
  // require_once("system/templateEngine.php");
  require_once("system/classLoader.php");

  $tagEngine = new TagEngine();
  $templateEngine = new TemplateEngine($tagEngine);

  //load all plugins
  $pluginLoader = new pluginLoader();
  $pluginLoader->load($tagEngine);

  $page = file_get_contents("layout/index.html");
  $output = $templateEngine->build($page);
  echo $output;
?>
