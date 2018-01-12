<?php
  class TagEngine {

    function __construct() {
      $this->tagList = array();
    }

    function register($tagName, callable $function) {
      $this->tagList[$tagName] = $function;
    }

    function registerData($tagName, $data) {
      $this->tagList[$tagName] = $data;
    }

    function registerDataTags() {
      $matches = $this->database->getAllFromTable("tags");
      foreach($matches as $row) {
        $this->tagList[$row['name']] = $row['value'];
      }
    }

    function getTagObject($tagName) {
      //find tag
      if(isset($this->tagList[$tagName])) {
        $tag = $this->tagList[$tagName];
        if(is_string($tag)) {
          return false;
        }

        return $tag[0];
      }
      //return false if no tag could be found
      return false;
    }

    function getTagValue($tagName) {
      //find tag
      if(isset($this->tagList[$tagName])) {
        $tag = $this->tagList[$tagName];
        if(is_string($tag)) {
          return $tag;
        }

        return $tag();
      }
      //return false if no tag could be found
      return false;
    }

    function getTags() {
      return $this->tagList;
    }
  }
?>
