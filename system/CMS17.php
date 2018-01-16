<?php
  class CMS17 {

    private $engine;
    private $core;

    function __construct() {
      $this->engine = new stdClass();
      $this->initializeEngines();

      //if the database is empty boot the installer instead of the website
      if(!$this->engine->database->hasData()) {
        $this->bootInstaller();
        return;
      }
      $this->bootWebsite();
    }

    function bootWebsite() {
      $this->core = new WebsiteCore();
      $this->core->registerEngines($this->engine);
      $this->core->initialize();
      echo $this->core->build();
    }

    function bootInstaller() {
      $this->core = new InstallerCore();
      $this->core->registerEngines($this->engine);
      $this->core->initialize();
      echo $this->core->build();
    }

    function initializeEngines() {
      $this->engine->database = new DatabaseEngine($this->engine);
      $this->engine->database->connect("system/database");
      $this->engine->plugin = new PluginEngine($this->engine);
      $this->engine->tag = new TagEngine($this->engine);
      $this->engine->template = new TemplateEngine($this->engine);
      $this->engine->service = new ServiceEngine($this->engine);
      $this->engine->file = new FileEngine($this->engine);
      $this->engine->install = new InstallEngine($this->engine);
      $this->engine->routing = new RoutingEngine($this->engine);
      $this->engine->routing->initialize();
    }
  }
?>
