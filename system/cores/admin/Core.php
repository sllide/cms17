<?php
  return new class extends AbstractCore {

    function init() {
      $this->template = $this->get('file')->getTemplate('index');
      $this->registerTags();
    }

    function registerTags() {
      $this->get('template')->addRequiredTag("navigation", [$this, 'navigation']);
      $this->get('template')->addRequiredTag("pluginNavigation", [$this, 'pluginNavigation']);
      $this->get('template')->addRequiredTag("page", [$this, 'page']);
    }

    function build() {
      return $this->get('template')->buildTemplate($this->template);
    }

    //TAG CALLBACKS


    function navigation() {
      return $this->get('file')->getTemplate('sidebar');
    }

    function pluginNavigation() {
      $data = "";
      //get plugin panels
      $activePlugins = $this->get('database')->system->getEnabledPlugins();
      foreach($activePlugins as $row) {
        $key = $row['name'];
        if($this->get('file')->doesPluginExist($key)) {
          $pluginData = require("plugins/$key/Data.php");
          $name = $pluginData->name;
          $data .= "<li><a href='/admin/plugin/$key'>$name</a></li>";
        }
      }
      return $data;
    }

    function page() {
      $page = $this->get('router')->getPage();
      switch($page) {
        case 'plugins':
          return $this->get('file')->getExtention("Plugins")->build();
        case 'dashboard':
        case 'home':
          return $this->get('file')->getExtention("Dashboard")->build();
        default:
          return "Page not found";
      }
    }
  }
?>
