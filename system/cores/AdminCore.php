<?php
  class AdminCore extends Core {

    private $systemPanels = [];

    function initialize() {
      $this->registerTags();
      $this->registerPanels();
    }

    function registerTags() {
      //register system tags first to ensure tags are free
      $this->engine->tag->registerFunctionTag('navigation', [$this, 'navigation']);
      $this->engine->tag->registerFunctionTag('page', [$this, 'page']);
    }

    function registerPanels() {
      $this->systemPanels['home'] = new DashboardPanel($this->engine);
      $this->systemPanels['tags'] = new TagPanel($this->engine);
      $this->systemPanels['plugins'] = new PluginsPanel($this->engine);
      $this->systemPanels['plugin'] = new PluginConfigPanel($this->engine);
      $this->systemPanels['page'] = new PagePanel($this->engine);
    }

    function page() {
      $page = $this->engine->routing->getPage();
      if(isset($this->systemPanels[$page])) {
        return $this->systemPanels[$page]->build();
      }
      return "$page not found";
    }

    function navigation() {
      $data = "<p class='menu-label'>System</p>";
      $data .= "<ul class='menu-list'>";
      $data .= "<li><a href='/admin'>Dashboard</a></li>";
      $data .= "<li><a href='/admin/tags'>Tags</a></li>";
      $data .= "<li><a href='/admin/page'>Pages</a></li>";
      $data .= "</ul>";

      $data .= "<p class='menu-label'>Plugins</p>";
      $data .= "<ul class='menu-list'>";
      $data .= "<li><a href='/admin/plugins'>Plugin manager</a>";
      $data .= "<ul>";
      //get plugin panels
      $activePlugins = $this->engine->database->getEnabledPlugins();
      foreach($activePlugins as $key) {
        if($this->engine->file->doesPluginExist($key)) {
          $pluginData = require("plugins/$key/Data.php");
          $name = $pluginData->name;
          $data .= "<li><a href='/admin/plugin/$key'>$name</a></li>";
        }
      }
      $data .= "</ul></li></ul>";
      return $data;
    }

    function build() {
      $template = $this->engine->file->getTemplate("admin/index");

      return $this->engine->template->buildTemplate($template);
    }
  }
?>
