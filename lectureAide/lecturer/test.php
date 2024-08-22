<?php

session_start();
include("../includes/config.php");
include("../functions.php");

//$email = $_SESSION['email'];



$course = $_SESSION['course'];
$url = $_SESSION['url'];



  $sql4 = "SELECT title FROM marks WHERE course = '$course'";
  $query4 = $dbh->prepare($sql4);
  $query4->execute();
  $results4 = $query4->fetchAll(PDO::FETCH_OBJ);

  $myar = array();
  $sumString = "";
  $sumString1 = "";

  $j = 0;
  foreach ($results4 as $sad1) {
    $myar[$j] = $sad1->title;
    $j++;
  }

  for ($i = 0; $i < count($myar); $i++) {
    $sumString .= " `" . $myar[$i] . "`" . ($i < count($myar) - 1 ? "+" : "");
  }

  $sql2 = "SELECT reg, $sumString AS `total` FROM `$course`";
  $query2 = $dbh->prepare($sql2);
  $query2->execute();
  $results2 = $query2->fetchAll(PDO::FETCH_ASSOC);

  $results2['COURSE'] = $course;
  $results2['url'] = $url;

  $json = json_encode($results2);

  // Set content type header for JSON output
  header("Content-Type: application/json");
  echo $json;

 ?>