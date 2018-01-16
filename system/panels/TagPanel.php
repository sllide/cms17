<?php
  class TagPanel extends ConfigPanel {

    function build() {
      $action = $this->engine->routing->getAction();
      if($action == "new") {
        $this->localEngine = $this->engine->service->getLocalTemplateEngine();
        $template = $this->engine->file->getTemplate("admin/tags/new_tag");
        return $this->localEngine->template->buildTemplate($template);
      }
      $this->localEngine = $this->engine->service->getLocalTemplateEngine();
      $this->localEngine->tag->registerFunctionTag('tagRows', [$this, 'getRows']);
      $template = $this->engine->file->getTemplate("admin/tags/panel");
      return $this->localEngine->template->buildTemplate($template);
    }

    function getRows() {
      $layout = "";
      $tags = $this->engine->database->getAllTags();

      foreach($tags as $tag) {
        $this->localEngine->tag->registerDataTag('tagKey', $tag['name']);
        $this->localEngine->tag->registerDataTag('tagData', $tag['value']);
        $template = $this->engine->file->getTemplate("admin/tags/tag_row");
        $layout .= $this->localEngine->template->buildTemplate($template);
      }

      return $layout;
    }

    function handleRequest($post) {
      if(!isset($post['action'])) return false;
      if($post['action'] == "new" && isset($post['tagName']) && isset($post['tagValue'])) {
        $this->engine->database->insertIntoTable('tags', [$post['tagName'], $post['tagValue']]);
      }
    }
  }
?>
