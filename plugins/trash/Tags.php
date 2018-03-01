<?php
  return new class implements Tags {
    
    function rows() {
      $template = File::getTemplate('row');
      $data = "";
      $rows = Database::getFromTable('trash_cucumber');
      foreach($rows as $row) {
        $data .= Template::buildTemplateVars($template, print_r($row, true));
      }
      return $data;
    }

    function fruitRows() {
      $template = File::getTemplate('fruitrow');
      $data = "";
      $rows = Database::getFromTable('trash_fruits');
      foreach($rows as $row) {
        $data .= Template::buildTemplateVars($template, $row[0], $row[1], $row[2]);
      }
      return $data;
    }
  }
?>
