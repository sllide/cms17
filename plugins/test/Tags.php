<?php
  return new class extends PluginTags {
    function welcomeMessage() {
      return $this->service->template->buildTemplate();
    }
  }
?>
