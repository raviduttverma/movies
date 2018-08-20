<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin, x-requested-with");

require 'config/dbclass.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();
$Year=$_GET['Year'];
$query = "SELECT Movie_Id, Title, Released_Year, Rating, Genres FROM movie_data WHERE Released_Year='$Year'";
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
    echo json_encode(
    array("body" => array(), "count" => 0)
    );
}
?>
