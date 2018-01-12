<?php
  class PluginController {
    function __construct($pluginManager, $database) {
      $this->pluginManager = $pluginManager;
      $this->plugins = $pluginManager->getPlugins();
      $this->db = $database;
      if(isset($_POST['actor']) && $_POST['actor'] == 'plugin') $this->handlePost();
    }

    function handlePost() {
      switch($_POST['action']) {
        case 'Install':
          $this->db->insert->plugin($_POST['key'],1);
          $this->db->helper->buildDataStructure($this->pluginManager->getPlugin($_POST['key'])->getDataStructure());
          $this->pluginManager->getPlugin($_POST['key'])->setup($this->db->getDatabaseObject());
          header("Refresh:0");
          die;
        case 'Enable':
          $this->db->update->plugin($_POST['key'],1);
          header("Refresh:0");
          die;
        case 'Disable':
          $this->db->update->plugin($_POST['key'],0);
          header("Refresh:0");
          die;
      }
    }

    function pluginControlList() {
      $payload = "";
      foreach($this->plugins as $key => $plugin) {
        $payload .= "<tr>";
        $payload .= "<td>".$plugin->getMetaData()['name']."</td>";
        $payload .= "<td>".$key."</td>";
        $payload .= "<td>".$this->getPluginStatus($key)."</td>";
        $payload .= "<td>".$this->getPluginAction($key)."</td>";
        $payload .= "</tr>";
      }
      return $payload;
    }

    function getPluginStatus($key) {
      $state = $this->db->helper->getPluginStatus($key);
      if($state == -1) return "Not initialized";
      if($state == 0) return "Disabled";
      if($state == 1) return "Enabled";
      return "state unknown!?";
    }

    function getPluginAction($key) {
      $action = "";
      $state = $this->db->helper->getPluginStatus($key);
      if($state == -1) $action = "Install";
      if($state == 0) $action = "Enable";
      if($state == 1) $action = "Disable";
      return "<form method='post'><input type='hidden' name='actor' value='plugin' /><input type='hidden' name='action' value='$action' /><input type='hidden' name='key' value='$key' /><input type='submit' class='button' value='$action' /></form>";
    }

    function registerTags($tagEngine) {
      $tagEngine->register("pluginControlList", [$this, "pluginControlList"]);
    }
  }
?>
