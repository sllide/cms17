<?php
  class TemplateEngine extends Engine {
    function buildTemplate($template) {
      //keep running until no tags can be found
      while(true) {
        //get a tag
        preg_match("/@[a-zA-Z]+@/", $template, $match, PREG_OFFSET_CAPTURE);
        //if no match is found exit the while loop
        if(empty($match)) break;

        //extract tag value and position
        $tagName = substr($match[0][0], 1, strlen($match[0][0]) - 2);
        $tagOffset = $match[0][1];
        $tagLength = strlen($tagName)+2;

        //get the tag replacement
        $tagValue = $this->engine->tag->getTagValue($tagName);

        //if tag value equals false and it isnt a string report missing tag.
        //Note: an empty string is equal to false, hence the string check
        if($tagValue == false && !is_string($tagValue)) {
          $tagValue = "Tag $tagName not found.";
        }

        //replace tag with its value
        $template = substr_replace($template, $tagValue, $tagOffset, $tagLength);
      }

      return $template;
    }
  }
?>
