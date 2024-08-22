<?php 



session_start();
include("../includes/config.php");
include("../functions.php");

$course = $_SESSION['course'];
$email = $_SESSION['email'];
$count = get_student_count($dbh,$course) ;

$id = '';


$email = $_SESSION['email'];
$sql3 ="SELECT type FROM config WHERE email='$email'";
$query3= $dbh -> prepare($sql3);
$query3-> execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);
if($query3->rowCount() <= 0)
{  echo '<script>alert("configure your course first. there are no components yet")</script>';
    echo "<script>window.location.href ='configuration.php'</script>";}else{


$sql3="SELECT c_name,courseid from  course WHERE LecturerEmail = '$email' ";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);


if(isset($_POST['data']))
{
    $id = $_POST['data'];
    
}

if(isset($_POST['manage']))
{
    echo "<script>window.location.href ='askcomp.php'</script>";
    
}
if(isset($_POST['insert']))
{
    $complete = completed($dbh,$course);
    echo $complete;
   
    if($complete==1){
        echo '<script>alert("You have already submitted to API you can view only!")</script>';
        echo "<script>window.location.href ='table.php'</script>";
    }

    $val = $_POST['insert'];
    

    $_SESSION['value'] = $val;



    $val2 = $_POST['title']; 
    
    $_SESSION['title'] = $val2; 
    echo "<script>window.location.href ='insert.php'</script>";
}
if(isset($_POST['view']))
{
    $val = $_POST['view'];
    $_SESSION['value'] = $val;

    $_SESSION['course'] = $course;

    $val2 = $_POST['title']; 
    
    $_SESSION['title'] = $val2; 
    echo "<script>window.location.href ='course.php'</script>";
}
$sql1="SELECT title, points, id, date from test WHERE c_id = '$course'";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);

$sql="SELECT title,date,points, id from test WHERE id = '$id'";
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

<body>

<div id="wrapper"  style="background-image: url(&quot;../assets/img/hit2.png&quot;);">
        <?php include("includes/leftbar.php");?>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <nav class="navbar navbar-expand bg-white shadow mb-4 topbar static-top navbar-light">
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button><label class="form-label">COURSE : <?php echo $course ; ?></label>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ol class="breadcrumb float-right px-3 mt-2">  <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Components</li>
    </ol>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item">
                            <form action="" method="post">
                                <div class="row mb-3" >
                               <div class="col mb-3"> 
                                   </div><div class="col mb-4"><input name="manage" type="submit" value="Manage Components" class="btn btn-facebook"></div>
 
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

    <div class="container">
        <section class="position-relative py-4 py-xl-5">
            <div class="container position-relative">
                
                <div class="row d-flex justify-content-center">
                    
                    <div class="container py-4 py-xl-5">
                        <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-3" >
            <?php 
                            $cnt=1;
                            if($query1->rowCount() > 0)
                            {
                            foreach($results1 as $row1)
                            { 
                                      /*Filling data into cells*/
                                        ?> 
                            <div class="card shadow border-start-warning py-2" style="background:blue;">
                                <div class="card-body" >
                                    <div class="row align-items-center no-gutters">
                                         <form method="post">
                                        <div class="col me-2">
                                           <div class="text-light fw-bold h3 mb-0"><span><?php echo $row1->title, ' ';?><i class="fas fa-tasks text-gray-300"></i></span> </div>
                                           <hr>
                                           <input class="invisible" type="text" id="name-1" name="title" value="<?php echo $row1->title; ?>">
                                            <div class="text-warning fw-bold h5 mb-0"><span><?php echo 'Points ',$row1->points; ?></span></div>
                                                    <?php $rcd = get_mark_count($dbh,$course,$row1->title) ?>
                                            <div class="text-warning fw-bold h5 mb-0"><span><?php echo  'recorded marks (',$rcd,'/', $count,')'; ?></span></div>
                                           
                                        </div>
                                        <hr>
                                       <div class="row mb-3"><div class="col-sm-6 mb-3 mb-sm-0"><button class="btn btn-warning" type="submit" value="<?php echo $row1->id;?>" name="insert" >allocate marks&nbsp;<i class="fas fa-save"></i>&nbsp;</button></div><div class="col-sm-6 mb-3 mb-sm-0"></div></div> 
                                       
                                        <input class="invisible" type="text" id="email-1" name="points" value="<?php echo $row1->points; ?>">
                                    </form>
                                       
                                    </div>
                                </div>
                            </div>
                            <?php $cnt=$cnt+1;}}  ?>
                        </div>
                   
                </div>
            </div>
        </section>
    </div>
            </div>
        </div>
</div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
<?php }?>