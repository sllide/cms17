<?php
class ViewLoggerPlugin extends Plugin {

  function getDataStructure() {
    return [
      "visits" => [
        "page" => "TEXT NOT NULL",
        "date" => "DATETIME NOT NULL",
        "visits" => "INT NOT NULL",
      ],
    ];
  }

  function setup($db) {

  }

  function handleLogic($db) {

  }

  function handlePanelLogic($db) {

  }

  function registerTags($tagEngine) {
  }

  function registerPanelTags($tagEngine) {

  }

  function getPanelView() {
    return file_get_contents("../plugins/viewlogger/panel.html");
  }

  function getMetaData() {
    return [
      'name' => 'View logger',
      'description' => 'Become a wise man with this knowledge filled plugin',
    ];
  }
}

return new ViewLoggerPlugin();
?>
