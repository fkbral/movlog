<?php

class User extends Database {
  private $name;

  function __construct($name) {
    $this->name = $name;
  }

  function get_name() {
    return $this->name;
  }

  public function jsonSerialize() {
    $vars = get_object_vars($this);

    return $vars;
  }

}
?>