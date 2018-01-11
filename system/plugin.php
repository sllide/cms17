<?php
  abstract class plugin {
    abstract protected function getDataStructure();
    abstract protected function setup($db);
    abstract protected function registerTags($tagEngine);
  }
?>
