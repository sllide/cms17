<?php
  return new class implements Plug {
    public function init() {
    }

    public function install() {
      Database::insertStructIntoTable('guestbook_messages', ['name'=>'Bart','message'=>'Dicks']);
      Database::insertStructIntoTable('guestbook_messages', ['name'=>'Fart','message'=>'Dicks2']);
    }

    public function build() {
      $template = File::getTemplate('index');
      return Template::buildTemplate($template);
    }
  }
?>
