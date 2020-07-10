<?php

  switch($_SERVER['REQUEST_METHOD']){
    case 'GET' : 
      $users = $usersController->index();
      echo(json_encode($users));
      http_response_code(200);
      break;
    default :
      http_response_code(405);
  }
?>