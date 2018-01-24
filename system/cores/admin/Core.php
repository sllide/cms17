<?php
  return new class extends AbstractCore {

    function init() {
      $this->template = $this->loader->get('file')->getTemplate('index');
      $this->registerTags();
    }

    function registerTags() {
      $this->loader->get('template')->addRequiredTag("navigation", [$this, 'navigation']);
      $this->loader->get('template')->addRequiredTag("pluginNavigation", [$this, 'pluginNavigation']);
      $this->loader->get('template')->addRequiredTag("page", [$this, 'page']);
    }

    function build() {
      return $this->loader->get('template')->buildTemplate($this->template);
    }

    //TAG CALLBACKS


    function navigation() {
      return $this->loader->get('file')->getTemplate('sidebar');
    }

    function pluginNavigation() {
      $data = "";
      //get plugin panels
      $activePlugins = $this->loader->get('database')->system->getEnabledPlugins();
      foreach($activePlugins as $row) {
        $key = $row['name'];
        if($this->loader->get('file')->doesPluginExist($key)) {
          $pluginData = require("plugins/$key/Data.php");
          $name = $pluginData->name;
          $data .= "<li><a href='/admin/plugin/$key'>$name</a></li>";
        }
      }
      return $data;
    }

    function page() {
      $page = $this->loader->get('router')->getPage();
      switch($page) {
        case 'plugins':
          return $this->loader->get('file')->getExtention("Plugins")->build();
        case 'dashboard':
        case 'home':
          return $this->loader->get('file')->getExtention("Dashboard")->build();
        default:
          return "Page not found";
      }
    }
  }
?>
