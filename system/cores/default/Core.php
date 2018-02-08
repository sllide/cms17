<?php
  return new class implements Core{

    function init() {
      $this->getPage();

      Template::addRequiredTag("content", [$this, "content"]);
      Template::addRequiredTag("navigation", [$this, "navigation"]);
      Template::addRequiredTag("pluginContent", [$this, "pluginContent"]);

      Template::addDataTag("title", "Jari.xyz");
    }

    function getPage() {
      $page = Router::getPage();
      $this->page = Database::$system->getPage($page);
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
      $pages = Database::$system->getEnabledPages();
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
        Plugin::load($key);
        return Plugin::build();
      }
      return "";
    }

    function build() {
      $template = File::getTemplate($this->page['template']);
      $template = Template::buildTemplate($template);
      return $template;
    }
  }
?>
