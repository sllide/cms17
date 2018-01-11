<?php
class PagePlugin extends Plugin {

  function getDataStructure() {
    return [
      "pages" => [
        "key" => "TEXT NOT NULL DEFAULT key",
        "path" => "TEXT NOT NULL DEFAULT path",
        "enabled" => "INT NOT NULL DEFAULT 0",
      ],
    ];
  }

  function setup($db) {
    $data = [
      "title" => "Home",
      "key" => "home",
      "path" => "home.html",
      "enabled" => 1,
    ]; $db->insertIntoTable("pages", $data);
  }

  function initialize($db) {
    $this->data = $db->getAllFromTable("pages");
  }

  function pageView() {
    //get page data
    return $this->getPage();
  }

  function getPage() {
    $pagePath = "pages/";
    //default to home
    $pageKey = "home";

    //check if GET variable page is set
    //if so set the page key
    if(isset($_GET['page'])) {
      $pageKey = $_GET['page'];
    }

    //go over all pages entries
    foreach($this->data as $row) {
      if($row['key'] == $pageKey) {
        //if its there and enabled return the content
        if($row['enabled'] == 1 && file_exists("pages/" . $row['path'])) {
          return file_get_contents("pages/" . $row['path']);
        } else {
          break;
        }
      }
    }

    //return false if page isnt or not accesable
    return "Page " . $pageKey . " not found. :(";
  }

  function registerTags($tagEngine) {
    $tagEngine->register("page", [$this, 'pageView']);
  }

  function getMetaData() {
    return ['name' => 'Page view','description' => 'Shows pages'];
  }
}

return new PagePlugin();
?>
