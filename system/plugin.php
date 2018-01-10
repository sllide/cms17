<?php
  abstract class Plugin {
    abstract protected function getDataStructure();
    abstract protected function setup($db);
    abstract protected function registerTags($tagEngine);
  }
?>
