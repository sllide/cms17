<?php
  class TagEngine extends Engine {
    private $tagList = [];

    function registerPluginTag($tag, $plugin) {
      if(isset($this->tagList[$tag])) return;
      $this->tagList[$tag] = ['type' => 'plugin', 'value' => $plugin];
    }

    function registerDataTag($tag, $value) {
      if(isset($this->tagList[$tag])) return;
      $this->tagList[$tag] = ['type' => 'data', 'value' => $value];
    }

    function registerSystemTag($tag, Callable $value) {
      if(isset($this->tagList[$tag])) return;
      $this->tagList[$tag] = ['type' => 'system', 'value' => $value];
    }

    function getTagValue($tagName) {
      if(!isset($this->tagList[$tagName])) {
        return false;
      }

      $tag = $this->tagList[$tagName];

      if($tag['type'] == 'data') {
        return $tag['value'];
      }

      if($tag['type'] == 'system') {
        return $tag['value']();
      }

      return $this->engine->plugin->getPluginTagValue($tag['value'], $tagName);
    }

    function getTagList() {
      return $this->tagList;
    }
  }
?>
