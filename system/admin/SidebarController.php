<?php
  class SidebarController {
    function __construct($pluginManager, $database) {
      $this->plugins = $pluginManager->getPlugins();
      $this->db = $database;
    }

    function pluginListView() {
      $payload = "";
      foreach($this->plugins as $key => $plugin) {
        if($this->db->helper->getPluginStatus($key) == 1) {
            $payload .= "<li><a href='/admin/plugins/$key'>".$plugin->getMetaData()['name']."</a></li>";
        }
      }
      return $payload;
    }

    function registerTags($tagEngine) {
      $tagEngine->registerData("sidebar", file_get_contents("../layout/admin/sidebar.html"));
      $tagEngine->register("pluginList", [$this, "pluginListView"]);
    }
  }
?>
