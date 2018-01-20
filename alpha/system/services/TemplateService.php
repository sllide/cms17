<?php
  class TemplateService extends Service {
    function buildTemplate($template) {
      $engine = new StdClass();
      $engine->tag = $this->createCustomTagEngine($engine);
      $engine->tag->registerTags($this->engine->plugin->getPlugin()->tags);
      $engine->template = new TemplateEngine($engine);

      return $engine->template->buildTemplate($template);
    }

    function createCustomTagEngine() {
      return new class() {

        function getTagValue($tag) {
          if(isset($this->tags[$tag])) {
            return $this->tags[$tag]();
          }
        }

        function registerTag(Callable $function, $name) {
          $this->tags[$name] = $function;
        }

        function registerTags($tags) {
          $this->tags = [];
          foreach(get_class_methods($tags) as $row) {
            if($row != '__construct' && $row != 'registerServices') {
              $this->registerTag([$tags, $row], $row);
            }
          }
        }
      };
    }
  }
?>
