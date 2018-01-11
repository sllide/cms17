<?php
  class TemplateEngine {

    function __construct($tagEngine) {
      $this->tagEngine = $tagEngine;
    }

    function build($input) {
     while(true) {
       //get a tag
       preg_match("/@.+@/", $input, $match, PREG_OFFSET_CAPTURE);
       //if no match is found exit the while loop
       if(empty($match)) break;

       $offset = $match[0][1];
       $match = substr($match[0][0],1,strlen($match[0][0])-2);

       //get replacement
       $replacement = $this->tagEngine->getTagValue($match);
       if(!$replacement) {
         $payload = "Tag '" . $match . "' not found.";
       } else {
         if(is_string($replacement)) {
           $payload = $replacement;
         } else {
           $payload = $replacement();
         }
       }
       $input = substr_replace($input, $payload, $offset, strlen($match)+2);
     }

     return $input;
    }
  }
?>
