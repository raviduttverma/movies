<?php
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods:GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Authorization, Content-Type,Accept, Origin, x-requested-with");

require 'config/dbclass.php';

$dbclass = new DBClass();
$connection = $dbclass->getConnection();
$GenesValue=null;
$Ratings=null;
$id=null;
if (isset($_POST['Genres'])) {
  $GenesValue=$_POST['Genres'];
}
if (isset($_POST['Ratings'])) {
  $Ratings=$_POST['Ratings'];
}
if (isset($_POST['id'])) {
  $id=$_POST['id'];
}

if($GenesValue!=null && $Ratings!=null && $id!=null){
  $query = "UPDATE movie_data SET Rating='$Ratings', Genres=$GenesValue WHERE Movie_Id=$id";
  $stmt = $connection->prepare($query);
  $stmt->execute();
  echo "Genres and Ratings Updated";
}else if($GenesValue!=null && $Ratings==null && $id!=null){
  $query = "UPDATE movie_data SET Genres=$GenesValue WHERE Movie_Id=$id";
  $stmt = $connection->prepare($query);
  $stmt->execute();
  echo "Genres Updated";
}else if($GenesValue==null && $Ratings!=null && $id!=null){
  $query = "UPDATE movie_data SET Rating='$Ratings' WHERE Movie_Id=$id";
  $stmt = $connection->prepare($query);
  $stmt->execute();
  echo "Ratings Updated";
}else{
  echo "Please provide value to update";
}
?>
