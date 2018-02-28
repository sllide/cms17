<?php
  return new class implements Core{

    function init() {
      
    }

    function build() {
      $template = File::getTemplate('index');
      $template = Template::buildTemplate($template);
      return $template;
    }
  }
?>
