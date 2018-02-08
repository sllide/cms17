<?php
  return new class implements Plug {
    public function init() {
      Template::addTag('rows', [$this, 'rows']);
    }

    public function rows() {
      $data = "";
      $rows = Database::getAllFromTable('trash__cucumber');
      foreach($rows as $row) {
        $data .= print_r($row,true) . "<br />";
      }
      return $data;
    }

    public function install() {
      Database::insertIntoTable('trash__cucumber', ["YES", "NO?", "okay"]);
    }

    public function build() {
      $template = File::getTemplate('index');
      return Template::buildTemplate($template);
    }
  }
?>
