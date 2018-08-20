<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin, x-requested-with");

require 'config/dbclass.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();
$title=$_GET['title'];
$query = "SELECT Movie_Id, Title, Released_Year, Rating, Genres FROM movie_data WHERE Title='$title'";
$stmt = $connection->prepare($query);
$stmt->execute();
$count = $stmt->rowCount();
if($count > 0){
    $movies = array();
    $movies["body"] = array();
    $movies["count"] = $count;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $p  = array(
              "Movie_Id" => $Movie_Id,
              "Title" => $Title,
              "Released_Year" => $Released_Year,
              "Rating" => $Rating,
              "Genres" => $Genres
        );
        array_push($movies["body"], $p);
    }
    echo json_encode($movies);
}
else {

include('IMDbapi.php');
$imdb = new IMDbapi('YoGE1uCOQKgRD8AugFuc8SBFIWe29u');
$data = $imdb->title($title,'json');
$json_decode_data=json_decode($data);
if($json_decode_data->status=='true'){
  $query="INSERT INTO movie_data(Title,Released_Year,Rating,Genres) values('$json_decode_data->title','$json_decode_data->year','$json_decode_data->rated','$json_decode_data->genre')";
$stmt = $connection->prepare($query);
$stmt->execute();
}

echo $data;
    // echo json_encode(
    //     array("body" => array(), "count" => 0)
    // );
}
?>
