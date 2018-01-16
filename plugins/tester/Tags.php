<?php
  return new class extends PluginTags {
    function welcomeMessage() {
      return "@nested@";
    }

    function nested() {
        return $this->service->file->getTemplate("template");
    }

    function templateNested() {
      return print_r($this->service->database->getTableData("one"), true);
    }
  }
?>
