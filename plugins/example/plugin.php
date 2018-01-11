<?php
class ExamplePlugin extends Plugin {

  //This will be the method to define any database related structure
  function getDataStructure() {
    return [
      "example" => [
        "number" => "REAL",
        "string" => "TEXT",
      ],
    ];
  }

  //setup will be called if the getDataStructure function reports a different structure than the database reports
  function setup($db) {
    $data = [ "number" => 420, "string" => "Blaze it"];
    $db->insertIntoTable("example", $data);
    $data = [ "number" => 3.14, "string" => "011010000110100100100001"];
    $db->insertIntoTable("example", $data);
  }

  //all data fetching will happen while initializing. Store whats needed for the views to work in class variables
  function initialize($db) {
    $this->data = $db->getAllFromTable("example");
  }

  //this is a method called when a tag is found in a template
  //this method is hooked in the function below
  function view() {
    //get page data
    $payload = "";
    foreach($this->data as $row) {
    $payload .= $row['number'] . ": " . $row['string'] . "<br />";
    }
    return $payload;
  }

  //A required function needed to register all tags the plugin provides
  //Can be empty if there are no tags, it has to exist tho.
  function registerTags($tagEngine) {
    $tagEngine->register("example", [$this, 'view']);
  }

  function getMetaData() {
    return ['name' => 'A test plugin','description' => 'Does some funky stuff'];
  }
}

return new ExamplePlugin();
?>
