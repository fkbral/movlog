<?php 

Route::set('index.php',function(){
  IndexController::createView('Home');
});

Route::set('users',function(){
  $controller = new UserController();
  $GLOBALS['users'] = $controller->index();
  UserController::createView('Users');
});

Route::set('movies',function(){
  $controller = new MovieController();
  // $GLOBALS['users'] = $controller->index();
  MovieController::createView('Movies');
});

?>