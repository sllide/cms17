<?php
  abstract class AbstractBase {
    public $get;
    public function __call($method, $args)
    {
      if (isset($this->$method)) {
        $func = $this->$method;
        return call_user_func_array($func, $args);
      }
      $this->get('log')->error("Function <b>$method</b> not found");
    }
  }
?>