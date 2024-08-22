<?php 

// Start the session
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Get the email from the session
$email = $_SESSION['email'];
include("../includes/config.php");
include("../functions.php");

$email = $_SESSION['email'];
$sql3 ="SELECT type FROM config WHERE email='$email'";
$query3= $dbh -> prepare($sql3);
$query3-> execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
if($query3->rowCount() <= 0)
{  echo '<script>alert("configure your course first.")</script>';
    echo "<script>window.location.href ='configuration.php'</script>";}else{

$course = $_SESSION['course'];


if (isset($_POST['switch'])) {
    $var = $_POST['c_id'];
    $_SESSION['course']= $var;

}

$sql="SELECT c_name,courseid from  course WHERE LecturerEmail = '$email'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);


$sql5="SELECT percantage from  config WHERE email = '$email' and course = '$course'";
$query5 = $dbh -> prepare($sql5);
$query5->execute();
$results5=$query5->fetchColumn();


$sql4="SELECT title from marks WHERE course = '$course'";
$query4= $dbh -> prepare($sql4);
$query4->execute();
$results4=$query4->fetchAll(PDO::FETCH_OBJ);

$sql6="SELECT title from marks WHERE course = '$course'";
$query6= $dbh -> prepare($sql6);
$query6->execute();
$results6=$query4->fetchAll(PDO::FETCH_OBJ);

$myar = array();
$sumString = "";
$sumString1 = "";

$j = 0; foreach($results4 as $sad1) {

    $myar[$j] = $sad1->title;

    $j ++;
}
for ($k = 0; $k < count($myar);$k++){
  $sumString1 .= "`".$myar[$k]."`". ($k < count($myar) - 1 ? "," : "");
}

for ($i = 0; $i < count($myar); $i++) {
  $sumString .=  " `".$myar[$i] ."`". ($i < count($myar) - 1 ? "+" : "");
}


$sql2 = "SELECT `reg`,`surname`,$sumString1,($sumString) AS `total` FROM `$course`;";
$query2= $dbh -> prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);

$sql3="SELECT title from marks WHERE course = '$course'";
$query3= $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);

$sql6 = "SELECT `reg`,`surname`,$sumString1,($sumString) AS `OCW` FROM `$course`;";
    $query6 = $dbh->prepare($sql6);

    // Bind the course parameter using a placeholder for increased security
    //$query6->bindParam(1, $course, PDO::PARAM_STR); // Assuming $course is defined elsewhere

    // Execute the query
    $query6->execute();

    // Fetch all results as associative array for flexibility
    $results6 = $query6->fetchAll(PDO::FETCH_ASSOC);

    // Check if any results were found
    if (empty($results6)) {
        echo "No data found for course: $course";
        exit;
    }

    // Create the CSV content
    $csv_data = "";
    
    
    $header_row = array_keys($results6[0]); // Extract column names from first row
    $csv_data .= implode(",", $header_row) . "\n"; // Create CSV header

    foreach ($results6 as $row) {
        $csv_data .= implode(",", $row) . "\n"; // Append each row to CSV data
    }

    // Generate a temporary filename for the CSV file
    $temp_filename = tempnam(sys_get_temp_dir(), 'marks_data_') . '.csv';

    // Write the CSV data to a temporary file
    file_put_contents($temp_filename, $csv_data);

    $sql7 = "SELECT `reg` FROM `$course`;";
    $query7 = $dbh->prepare($sql7);

    // Bind the course parameter using a placeholder for increased security
    //$query6->bindParam(1, $course, PDO::PARAM_STR); // Assuming $course is defined elsewhere

    // Execute the query
    $query7->execute();

    // Fetch all results as associative array for flexibility
    $results7 = $query7->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>AIDE</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>
<body id="page-top">
<div id="wrapper">
        <?php include("includes/leftbar.php");?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                  <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><label class="form-label">GRADES FOR <?php echo ' '. $course ?></label>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item">
                              <form action="" method="post">
                                <div class="row mb-3" >
                               <div class="col mb-3"> <select class="form-control form-control-user" name="c_id" placeholder="Email" onchange="doReload(this.value);">
                                    <?php 
                            $cnt=1;
                            if($query->rowCount() > 0)
                            {
                            foreach($results as $row)
                            { 
                                      /*Filling data into cells*/
                                        ?> 

                                       <option value="<?php echo $row-> courseid ;?>"><?php echo $row-> courseid,' ~ ', $row-> c_name;?></option>

                                       <?php $cnt=$cnt+1;}}  ?>
                                    </select>  
                                   </div><div class="col mb-4"><input type="submit" value="switch" class="btn btn-facebook" name="switch"></div>
 
                                </div>
                                </form>
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


            <form method="post" action="table.php" class="user">
            <div class="modal-content">
                
               
                <div class="content">

                    
                  
                <div class="card shadow">
                        <div class="card-header py-3" style="background: blue;">
                            <p class="text-primary m-0 text-warning  fw-bold">RECORDED COURSE WORK</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-nowrap">
                                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable">
                                    <input class="btn btn-facebook" type="button" value="save to local" onclick="exportToExcel('dataTable')" />
                                    <form action="" method="post">
                                    <input class="btn btn-facebook" type="submit" value="email to students" name="email"/>
                                    <input class="btn btn-facebook" type="submit" value="send to heims" name="send" />
                                    </form>
                                    </div>

                                            
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                
                                <table class="table table-striped my-0" id="dataTable">
                                    <thead >
                                        <tr>
                                            <th>surname</th>
                                            <th>Reg</th>
                                        <?php
                                                                                        $cnt3=1;
                                                                    if($query3->rowCount() > 0)
                                                                    {
                                                                    foreach($results3 as $row3)
                                                                    { 
                                                                      ?>   
                                            <th><?php echo $row3 -> title ,''?></th>
                                            <?php  $cnt3=$cnt3+1;}}?>
                                            <th>TCW</th>
                                            <th>OCW</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                       
                                    
                                        <?php
                                                                                        $cnt2=2;
                                                                    if($query2->rowCount() > 0)
                                                                    {
                                                                    foreach($results2 as $row2)
                                                                    { 
                                       ?>
                                        <tr>
                                            
                                            <td><?php echo $row2 -> surname?></td>
                                            <td><?php echo $row2 -> reg?></td>
                                            <?php $i = 0; foreach($results3 as $sad) {
                                            $col = array();
                                            $col[$i] = $sad->title;
                                           
                                        
                                            ?>
                                            <td><?php echo (($row2->{$col[$i]})*100)/25;?></td>
                                           
                                            <?php $i = $i + 1; } ?>
                                            <?php $total =$row2->total; $csw =round((($total*4)/count($results3)),1); ?>
                                            
                                            <td><?php echo $csw?></td>
                                            <td><?php echo round((($results5/100) * $csw),1)?></td>


                                            
                                        </tr>
                                       
                                        <?php  $cnt2=$cnt2+2;}}?>
                                        
                                       
                                    </tbody>
                                    <form method="post" action="table.php" enctype="multipart/form-data">
 
  
  <br>
  
  


</form>
                                   
                                </table>
                            </div>
                        </div>


                </div>
               
            </div>
            </form>
      
    
           
        </div>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>

<script src="exportToExcel.js" defer></script>

</body>
</html>

<?php


if(isset($_POST['email']))
{
 
// Base files 
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
// create object of PHPMailer class with boolean parameter which sets/unsets exception.
$mail = new PHPMailer(true);   


try {
    $mail->isSMTP(); // using SMTP protocol                                     
    $mail->Host = 'smtp.gmail.com'; // SMTP host as gmail 
    $mail->SMTPAuth = true;  // enable smtp authentication                             
    $mail->Username = 'sadombamarvelous8@gmail.com';  // sender gmail host              
    $mail->Password = 'hwnq auql dkxp zoqg'; // sender gmail host password                          
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // for encrypted connection                           
    $mail->Port = 587;
  



foreach($results7 as $smail){
    $mail->setFrom('sadombamarvelous8@gmail.com', "THE AIDE TEAM"); // sender's email and name
    
    $mail->addAddress($smail->reg.'@hit.ac.zw', "student");  // receiver's email and name

    $mail->Subject = $course;
    $mail->Body = 'Find the attached coursework';
    $mail->addAttachment($temp_filename, $course.'CSW.csv');
 }

if (!$mail->send()) {
    echo "Error sending email: " . $mail->ErrorInfo;
} else {
   echo '<script>alert("send succesfull")</script>';
}

   
} catch (Exception $e) { // handle error.
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}
}


if (isset($_POST['send'])){
    echo '<script>alert("you are now being redirected to API page")</script>';
    echo "<script>window.location.href = 'askapi.php'</script>";
}
}
    
// ?>
                       