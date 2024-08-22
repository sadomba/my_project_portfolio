<?php


session_start();
include("../includes/config.php");
include("../functions.php");


/*including connection file*/
if (strlen($_SESSION['email']==0)){
    header('location:../index.php');

}else{

    
$email = $_SESSION['email'];
$name = getname($dbh,$email);
$course = getcourse($dbh,$email);

$courseid = getcourse($dbh,$email);
$_SESSION['course'] = $courseid;



if(isset($_POST['course']))
{
    $pass = $_POST['course'];
    $_SESSION['course'] = $pass; 
    echo "<script>window.location.href ='comp.php'</script>";
    
}

$sql="SELECT c_name,courseid,Part,type,year from  course WHERE LecturerEmail = '$email'";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);

?>
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
 
<body style="background: url(&quot;../assets/img/hit3.png&quot;) center / cover, var(--bs-emphasis-color);">

<div id="wrapper"  style="background-image: url(../assets/img/image3.jpeg);">                                                                                                                           
        <?php include("includes/leftbar.php");?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><label class="form-label">COURSE</label>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ol class="breadcrumb float-right px-3 mt-2">  <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
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
        <div class="container py-4 py-xl-5">


            
            <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3" >
            <?php 
                            $cnt=1;
                            if($query->rowCount() > 0)
                            {
                            foreach($results as $row)
                            { 
                                      /*Filling data into cells*/
                                        ?> 
                            <div class="card shadow border-start-warning py-2" style="background:blue;">
                                <div class="card-body" >
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                           <div class="text-light fw-bold h3 mb-0"><span><?php  echo $row->courseid,'  ',$row->type ;?><i class="fas fa-layer-group text-gray-300"></i></span> </div>
                                           <hr>
                                            <div class="text-uppercase text-warning fw-bold text-xl mb-1"><span><?php  echo  $row->c_name;?></span></div>
                                            
                                            <div class="text-light fw-bold h5 mb-0"><span><?php echo  'PART ',$row->Part;?></span></div>
                                            <div class="text-light fw-bold h5 mb-0"><span><?php echo  $row->year;?></span></div>
                                            <?php $cid = $row->courseid; $coursnum = get_component_count($dbh, $email,$cid ); ?>
                                            <div class="text-warning fw-bold h5 mb-0"><span><?php echo  'CREATED COMPONENTS : ', $coursnum?></span></div>
                                           
                                        </div>
                                        <hr>
                                        <form method="post"> <div class="row mb-3"><div class="col-sm-6 mb-3 mb-sm-0 "><button class="text-light btn btn-warning" type="submit" value="<?php echo $row->courseid;?>" name="course" style="background: var(--bs-focus-ring-color);">Open&nbsp;<i class="fas fa-edit"></i>&nbsp;</button></div><div class="col-sm-6 mb-3 mb-sm-0"><a href="askcedit.php"><p class="text-light">create component</p> </a></div></div> </form>
                                       
                                    </div>
                                </div>
                            </div>
                            <?php $cnt=$cnt+1;}}  ?>
                          
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