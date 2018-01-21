<?php
  return new class extends AbstractEngine {

    function init(){
      $this->tagList = $this->loader->get('file')->getExtention('TagList');
      $this->tagList->log = $this->loader->get('log');
      $this->linkResolver = $this->loader->get('file')->getExtention('LinkResolver');
       
    }

    function addTag($name, callable $callback) {
      $this->tagList->addTag($name, $this->tagList::TAG, $callback);
    }

    function addRequiredTag($name, callable $callback) {
      $this->tagList->addTag($name, $this->tagList::REQUIRED, $callback);
    }

    function addSingleUseTag($name, callable $callback) {
      $this->tagList->addTag($name, $this->tagList::SINGLE, $callback);
    }

    function addDataTag($name, $data) {
      $this->tagList->addDataTag($name, $data);
    }

    function buildTemplate($template) {
      $template = $this->findAndReplaceQueue($template);
      $template = $this->resolveLinks($template);
      return $template;
    }

    private function findAndReplaceQueue($template) {
      while(true) {
        preg_match("/@@[a-zA-Z]+@@/", $template, $match, PREG_OFFSET_CAPTURE);
        if(empty($match)) {
          break;
        }

        $tagLength = strlen($match[0][0]);
        $tagName = str_replace("@", "", $match[0][0]);
        $tagOffset = $match[0][1];

        $tag = $this->tagList->getTagContent($tagName);
        if(gettype($tag) != "string") {
          $this->loader->get('log')->notice("Cant resolve tag <b>$tagName</b>");
          $template = substr_replace($template, "", $tagOffset, $tagLength);
        } else {
          $template = substr_replace($template, $tag, $tagOffset, $tagLength);
        }
      }
      $missedTags = $this->tagList->getRequiredTags();

      if($missedTags) {
        $missedTagString = "";
        foreach($missedTags as $key) {
          $missedTagString .= "$key ";
        }
        $this->loader->get('log')->error("Not satisfied, missing required tags: <b>$missedTagString</b>");
      }
      return $template;
    }

    private function resolveLinks($template) {
      while(true) {
        preg_match("/!![a-zA-Z]+\/[a-zA-Z.]+!!/", $template, $match, PREG_OFFSET_CAPTURE);
        if(empty($match)) {
          break;
        }

        $tagLength = strlen($match[0][0]);
        $tagName = str_replace("!", "", $match[0][0]);
        $tagOffset = $match[0][1];

        $link = $this->linkResolver->build($tagName, $this->who);

        $template = substr_replace($template, $link, $tagOffset, $tagLength);
      }
      return $template;
    }
  }
?>
