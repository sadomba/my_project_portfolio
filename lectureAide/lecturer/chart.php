<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include("../includes/config.php");
include("../functions.php");

$email = $_SESSION['email'];




$idarray = array();
$string2 = "";

$sql3="SELECT courseid from course WHERE LecturerEmail = '$email'";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);

$v = 0; foreach($results3 as $sad1) {

    $idarray[$v] = $sad1->courseid;

    $v ++;
}

$mi = count($idarray);
$sql5="SELECT courseid, year from course WHERE LecturerEmail = '$email'";
$query5 = $dbh -> prepare($sql5);
$query5->execute();
$results5=$query5->fetchAll(PDO::FETCH_ASSOC);

foreach ($results5 as $row5) {
  $labels1[] = $row5['courseid'].'~'.$row5['year'];


}






$mymarks = array();

for ($m = 0; $m < count($idarray); $m++) {

  $sql4 = "SELECT title FROM marks WHERE course = '$idarray[$m]'";
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

  $sql2 = "SELECT SUM($sumString) AS `total`, COUNT($sumString) as `cnt` FROM `$idarray[$m]`;";
  $query2 = $dbh->prepare($sql2);
  $query2->execute();
  $results2 = $query2->fetchAll(PDO::FETCH_OBJ);

  $labels = array();
  $data2 = array();

  foreach ($results2 as $row2) {
    // Append the total to the $mymarks array
$div = $mi*$row2->cnt ;
if ($div == 0){
  echo '<script>alert("there is a component which needs to be recorded")</script>';
  echo "<script>window.location.href ='dashboard.php'</script>";
}

    $mymarks[] = ($row2->total/($div))*4; // Use array push or similar for clarity
  }
}


$sql="SELECT courseid,year from course WHERE LecturerEmail = '$email'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

 


 
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Aide</title>
  <script src="chart.js"></script>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
  
</head>

<body style="background: url(&quot;../assets/img/hit3.jpg&quot;) center / cover, var(--bs-emphasis-color);">

<div id="wrapper"  style="background-image: url(../assets/img/csw.xls);">                                                                                                                           
        <?php include("includes/leftbar.php");?>
        <div class="d-flex flex-column" id="content-wrapper">
            
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><label class="form-label">STATISTICS </label>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ol class="breadcrumb float-right px-3 mt-2">  <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Statistics</li>
    </ol>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item">
                                <div class="container">
                               
                                </div>
                            </li>
                           
                            <div class="d-none d-sm-block topbar-divider"></div>
                            <li class="nav-item dropdown no-arrow">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-cog"></i><span class="d-none d-lg-inline me-2 text-gray-600 small">option</span></a>
                                    <div class="dropdown-menu shadow dropdown-menu-end animated--grow-in"><a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Profile</a><a class="dropdown-item" href="#"><i class="fas fa-cogs fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Settings</a><a class="dropdown-item" href="#"><i class="fas fa-list fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Activity log</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" href="../logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw me-2 text-gray-400"></i>&nbsp;Logout</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>






                <div class="container">
                <div class="container py-4 py-xl-5">

                <div>






  <canvas id="myChart"></canvas>

                </div></div></div>

        </div>
</div>




  <script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'bar', // Change to 'line' or other chart type as needed
    data: {
      labels: <?php echo json_encode($labels1); ?>,
      datasets: [{
        label: 'Average',
        backgroundColor: '#4e73df',
        borderColor: 'rgba(255, 99, 132, 1)',
        data: <?php echo json_encode($mymarks); ?>,
      }
      ]
    }
    // Add other chart configuration options as needed
  });
  </script>
 <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    
    <script src="assets/js/theme.js"></script>
</body>
</html>
