<?php 

class Controller {

  public static function createView($viewName){
    require_once("./src/app/views/$viewName/index.php");
  }
}

?>