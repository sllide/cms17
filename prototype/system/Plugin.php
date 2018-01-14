<?php
  abstract class Plugin {
    abstract protected function getDataStructure();
    abstract protected function setup($db);
    abstract protected function handleLogic($db);
    abstract protected function handlePanelLogic($db);
    abstract protected function registerTags($tagEngine);
    abstract protected function registerPanelTags($tagEngine);
    abstract protected function getPanelView();
    abstract protected function getMetaData();
  }
?>
