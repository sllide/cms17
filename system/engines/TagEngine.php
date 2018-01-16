<?php
  class TagEngine extends Engine {
    private $tagList = [];

    function registerDataTag($tag, $value) {
      if(isset($this->tagList[$tag])) return;
      $this->tagList[$tag] = ['type' => 'data', 'value' => $value];
    }

    function registerFunctionTag($tag, Callable $value) {
      if(isset($this->tagList[$tag])) return;
      $this->tagList[$tag] = ['type' => 'function', 'value' => $value];
    }

    function getTagValue($tagName) {
      if(!isset($this->tagList[$tagName])) {
        return false;
      }

      $tag = $this->tagList[$tagName];

      if($tag['type'] == 'data') {
        return $tag['value'];
      }

      if($tag['type'] == 'function') {
        return $tag['value']();
      }
    }
  }
?>
