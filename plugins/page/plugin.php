<?php
class PagePlugin extends Plugin {

  function getDataStructure() {
    return [
      "pages" => [
        "title" => "TEXT",
        "key" => "TEXT",
        "path" => "TEXT",
        "enabled" => "INT NOT NULL DEFAULT 0",
      ],
    ];
  }

  function setup($db) {
    $db->exec("INSERT INTO pages (title, key, path, enabled) VALUES('Home', 'home', 'home.html', 1)");
  }

  function handleLogic($db) {
    $s = $db->query("SELECT * FROM pages");
    $this->links = $s->fetchAll();
  }

  function handlePanelLogic($db) {

  }

  function navigationView() {
    $payload = "";
    foreach($this->links as $row) {
      $key = $row['key'];
      $title = $row['title'];
      $payload .= "<a href='/$key'>$title</a>&nbsp;";
    }
    return $payload;
  }

  function pageView() {
    //get page data
    return $this->getPage();
  }

  function getPage() {
    $pagePath = "../pages/";
    //default to home
    $pageKey = "home";

    //check if first sub dir is set
    //if so set the page key
    if(isset($GLOBALS['PATH'][1]) && strlen($GLOBALS['PATH'][1])>0) {
      $pageKey = $GLOBALS['PATH'][1];
    }

    //go over all pages entries
    foreach($this->links as $row) {
      if($row['key'] == $pageKey) {
        //if its there and enabled return the content
        if($row['enabled'] == 1 && file_exists($pagePath . $row['path'])) {
          return file_get_contents($pagePath . $row['path']);
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
    $tagEngine->register("navigation", [$this, 'navigationView']);
  }

  function registerPanelTags($tagEngine) {

  }

  function getPanelView() {
    return "page";
  }

  function getMetaData() {
    return [
      'name' => 'Page controller',
      'description' => 'Show multiple pages and create navigation bars!',
    ];
  }
}

return new PagePlugin();
?>
