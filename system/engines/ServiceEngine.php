<?php
  class ServiceEngine extends Engine {

    public function getServices($services) {
      $this->serviceList = new stdClass();
      //if plugin isnt intialized yet do so
      foreach($services as $service) {
          if(!isset($serviceArray[$service])) {
            $this->loadService($service);
          }
      }
      return $this->serviceList;
    }

    private function loadService($key) {
      switch($key) {
        case 'template':
          $this->serviceList->template = new TemplateService($this->engine, 'test');
          break;
        case 'file':
          $this->serviceList->file = new FileService($this->engine, 'test');
          break;
      }
    }
  }
?>
