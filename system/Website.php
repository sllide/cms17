<?php
  class Website {

    private $systemDataStructure = [
      "users" => [
        "username" => "TEXT UNIQUE NOT NULL",
        "password" => "TEXT NOT NULL",
        "level" => "INT NOT NULL DEFAULT 0",
      ],
      "tags" => [
        "name" => "TEXT NOT NULL",
        "value" => "TEXT NOT NULL",
      ],
      "plugins" => [
        "key" => "TEXT NOT NULL",
        "enabled" => "INT NOT NULL",
      ],
    ];

    function __construct() {
      //explode URL into global so everything has access to it :)
      $GLOBALS['PATH'] = explode ("/", strtolower($_SERVER['REQUEST_URI']));

      $this->db = new Database();

      //check if website integrity is intact
      if($this->validateWebsite()) {
        //if subdirectory is admin point execution to the control panel
        if($GLOBALS['PATH'][1] == "admin") {
          $this->loadAdminPanel();
        } else {
          $this->loadWebsite();
        }
      } else {
        //let user build website
        new SystemBuilder($this->db, $this->systemDataStructure);
      }
    }

    function loadWebsite() {
      $this->tagEngine = new TagEngine();
      $this->templateEngine = new TemplateEngine($this->tagEngine);

      $this->pluginManager = new PluginManager($this->db);
      $this->pluginManager->loadAll();
      $this->pluginManager->fireLogicHandlers();
      $this->pluginManager->registerEnabled($this->tagEngine);

      //register all data tags, these override plugin tags
      foreach($this->db->getDataTags() as $tag) {
        $this->tagEngine->registerData($tag['name'], $tag['value']);
      }

      $template = file_get_contents("../layout/index.html");
      echo $this->templateEngine->build($template);
    }

    function loadAdminPanel() {
      $this->tagEngine = new TagEngine();
      $this->templateEngine = new TemplateEngine($this->tagEngine, $this->db->getDatabaseObject());

      $this->pluginManager = new PluginManager($this->db);
      $this->pluginManager->loadAll();
      $this->pluginManager->firePanelLogicHandlers();

      //load all required components for admin panel
      $this->sidebarController = new SidebarController($this->pluginManager, $this->db);
      $this->sidebarController->registerTags($this->tagEngine);
      $this->pageController = new PageController($this->pluginManager);
      $this->pageController->registerTags($this->tagEngine);
      $this->dashboardController = new DashboardController($this->db);
      $this->dashboardController->registerTags($this->tagEngine);
      $this->pluginController = new PluginController($this->pluginManager, $this->db);
      $this->pluginController->registerTags($this->tagEngine);

      $template = file_get_contents("../layout/admin/index.html");
      echo $this->templateEngine->build($template);
    }

    function validateWebsite() {
      return $this->db->helper->validateDataStructure($this->systemDataStructure);
    }
  }
?>
