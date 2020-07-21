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
      case 'PUT':
        $this->update();
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
    if(isset($_POST['movie'])){
      $movie = (array) json_decode($_POST['movie']);

      $movieExists = Movie::query("SELECT * FROM movies WHERE `id` = '$movie[imdbID]'");

      if ($movieExists) {
        echo json_encode(['message' => 'movie already exists']);
        die();
      }

      $movieFormatted =  array('id' => $movie['imdbID'], 'title' => $movie['Title'],
       'year' => $movie['Year'], 'type' => $movie['Type'], 
       'poster' => $movie['Poster'], 'status' => $movie['status']);

      $query = "INSERT INTO `movies` (`id`, `title`, `year`, `type`, `poster`, `status`) 
      VALUES (:id, :title, :year, :type, :poster, :status);";

      Movie::query($query, $movieFormatted);

      echo json_encode($movieFormatted);
    }
    $this->update();
    die();
  }

  function update() {
    if(!isset($_GET['type'])) return;

    $movieId = $_GET['movieId'];
    $type = $_GET['type'];
    
    switch($type){
      case 'details':
        $payload = (array) json_decode($_POST['payload']);

        $payloadFormatted = array(
        'runtime' => $payload['Runtime'],
        'genre' => $payload['Genre'],
        'rated' => $payload['Rated'],
        'released' => $payload['Released'],
        'actors' => $payload['Actors'],
        'director' => $payload['Director'],
        'writer' => $payload['Writer'],
        'plot' => $payload['Plot'],
        'awards' => $payload['Awards'],
        'imdb_rating' => $payload['imdbRating'],
        'box_office' => isset($payload['BoxOffice']) ? $payload['BoxOffice'] : "N/A",
        'total_seasons' => isset($payload['totalSeasons']) ? $payload['totalSeasons'] : "N/A",
        );
        
        $query = "UPDATE `movies`
          SET `runtime` = :runtime,
          `genre` = :genre,
          `rated` = :rated,
          `released` = :released,
          `actors` = :actors,
          `director` = :director,
          `writer` = :writer,
          `plot` = :plot,
          `awards` = :awards,
          `imdb_rating` = :imdb_rating,
          `box_office` = :box_office,
          `total_seasons` = :total_seasons,
          `has_details` = 1
          WHERE `id` = '$movieId';";

          Movie::query($query, $payloadFormatted);
          echo json_encode($payloadFormatted);
      break;
      case 'status':
        $status = $_GET['status'];

        $query = "UPDATE `movies`
          SET `status` = '$status'
          WHERE `id` = '$movieId';";

          Movie::query($query);
          echo json_encode(["message"=>"movie status updated"]);
      break;
    }
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