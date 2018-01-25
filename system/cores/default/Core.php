<?php
  return new class extends AbstractCore {

    function init() {
      $this->getPage();

      $this->get('template')->addRequiredTag("content", [$this, "content"]);
      $this->get('template')->addRequiredTag("navigation", [$this, "navigation"]);
      $this->get('template')->addRequiredTag("pluginContent", [$this, "pluginContent"]);

      $this->get('template')->addDataTag("title", "Jari.xyz");
    }

    function getPage() {
      $page = $this->get('router')->getPage();
      $this->page = $this->get('database')->system->getPage($page);
      if(!$this->page) {
        $this->get('log')->warning("Page with name $page does not exist, mocking 404 data");
        $this->page = [
          'title' => "404",
          'path' => "404",
          'content' => "404",
          'template' => "index",
          'pluginKey' => "",
          'enabled' => "1",
        ];
      }
    }

    function content() {
      return $this->page['content'];
    }

    function navigation() {
      $navbar = "";
      $pages = $this->get('database')->system->getEnabledPages();
      foreach($pages as $page) {
        $path = $page['path'];
        $title = $page['title'];
        $navbar .= "<a href='/$path'>$title</a>&nbsp;";
      }
      return $navbar;
    }

    function pluginContent() {
      if($this->page['pluginKey']) {
        $key = $this->page['pluginKey'];
        $this->get('plugin')->load($key);
        return $this->get('plugin')->build();
      }
      return "";
    }

    function build() {
      $template = $this->get('file')->getTemplate($this->page['template']);
      $template = $this->get('template')->buildTemplate($template);
      return $template;
    }
  }
?>
