<?php
class PagePlugin extends Plugin {

  function getDataStructure() {
    return "";
  }

  function setup($db) {
    return true;
  }

  function pageView() {
    //get page data
    return $this->getPage();
  }

  function getPage() {
    $pagePath = "pages/";

    //check if GET variable page is set
    //if so join it in the path, if not set the path to point to home.html

    if(!isset($_GET['page'])) {
      $_GET['page'] = "home";
    }
    $pagePath .= $_GET['page'] . ".html";

    //check if file exists and load if it does
    //else return page not found string
    if(file_exists($pagePath)) {
      return file_get_contents($pagePath);
    }

    return "page '" . $_GET['page'] . "' does not exist.";
  }

  function registerTags($tagEngine) {
    $tagEngine->register("page", [$this, 'pageView']);
  }
}

return new PagePlugin();
?>
