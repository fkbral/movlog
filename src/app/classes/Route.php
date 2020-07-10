<?php
class Route {

  public static $validRoutes = array();

  public function getValidRoutes(){
    return self::$validRoutes;
  }

  public static function set($route, $render) {
    array_push(self::$validRoutes, $route);
    if($_GET['url'] === $route){
      $render->__invoke();
    }
  }
}
?>