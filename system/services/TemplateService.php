<?php
  class TemplateService extends Service {
    function buildTemplate() {
      $engine = new StdClass();
      $engine->tag = $this->createCustomTagEngine($engine);
      $engine->tag->registerTags($this->engine->plugin->getTags());
      $engine->template = new TemplateEngine($engine);

      return $engine->template->buildTemplate("@welcomeMessage@");
    }

    function createCustomTagEngine() {

      return new class() {

        function getTagValue($tag) {
          echo "getting fake engine tag $tag<br />";
          if(isset($this->tags[$tag])) {
            return $this->tags[$tag];
          }
          echo "not fond $tag<br />";
        }

        function registerTags($tags) {
          $this->tags = [];
          foreach(get_class_methods($tags) as $row) {
            echo "checking $row";
            if($row != '__construct' && $row != 'registerServices') {
              echo "settings $row";
              $this->tags[$row] = [$tags, $row]();
            }
          }
        }
      };
    }
  }
?>
