<?php
  return new class implements Tags {
    function sidebar() {
      return File::getTemplate('sidebar');
    }

    function navigation() {
      return File::getTemplate('navigation');
    }

    function pluginNavigation() {
      $data = "";
      //get plugin panels
      $activePlugins = System::getEnabledPlugins();
      foreach($activePlugins as $row) {
        $key = $row['name'];
        if(File::doesPluginExist($key)) {
          $pluginData = require("plugins/$key/Data.php");
          $name = $pluginData->name();
          $data .= "<li><a href='/admin/plugin/$key'><span class='uk-margin-small-right' uk-icon='icon: minus'></span>$name</a></li>";
        }
      }
      return $data;
    }

    function page() {
      $page = Router::getPage();
      return $page;  
    }
  }
?>
