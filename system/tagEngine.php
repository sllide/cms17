<?php
  class tagEngine {

    private $tagList;

    function __construct() {
      $this->tagList = array();
    }

    function register($tagName, callable $function) {
      $this->tagList[$tagName] = $function;
    }

    function getTagValue($tagName) {
      //search for all known tags
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
