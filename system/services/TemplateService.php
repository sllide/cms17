<?php
  class TemplateService extends Service {
    function buildTemplate() {
      $engine = new StdClass();
      $engine->tag = $this->createCustomTagEngine($engine);
      $engine->tag->registerTags($this->engine->plugin->getPlugin()->tags);
      $engine->template = new TemplateEngine($engine);

      return $engine->template->buildTemplate("@welcomeMessage@");
    }

    function createCustomTagEngine() {

      return new class() {

        function getTagValue($tag) {
          echo "getting fake engine tag $tag<br />";
          if(isset($this->tags[$tag])) {
            echo "got value with type: " . gettype($this->tags[$tag]) . "<br />";
            return $this->tags[$tag]();
          }
          echo "not fond $tag<br />";
        }

        function registerTag(Callable $function, $name) {
          $this->tags[$name] = $function;
        }

        function registerTags($tags) {
          $this->tags = [];
          foreach(get_class_methods($tags) as $row) {
            echo "checking $row<br />";
            if($row != '__construct' && $row != 'registerServices') {
              echo "setting $row<br />";
              $this->registerTag([$tags, $row], $row);
            }
          }
        }
      };
    }
  }
?>
