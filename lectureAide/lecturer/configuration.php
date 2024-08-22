<?php
session_start();
include("../includes/config.php");
include("../functions.php");
$exam= 100 ;
$csw = 25;
/*session passing*/
if (strlen($_SESSION['email']==0)){
    header('location:../index.php');

}else{   
    $email = $_SESSION['email'];
    $course = $_SESSION['course'];
 
 #reading courses for the selected user/lecturer
$sql3 = "SELECT SUM(`percantage`) as `total` FROM `config` WHERE `email` = '$email' and course = '$course';";
$query3= $dbh -> prepare($sql3);
$query3-> execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);

$sql2 = "SELECT `percantage`,`type` FROM `config` WHERE `email` = '$email' and `course` = '$course';";
$query2= $dbh -> prepare($sql2);
$query2-> execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);


$sql1 ="SELECT courseid, c_name FROM course WHERE LecturerEmail='$email'";
$query1= $dbh -> prepare($sql1);
$query1-> execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);

    if(isset($_POST['save']))
  {
   
 $type=$_POST['type'];
 $percent=$_POST['percent'];
 $c_id = $course;
 


$sql="insert into config(email,course,type,percantage)values(:email,:c_id,:type,:percent)";
$query=$dbh->prepare($sql);
$query->bindParam(':email',$email,PDO::PARAM_STR);
$query->bindParam(':c_id',$c_id,PDO::PARAM_STR);
$query->bindParam(':type',$type,PDO::PARAM_STR);
$query->bindParam(':percent',$percent,PDO::PARAM_STR);

 $query->execute();
   $LastInsertId=$dbh->lastInsertId();
   if ($LastInsertId>0) {


   $sql2 = "UPDATE `course` SET `configured` = '0' WHERE `course`.`courseid` = 'IIT2201';";
   $query2=$dbh->prepare($sql2);
    $query2->execute();
   
    
             echo '<script>alert("added succesfull")</script>';
            
    
echo "<script>window.location.href ='configuration.php'</script>";
  }
  else
    {
         echo '<script>alert("Something Went Wrong. Please try again")</script>';
        }} ?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>aide</title>
    

    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
  
   
</head>

<body style="background: url(&quot;../assets/img/hit3.jpg&quot;) center / cover, var(--bs-link-hover-color);">

<div id="wrapper"  style="background-image: url(../assets/img/image3.jpeg);">                                                                                                                           
        <?php include("includes/leftbar.php");?>
        <div class="d-flex flex-column" id="content-wrapper">
            
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><label class="form-label">configurations for course : </label> <H2 ><?php  echo $course;?></H2>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ol class="breadcrumb float-right px-3 mt-2">  <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Configurations</li>
    </ol>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item">
                                <div class="container" >
                               
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
                                <div class="row mb-3">
                                    <div class="col mb-3">
                                        
                                            <div class="container position-relative">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-8 " >
                                                        <div class="card mb-5">
                                                            <div class="card-body " style="background:blue;width:400px;">
                                                                <h2 class="text-center mb-4 text-warning">Course configuration</h2>
                                                                <hr>
                                                                <form method="post">
                                                                  
                                                                   
                                     <div class="mb-3"><select name="type" id="" class="form-control text-black form-control-user" required>
                                                                            <option value="">--SELECT TYPE--</option>
                                                                            <option value="theory">theory</option>
                                                                            <option value="practical">practical</option>
                                                                            <option value="presentation">presentation</option>
                                                                            <option value="exam">examination</option>
                                                                            <option value="test">test</option>
                                                                            <option value="assignment">assignment</option>
                                                                            
                                                                    </select></div>
                                                                    
                                                                    <div class="mb-3"><input class="form-control text-black form-control-user" required type="number"  name="percent" placeholder="Coursework type Percentage"></div>
                                                                   
                                    <div class="mb-3"><button class="btn btn-warning" type="submit" name="save">Create</button></div>                     
                                                                
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                    </div>
                                    <div class="col mb-3">
<div class="container ">


            
<div class="row" >

                <div class="card shadow border-start-warning py-2" style="background:blue;">
                    <div class="card-body" >
                        <div class="row align-items-center no-gutters">
                            <div class="col me-2">
                               <div class="text-light fw-bold h3 mb-0"><span>Saved configurations<i class="fas fa-layer-group text-gray-300"></i></span> </div>
                               <hr>
                               <div class="text-light fw-bold h3 mb-0"><span><?php $point = '' ; foreach($results3 as $row3){ $point = $row3->total; echo' total CSW ['.$point.']';};?><i class="fas fa-layer-group text-gray-300"></i></span> </div>
                               <div class="text-uppercase text-warning fw-bold text-xl mb-1"><span><?php echo  'Exam : '. $exam - $point . '% ','->',($exam-$point)/100;?></span></div>
                                <hr><?php 
                              
                               foreach($results2 as $row2){

                               
                               ?>
                               
                               <?php $point = $row2->percantage; ?>
                               
                                <div class="text-uppercase text-warning fw-bold text-xl mb-1"><span><?php echo $row2->type. ' : '.$point,'% ','->', $point/100;?></span></div>
                               
                            
                               
                                <?php }?>
                                <form method="post">
                                <div class="mb-3"><button class="btn btn-warning" type="submit" name="manage">Manage Configurations</button></div>                     
                                <div class="mb-3"><button class="btn btn-warning" type="submit" name="change">Switch Course</button></div>                     
                               </form>
                            </div>
                           
                           
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

                                    </div>
                                </div>
                            </div>
                        
                    </div>

    
            
        </div>


<script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>
</html>

<?php 
 if(isset($_POST['manage']))
    {echo "<script>window.location.href ='new.php'</script>";}
 if(isset($_POST['change']))
    {echo "<script>window.location.href ='ask1 (copy 1).php'</script>";}
 } ?>