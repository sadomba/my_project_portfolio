<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();
include("../includes/config.php");
include("../functions.php");


/*session passing*/
if (strlen($_SESSION['email']==0)){
    header('location:../index.php');

}else{ 
    #reading types for the components

    
     $email = $_SESSION['email'];
$sql3 ="SELECT type FROM config WHERE email='$email'";
$query3= $dbh -> prepare($sql3);
$query3-> execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
if($query3->rowCount() <= 0)
{  echo '<script>alert("configure your course first.")</script>';
    echo "<script>window.location.href ='configuration.php'</script>";}else{
   
 
 #reading courses for the selected user/lecturer
$sql1 ="SELECT courseid, c_name FROM course WHERE LecturerEmail='$email'";
$query1= $dbh -> prepare($sql1);
$query1-> execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);

    if(isset($_POST['choose']))
  {
   
 $cid=$_POST['cid'];
 $_SESSION['course'] = $cid;
 echo "<script>window.location.href ='editcomp.php'</script>";
  }
  
    } ?>

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

<body>

<div id="wrapper"  style="background-image: url(../assets/img/image3.jpeg);">                                                                                                                           
        <?php include("includes/leftbar.php");?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><label class="form-label">Course component creation</label>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
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
    <div class="row">
                        <div class="col">
                            <div class="container">
                                <div class="row">
                                    <div class="col">
                                        <section class="position-relative py-4 py-xl-5">
                                            <div class="container position-relative">
                                                <div class="row d-flex justify-content-center">
                                                    <div class="col-md-8 col-lg-10 col-xl-5 col-xxl-4" style="width: 700.5px;">
                                                        <div class="card mb-5">
                                                            <div class="card-body p-sm-5" style="background:blue;width: 600.5px;">
                                                                <h2 class="text-center mb-4 text-warning">Course selection</h2>
                                                                <form method="post">
                                                                    
                                                                    <div class="mb-3"><select class="form-control text-black form-control-user" name="cid" placeholder="Email" required>
                                                                    <option value="">--SELECT COURSE--</option>  
                                    <?php 
                            $cnt=1;
                            if($query1->rowCount() > 0)
                            {
                            foreach($results1 as $row1)
                            { 
                                      /*Filling data into cells*/
                                        ?> 

                                       <option value="<?php echo $row1-> courseid ;?>"><?php echo $row1-> courseid,' ~ ', $row1-> c_name;?></option>

                                       <?php $cnt=$cnt+1;}}  ?>
                                    </select>  </div>

                                    <div class="mb-3"><button class="btn btn-warning" type="submit" name="choose">choose</button></div>                     
                                                                
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
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

<?php } ?>