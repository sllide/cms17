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
    $db->exec("INSERT INTO example (number, string) VALUES(420, 'Blaze it')");
    $db->exec("INSERT INTO example (number, string) VALUES(3.14, '011010000110100100100001')");
  }

  //all logic needed to make the plugin function will happen here
  function handleLogic($db) {
    $s = $db->query("SELECT * FROM example");
    $this->data = $s->fetchAll();
  }

  //all logic needed to make the panel function will happen here
  function handlePanelLogic($db) {

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

  function registerPanelTags($tagEngine) {

  }

  function getPanelView() {
    return "example";
  }

  function getMetaData() {
    return [
      'name' => 'Test plugin',
      'description' => 'Does some funky stuff'
    ];
  }
}

return new ExamplePlugin();
?>
