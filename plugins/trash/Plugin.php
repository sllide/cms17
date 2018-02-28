<?php
  return new class implements Plug {
    public function init() {
    }

    public function install() {
      Database::insertIntoTable('trash_cucumber', ["YES", "NO?", "okay"]);
      Database::insertIntoTable('trash_cucumber', ["32", "NO?", "okay"]);
      Database::insertIntoTable('trash_cucumber', ["6", "NO?", "okay"]);
      Database::insertIntoTable('trash_cucumber', ["2", "NO?", "okay"]);
      Database::insertIntoTable('trash_cucumber', ["Y5", "NA?", "fffkay"]);
      Database::insertIntoTable('trash_cucumber', ["Y2S", "Na?", "okay"]);
    }

    public function build() {
      $template = File::getTemplate('index');
      return Template::buildTemplate($template);
    }
  }
?>
