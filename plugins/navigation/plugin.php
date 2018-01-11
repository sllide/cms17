<?php
class NavigationPlugin extends Plugin {

  function getDataStructure() {
    return [
      "pages" => [
        "title" => "TEXT",
        "key" => "TEXT",
        "enabled" => "INT NOT NULL DEFAULT 0",
      ],
    ];
  }

  function setup($db) {
  }

  function initialize($db) {
    $this->data = $db->getAllFromTable("pages");
  }

  function navigationView() {
    $data = $this->getLinks();
    $payload = "";
    foreach($data as $title => $key) {
      $payload .= "<a href='/?page=$key'>$title</a> ";
    }
    return $payload;
  }

  function getLinks() {
    $data = [];
    foreach($this->data as $row) {
      if($row['enabled'] == 1) {
        $data[$row['title']] = $row['key'];
      }
    }
    return $data;
  }

  function registerTags($tagEngine) {
    $tagEngine->register("navigation", [$this, 'navigationView']);
  }

  function getMetaData() {
    return ['name' => 'Navigation bar','description' => 'Shows links to pages'];
  }
}

return new NavigationPlugin();
?>
