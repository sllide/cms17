<?php
  return new class {
    function build() {
      Template::addTag('list', [$this, 'logList']);
      return File::getTemplate('log/index');
    }

    function logList() {
      $data = "";
      $log = Database::getAllFromTable('log');
      foreach($log as $row) {
        $entry = "<tr><td>%s</td><td>%s</td><td>%s</td></tr>";
        $data .= sprintf($entry, $row['invoker'], $row['type'], $row['message']);
      } 
      return $data;
    }
  }
?>
