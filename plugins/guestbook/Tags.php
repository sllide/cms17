<?php
  return new class implements Tags {
    
    function rows() {
      $data = "";
      $rows = Database::getFromTable('guestbook_messages');
      foreach($rows as $row) {
        $data .= print_r($row,true) . "<br />";
      }
      return $data;
    }

  }
?>
