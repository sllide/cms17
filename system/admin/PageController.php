<?php
  class PageController {
    function __construct($pluginManager) {
      $this->pluginManager = $pluginManager;
    }

    function pageLoader() {
      //default to dashboard and prevent looping by blocking sidebar
      if(!isset($GLOBALS['PATH'][2]) || $GLOBALS['PATH'][2] == "sidebar") {
        return file_get_contents('../layout/admin/dashboard.html');
      }

      $subPage = $GLOBALS['PATH'][2];

      if($subPage == "plugins") {
        if(isset($GLOBALS['PATH'][3])) {
          $key = $GLOBALS['PATH'][3];
          if($this->pluginManager->getPlugin($key)) {
            return $this->pluginManager->getPlugin($key)->getPanelView();
          }
        }
      }

      if(file_exists("../layout/admin/$subPage.html")) {
        return file_get_contents("../layout/admin/$subPage.html");
      }

      return file_get_contents('../layout/admin/dashboard.html');
    }

    function registerTags($tagEngine) {
      $tagEngine->register("page", [$this, "pageLoader"]);
    }
  }
?>
