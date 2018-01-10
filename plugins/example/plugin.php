<?php
class examplePlugin extends Plugin {

  //This will be the method to define any database related structure
  function getDataStructure() {
    return "";
  }

  //setup will be called if the getDataStructure function reporst a different structure than the database reports
  function setup($db) {
    return true;
  }

  //this is a method called when a tag is found in a template
  //this method is hooked in the function below
  function view() {
    //get page data
    return "Hello example plugin!";
  }

  //A required function needed to register all tags the plugin provides
  //Can be empty if there are no tags, it has to exist tho.
  function registerTags($tagEngine) {
    $tagEngine->register("example", [$this, 'view']);
  }
}

return new examplePlugin();
?>
