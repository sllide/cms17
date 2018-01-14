<?php
  class WebsiteCore extends Core {

    private $content;

    function initialize() {
      $this->loadEnabledPlugins();
      $this->registerTags();
    }

    function loadEnabledPlugins() {
      $enabledPlugins = $this->engine->database->findInTable('plugins', 'enabled', 1);
      $this->engine->plugin->loadPlugins($enabledPlugins);
    }

    function registerTags() {
      //retrieve all plugins from the PluginEngine
      $plugins = $this->engine->plugin->getPlugins();

      //register system plugins first to ensure tags are free
      $this->engine->tag->registerSystemTag('content', [$this, 'content']);
      $this->engine->tag->registerSystemTag('navigation', [$this, 'navigation']);

      //get their tags and register them to the TemplateEngine
      foreach($plugins as $key => $plugin) {
        foreach($plugin['data']->getTags() as $tag) {
          $this->engine->tag->registerPluginTag($tag, $key);
        }
      }

      //register data tags last to override plugin tags
      foreach($this->engine->database->getAllFromTable('tags') as $tag) {
        $this->engine->tag->registerDataTag($tag['name'], $tag['value']);
      }


    }

    function content() {
      return $this->content;
    }

    function navigation() {
      $string = "";
      $pages = $this->engine->database->findInTable('pages', 'enabled', 1);
      $navigationEntry = $this->engine->database->findSingleInTable('templates', 'name', 'navigationLink');
      if(!$navigationEntry) {
        return "cant find navigation link template.";
      }

      foreach($pages as $page) {
        $key = '/page/'.$page['path'];
        $title = $page['name'];
        $string .= "<a href='$key'>$title</a>&nbsp;";
      }

      return $string;
    }

    function build() {
      //find out wich template to use via the path
      $route = $this->engine->routing->getRoute();
      $page = $this->engine->database->findSingleInTable('pages', 'path', $route['page']);
      //if no page is found and the page was not home try to fetch home

      if(!$page || $page['enabled'] == 0) {
        $indexID = $this->engine->database->findSingleInTable('templates', 'name', 'index');
        if($indexID) {
          $page = [
            'content' => "Cant find page " . $route['page'] . ".",
            'templateID' => $this->engine->database->findSingleInTable('templates', 'name', 'index')['rowid'],
          ];
        } else {
          $page = ['templateID' => -1];
        }
      }

      $this->content = $page['content'];
      $template = $this->engine->database->findSingleInTable('templates', 'ROWID', $page['templateID']);

      if($template==0) {
        return "Cant find fallback template!";
      }

      $template = $template['template'];
      return $this->engine->template->buildTemplate($template);
    }
  }
?>
