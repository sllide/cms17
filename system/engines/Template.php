<?php
  class Template implements Engine{

    static $tags = Array();

    static function __init__(){
    }

    static function addTags($object) {
      self::$tags[] = $object;
    }

    static function buildTemplateVars($template) {
      while(true) {
        preg_match("/!![0-9]+!!/", $template, $match, PREG_OFFSET_CAPTURE);
        if(empty($match)) {
          break;
        }

        $tagLength = strlen($match[0][0]);
        $tagName = str_replace("!", "", $match[0][0]);
        $tagOffset = $match[0][1];

        $tagNumber = intval($tagName);
        $content = "";
        if($tagNumber>0 && func_num_args()>=$tagNumber) {
          $content = func_get_args()[$tagNumber];
        }
        
        $template = substr_replace($template, $content, $tagOffset, $tagLength);
      }

      return $template;
    }

    static function buildTemplate($template) {
      return self::findAndReplaceTags($template);
    }

    private static function resolveTag($name) {
      foreach(self::$tags as $object) {
        $methods = get_class_methods($object);
        if(in_array($name, $methods)) {
          return [$object, $name]();
        }
      }
      return '';
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

        $content = self::resolveTag($tagName);
        
        $template = substr_replace($template, $content, $tagOffset, $tagLength);
      }
      return $template;
    }
  }
?>
