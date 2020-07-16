<?php 

$GLOBALS['pageExists'] = false;

Route::set('',function(){
  IndexController::createView('Home');
});

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
  MovieController::createView('Movies');
});

Route::set('404',function(){
  IndexController::createView('404');
});

if(!$GLOBALS['pageExists']) {
  header("Location: 404");
}

?>