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
      Database::insertIntoTable('trash_fruits', ["Pineapple", 5, 1]);
      Database::insertIntoTable('trash_fruits', ["Generic fruit", 1, 0]);
      Database::insertIntoTable('trash_fruits', ["A telephone provider from 1980", '2600hz', 1]);
    }

    public function build() {
      $template = File::getTemplate('index');
      return Template::buildTemplate($template);
    }
  }
?>
