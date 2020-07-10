<?php

include './src/app/models/User.php';

// header('Content-Type: application/json; charset=utf-8');

class UserController extends Controller{

  function index(){
    $users = User::query("SELECT * FROM users");

    return $users;
  }
}

?>