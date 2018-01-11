<?php
  require_once("system/classLoader.php");

  //initialize database
  $database = new Database();
  $databaseHelper = new DatabaseHelper($database);

  //enable system watcher
  $systemWatcher = new SystemWatcher($database, $databaseHelper);

  if(!$systemWatcher->validateSystem()) {
    require_once("layout/setup.php");
    die;
  }

  //load template engine
  $tagEngine = new TagEngine($database);
  $templateEngine = new TemplateEngine($tagEngine);



  //load all plugins
  $pluginManager = new PluginManager($database, $tagEngine);
  $pluginManager->load();

  //validate plugin database structure
  foreach($pluginManager->getPlugins() as $plugin) {
    if(!$databaseHelper->validateDataStructure($plugin->getDataStructure())) {
      $databaseHelper->buildDataStructure($plugin->getDataStructure());
      $plugin->setup($database);
    }
  }

  $pluginManager->initializeAll();

  //build page

  if(isset($_GET['admin'])) {
    echo file_get_contents("panel/admin.php");
  } else {
    $page = file_get_contents("layout/index.html");
    $output = $templateEngine->build($page);
    echo $output;
  }
?>
