<?php 
class Movie extends Database {
  private $title;
  private $year;
  private $cover;

  function __construct($title,$year){
    $this->title = $title;
    $this->year = $year;
  }

  function getTitle(){
    return $this->title;
  }

  function getYear(){
    return $this->year;
  }

  function getCover(){
    return $this->cover;
  }

  public function jsonSerialize() {
    $vars = get_object_vars($this);

    return $vars;
  }

}

?>
