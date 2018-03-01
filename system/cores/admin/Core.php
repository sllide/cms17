<?php
  return new class implements Core {

    function init() {
      Profiler::start('core');
    }

    function registerTags() {
    }

    function build() {
      return Template::buildTemplate(File::getTemplate('index'));
    }
  }
?>
