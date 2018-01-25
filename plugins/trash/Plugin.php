<?php
  return new class extends AbstractPlugin {
    public function init() {
      $this->get('template')->addTag('rows', [$this, 'rows']);
    }

    public function rows() {
      $data = "";
      $rows = $this->get('database')->getAllFromTable('trash__cucumber');
      foreach($rows as $row) {
        $data .= print_r($row,true) . "<br />";
      }
      return $data;
    }

    public function install() {
      $this->get('database')->insertIntoTable('trash__cucumber', ["YES", "NO?", "okay"]);
    }

    public function build() {
      $template = $this->get('file')->getTemplate('index');
      return $this->get('template')->buildTemplate($template);
    }
  }
?>
