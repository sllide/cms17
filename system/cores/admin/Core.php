<?php
  return new class implements Core {

    function init() {
      $this->template = File::getTemplate('index');
      $this->registerTags();
    }

    function registerTags() {
      Template::addRequiredTag("navigation", [$this, 'navigation']);
      Template::addRequiredTag("pluginNavigation", [$this, 'pluginNavigation']);
      Template::addRequiredTag("page", [$this, 'page']);
    }

    function build() {
      return Template::buildTemplate($this->template);
    }

    //TAG CALLBACKS

    function navigation() {
      return File::getTemplate('sidebar');
    }

    function pluginNavigation() {
      $data = "";
      //get plugin panels
      $activePlugins = Database::$system->getEnabledPlugins();
      foreach($activePlugins as $row) {
        $key = $row['name'];
        if(File::doesPluginExist($key)) {
          $pluginData = require("plugins/$key/Data.php");
          $name = $pluginData->name();
          $data .= "<li><a href='/admin/plugin/$key'>$name</a></li>";
        }
      }
      return $data;
    }

    function page() {
      $page = Router::getPage();
      switch($page) {
        case 'plugins':
          return File::getExtension("Plugins")->build();
        case 'log':
          return File::getExtension("Log")->build();
        case 'dashboard':
        case 'home':
          return File::getExtension("Dashboard")->build();
        default:
          return "Page not found";
      }
    }
  }
?>