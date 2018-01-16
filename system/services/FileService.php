<?php
  class FileService extends Service {
    function getTemplate($path) {
      $path = "plugins/".$this->pluginKey . "/templates/$path";
      return $this->engine->file->getFile($path);
    }
  }
?>
