<?php
  return new class extends AbstractEngine {
    private $direct = true;

    const TYPE_NOTICE = 1;
    const TYPE_WARNING = 2;
    const TYPE_ERROR = 3;
    const TYPE_PHP_NOTICE = 4;
    const TYPE_PHP_WARNING = 5;
    const TYPE_PHP_ERROR = 6;

    public function init(){

    }

    public function notice($message) {
      $invoker = $this->who['type'] . " " . $this->who['system'];
      if($this->direct) {
        $this->directLog($invoker, $this::TYPE_NOTICE, $message);
      }
    }

    public function warning($message) {
      $invoker = $this->who['type'] . " " . $this->who['system'];
      if($this->direct) {
        $this->directLog($invoker, $this::TYPE_WARNING, $message);
      }
    }

    public function error($message) {
      $invoker = $this->who['type'] . " " . $this->who['system'];
      if($this->direct) {
        $this->directLog($invoker, $this::TYPE_ERROR, $message);
      }
    }

    private function directLog($invoker, $type, $message) {
      $color = $this->getMessageColor($type);
      $error = $this->getMessageTitle($type);

      echo "<div style='padding: 2px 0px 5px 5px; margin:0px; background-color: $color;'>";
        echo "<div style='padding-bottom: 3px; color: white;'><b>$invoker</b> raised $error</div>";
        echo "<div style='padding: 2px; background-color: white'>$message</div>";
      echo "</div>";
    }

    private function getMessageColor($type) {
      switch($type) {
        case $this::TYPE_NOTICE:
        case $this::TYPE_PHP_NOTICE:
          return 'ForestGreen';
        case $this::TYPE_WARNING:
        case $this::TYPE_PHP_WARNING:
          return 'GoldenRod';
        case $this::TYPE_ERROR:
        case $this::TYPE_PHP_ERROR:
          return 'DarkRed';
        default:
          return 'Black';
      }
    }

    private function getMessageTitle($type) {
      switch($type) {
        case $this::TYPE_NOTICE:
          return 'System notice';
        case $this::TYPE_WARNING:
          return 'System warning';
        case $this::TYPE_ERROR:
          return 'System error';
        case $this::TYPE_PHP_NOTICE:
          return 'PHP notice';
        case $this::TYPE_PHP_WARNING:
          return 'PHP warning';
        case $this::TYPE_PHP_ERROR:
          return 'PHP error';
        default:
          return 'Unknown error';
      }
    }
  }
?>
