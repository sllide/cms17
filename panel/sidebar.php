<?php
  //what to highlight?
  //how to highlight?
  //what?

  $pluginLinks = "";
  foreach($pluginManager->getPlugins() as $key => $plugin) {
    $data = $plugin->getMetaData();
    if(file_exists("plugins/$key/panel.php")) {
      $pluginLinks .= "<li><a href='/?admin&page=plugins&plugin=$key'>".$data['name']."</a></li>";
    }
  }
?>
<aside class="menu">
  <ul class="menu-list">
    <li><a href="/?admin">Dashboard</a></li>
    <li><a href="/?admin&page=tags">Tags</a></li>
    <li>
      <a href="/?admin&page=plugins">Plugins</a>
      <ul>
        <?=$pluginLinks?>
      </ul>
    </li>
  </ul>
</aside>
