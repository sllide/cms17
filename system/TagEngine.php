<?php
  class TagEngine {

    private $tagList;

    function __construct($database) {
      $this->database = $database;
      $this->tagList = array();
    }

    function register($tagName, callable $function) {
      $this->tagList[$tagName] = $function;
    }

    function getTagValue($tagName) {
      //look for data matches
      $matches = $this->database->getAllMatchesFromTable("tags", "name = '$tagName'");
      if(count($matches)>0) {
        return $matches[0]['value'];
      }
      //if no data tag exist look for plugin tag
      if(isset($this->tagList[$tagName])) {
        return $this->tagList[$tagName];
      }
      //return false if no tag could be found
      return false;
    }

    function getTags() {
      return $this->tagList;
    }
  }
?>
