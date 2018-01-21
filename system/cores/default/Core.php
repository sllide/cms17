<?php
  return new class extends AbstractCore {

    function init() {
      $this->getPage();

      $this->loader->get('template')->addRequiredTag("content", [$this, "content"]);
      $this->loader->get('template')->addRequiredTag("navigation", [$this, "navigation"]);
      $this->loader->get('template')->addRequiredTag("pluginContent", [$this, "pluginContent"]);

      $this->loader->get('template')->addDataTag("title", "Jari.xyz");
    }

    function getPage() {
      $page = $this->loader->get('router')->getPage();
      $this->page = $this->loader->get('database')->system->getPage($page);
      if(!$this->page) {
        $this->loader->get('log')->warning("Page with name $page does not exist, mocking 404 data");
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
      $pages = $this->loader->get('database')->system->getEnabledPages();
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
        $this->loader->get('plugin')->load($key);
        return $this->loader->get('plugin')->build();
      }
      return "";
    }

    function build() {
      $template = $this->loader->get('file')->getTemplate($this->page['template']);
      $template = $this->loader->get('template')->buildTemplate($template);
      return $template;
    }
  }
?>
