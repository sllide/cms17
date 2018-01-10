<?php
class examplePlugin extends Plugin {

  function getDataStructure() {
    return "";
  }

  function setup($db) {
    return true;
  }

  function view() {
    //get page data
    return "damn son";
  }

  function registerTags($tagEngine) {
    $tagEngine->register("example", [$this, 'view']);
  }
}

return new examplePlugin();
?>
