<?php
  return new class {

      private $tags = [];

      const TAG = 1;
      const REQUIRED = 2;
      const SINGLE = 3;
      const DATA = 4;

      function addTag($name, $type, callable $callback) {
        if(isset($this->tags[$name])) {
          $this->log->warning("Tag <b>$name</b> already set.");
          return;
        }
        $this->tags[$name] = [$type, $callback];
      }

      function addDataTag($name, $content) {
        if(isset($this->tags[$name])) {
          $this->log->warning("Tag <b>$name</b> already set.");
          return;
        }
        $this->tags[$name] = [$this::DATA, $content];
      }

      function getTagContent($tag) {
        if(isset($this->tags[$tag])) {
          $type = $this->tags[$tag][0];
          $content = $this->tags[$tag][1];

          switch($type) {
            case $this::DATA:
              return $content;
            case $this::REQUIRED:
            case $this::SINGLE:
              unset($this->tags[$tag]);
            case $this::TAG:
              return $content();
          }
        }
      }

      function getRequiredTags() {
        $required = [];
        foreach($this->tags as $key => $value) {
          if($value[0] == $this::REQUIRED) {
            array_push($required, $key);
          }
        }
        return $required;
      }
  }
?>
