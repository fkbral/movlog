<?php
include './src/app/models/Movie.php';

class MovieController extends Controller {
  function __construct(){
   switch($_SERVER['REQUEST_METHOD']){
      case 'GET':
        $this->index();
        break;
      case 'POST':
        $this->store();
        break;
      case 'DELETE':
        $this->delete();
        break;
    }
  }
  function index(){
    $movies = Movie::query("SELECT * FROM movies");
    $GLOBALS['movies'] = $movies;
    return $movies;
  }

  function store() {
    if($_POST['movie']){
      $movie = (array) json_decode($_POST['movie']);

      $movieFormatted =  array('id' => $movie['imdbID'], 'title' => $movie['Title'],
       'year' => $movie['Year'], 'type' => $movie['Type'], 'poster' => $movie['Poster']);

      $query = "INSERT INTO `movies` (`id`, `title`, `year`, `type`, `poster`) 
      VALUES (:id, :title, :year, :type, :poster);";

      Movie::query($query, $movieFormatted);

      echo json_encode($movieFormatted);
    }
    die();
  }

  function delete(){
    $movieId = $_GET['movieId'];

    $query = "DELETE FROM `movies` WHERE `id` = '$movieId'";

    Movie::query($query);

    echo(json_encode(['message'=>'movie deleted']));
    die();
  }
}
?>