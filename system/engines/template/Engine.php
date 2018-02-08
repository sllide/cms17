<?php
  class Template implements Engine{

    static $tagList, $linkResolver;

    static function __init__(){
      self::$tagList = File::getExtension('TagList');
      self::$linkResolver = File::getExtension('LinkResolver');
    }

    static function addPersistentTag($name, callable $callback) {
      self::$tagList->addTag($name, self::$tagList::TAG, $callback);
    }

    static function addRequiredTag($name, callable $callback) {
      self::$tagList->addTag($name, self::$tagList::REQUIRED, $callback);
    }

    static function addTag($name, callable $callback) {
      self::$tagList->addTag($name, self::$tagList::SINGLE, $callback);
    }

    static function addDataTag($name, $data) {
      self::$tagList->addDataTag($name, $data);
    }

    static function buildTemplate($template) {
      $template = self::findAndReplaceTags($template);
      //$template = self::resolveLinks($template);
      return $template;
    }

    private static function findAndReplaceTags($template) {
      while(true) {
        preg_match("/@@[a-zA-Z]+@@/", $template, $match, PREG_OFFSET_CAPTURE);
        if(empty($match)) {
          break;
        }

        $tagLength = strlen($match[0][0]);
        $tagName = str_replace("@", "", $match[0][0]);
        $tagOffset = $match[0][1];

        $tag = self::$tagList->getTagContent($tagName);
        if(gettype($tag) == "Boolean" || gettype($tag) == "NULL") {
          self::$get('log')->notice("Cant resolve tag <b>$tagName</b>");
          $template = substr_replace($template, "", $tagOffset, $tagLength);
        } else {
          $template = substr_replace($template, $tag, $tagOffset, $tagLength);
        }
      }
      $missedTags = self::$tagList->getRequiredTags();

      if($missedTags) {
        $missedTagString = "";
        foreach($missedTags as $key) {
          $missedTagString .= "$key ";
        }
        Log::error("Not satisfied, missing required tags: <b>$missedTagString</b>");
      }
      return $template;
    }

    private static function resolveLinks($template) {
      while(true) {
        preg_match("/!![a-zA-Z]+\/[a-zA-Z.]+!!/", $template, $match, PREG_OFFSET_CAPTURE);
        if(empty($match)) {
          break;
        }

        $tagLength = strlen($match[0][0]);
        $tagName = str_replace("!", "", $match[0][0]);
        $tagOffset = $match[0][1];

        $link = self::$linkResolver->build($tagName, "x");

        $template = substr_replace($template, $link, $tagOffset, $tagLength);
      }
      return $template;
    }
  }
?>
