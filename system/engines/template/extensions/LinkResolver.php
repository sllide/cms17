<?php
  return new class {
    function build($tag, $who) {
      $tag = explode("/", $tag);
      $type = $tag[0];
      $file = $tag[1];
      return "/file/" . $who['type'] . "/" . $who['system'] . "/" . $type . "/" . $file;
    }
  }
?>
