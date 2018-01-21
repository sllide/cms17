<?php
  return new class extends AbstractService {
    function getTemplate($name) {
      $plugin = $this->who;
      if(file_exists("plugins/$plugin/templates/$name.html")) {
        return file_get_contents("plugins/$plugin/templates/$name.html");
      }
      $this->loader->get('log')->warning("Plugin $plugin tried to load template $name wich doesnt exist");
    }
  }
?>
