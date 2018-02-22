<?php
  return new class {
    function build() {
      Template::addTag('list', [$this, 'logList']);
      return '@@list@@';
    }

    function logList() {
    
    }
  }
?>
