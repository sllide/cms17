<?php
return new class implements Tags {

    function content() {
      $page = System::getPage(Router::getPage());
      return $page['content'];
    }

    function navigation() {
      $navbar = "";
      $pages = System::getEnabledPages();
      foreach($pages as $page) {
        $path = $page['path'];
        $title = $page['title'];
        $navbar .= "<div class='link'><a href='/$path'>$title</a></div>";
      }
      return $navbar;
    }

    function pluginContent() {
      $page = System::getPage(Router::getPage());
      if($page['pluginKey']) {
        $key = $page['pluginKey'];
        Plugin::load($key);
        return Plugin::build();
      }
      return "";
    }

  }
?>
