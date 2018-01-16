<?php
  class ServiceEngine extends Engine {

    public function getServices($services, $key) {
      $this->serviceList = new stdClass();
      //if plugin isnt intialized yet do so
      foreach($services as $service) {
          if(!isset($serviceArray[$service])) {
            $this->loadService($service, $key);
          }
      }
      return $this->serviceList;
    }

    private function loadService($service, $key) {
      switch($service) {
        case 'template':
          $this->serviceList->template = new TemplateService($this->engine, $key);
          break;
        case 'file':
            $this->serviceList->file = new FileService($this->engine, $key);
            break;
        case 'database':
            $this->serviceList->database = new DatabaseService($this->engine, $key);
            $this->serviceList->database->initialize();
            break;
      }
    }
  }
?>
