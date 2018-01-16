<?php
  class WebsiteCore extends Core {

    function initialize() {
      $this->registerTags();
      $this->page = $this->getPage();
    }

    function registerTags() {
      //register system tags first to ensure tags are free
      $this->engine->tag->registerFunctionTag('content', [$this, 'content']);
      $this->engine->tag->registerFunctionTag('pluginContent', [$this, 'pluginContent']);
      $this->engine->tag->registerFunctionTag('navigation', [$this, 'navigation']);

      //register data tags second to ensure system tags are free
      foreach($this->engine->database->getAllTags() as $tag) {
        $this->engine->tag->registerDataTag($tag['name'], $tag['value']);
      }
    }

    function getPage() {
        $pagePath = $this->engine->routing->getPage();
        return $this->engine->database->getPageByKey($pagePath);
    }

    function content() {
      return $this->page['content'];
    }

    function pluginContent() {
      $this->engine->plugin->load($this->page['pluginKey']);
      return $this->engine->plugin->getPlugin()->build();
    }

    function navigation() {
      $string = "";
      $pages = $this->engine->database->getEnabledPages();

      foreach($pages as $page) {
        $key = '/'.$page['path'];
        $title = $page['title'];
        $string .= "<a href='$key'>$title</a>&nbsp;";
      }

      return $string;
    }

    function build() {
      //if no page is found and the page was not home try to fetch home
      if(!$this->page || $this->page['enabled'] == 0) {
        return "Page not found.";
      }

      //Get the template
      $template = $this->engine->file->getTemplate($this->page['template']);

      return $this->engine->template->buildTemplate($template);
    }
  }
?>
