<?php 


session_start();

$data = $_SESSION['value'];
$email = $_SESSION['email'];
$title = $_SESSION['title'];
$cid = $_SESSION['course'];
#db connection
include("../includes/config.php");
#function call
include("../functions.php");

#db to display .........
$sql3="SELECT title, points ,c_id from test WHERE id = '$data'";
$query3 = $dbh -> prepare($sql3);
$query3->execute();
$results3=$query3->fetchAll(PDO::FETCH_OBJ);



if(isset($_POST['save'])){

    $mark = $_POST['mark'];
    $reg = $_POST['reg'];
    $name = $_POST['name'];


    
   
   
    $sql="UPDATE `$cid` SET `$title` = '$mark' WHERE `$cid`.`reg` = '$reg' ";
    $query=$dbh->prepare($sql);
     $query->execute();
   
    
             echo '<script>alert("added succesfull")</script>';
            }
        

$configured = configured($dbh, $data);
if ($configured == 0){

   
    echo '<script>alert("Not configured yet")</script>';
    echo "<script>window.location.href ='dashboard.php'</script>";
 

}else{


$sql1="SELECT title, points from test WHERE id = '$data'";
$query1 = $dbh -> prepare($sql1);
$query1->execute();
$results1=$query1->fetchAll(PDO::FETCH_OBJ);


$sql2="SELECT * from $cid";
$query2= $dbh -> prepare($sql2);
$query2->execute();
$results2=$query2->fetchAll(PDO::FETCH_OBJ);

?>

<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>LectureAide</title>
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
                    <div class="container-fluid"><button class="btn btn-link d-md-none rounded-circle me-3" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    <?php
                foreach($results3 as $row3)
                                                                    { ?>
                    <h3 class="text-dark mb-4"><?php echo $title;?></h3>
                    <p class="text-dark mb-4"> <?php echo '  For : ', $row3->c_id  ?></p>
                    <?php } ?>
                        <form class="d-none d-sm-inline-block me-auto ms-md-3 my-2 my-md-0 mw-100 navbar-search">
                            <div class="input-group"></div>
                        </form>
                        <ul class="navbar-nav flex-nowrap ms-auto">
                            <li class="nav-item dropdown d-sm-none no-arrow"><a class="dropdown-toggle nav-link" aria-expanded="false" data-bs-toggle="dropdown" href="#"><i class="fas fa-search"></i></a>
                                <div class="dropdown-menu dropdown-menu-end p-3 animated--grow-in" aria-labelledby="searchDropdown">
                                    <form class="me-auto navbar-search w-100">
                                        <div class="input-group"><input class="bg-light form-control border-0 small" type="text" placeholder="Search for ...">
                                            <div class="input-group-append"><button class="btn btn-primary py-0" type="button"><i class="fas fa-search"></i></button></div>
                                        </div>
                                    </form>
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


       
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
             
                <div class="container-fluid">
                   
                    <div class="card shadow">
                        <div class="card-header py-3" style="background: var(--bs-link-hover-color);">
                            <p class="text-primary m-0 text-warning fw-bold">RECORD COURSE WORK</p>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-nowrap">
                                    <div id="dataTable_length" class="dataTables_length" aria-controls="dataTable"><label class="form-label">Show&nbsp;<select class="d-inline-block form-select form-select-sm">
                                                <option value="10" selected="">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                                <option value="100">100</option>
                                            </select>&nbsp;</label></div>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-md-end dataTables_filter" id="dataTable_filter"><label class="form-label"><input type="search" class="form-control form-control-sm" aria-controls="dataTable" placeholder="Search"></label></div>
                                </div>
                            </div>
                            <div class="table-responsive table mt-2" id="dataTable" role="grid" aria-describedby="dataTable_info">
                                
                            <table class="table table-striped my-0" id="dataTable">
                                    <thead class="">
                                        <tr>
                                        <th>Name</th>
                                            <th>Reg</th>
                                        <?php
                                                                                        $cnt1=1;
                                                                    if($query1->rowCount() > 0)
                                                                    {
                                                                    foreach($results1 as $row1)
                                                                    { 
                                                                      ?>   
                                            <th><?php echo 'Score' ,$row1 -> points ;?></th>
                                            <th>edit/record</th>
                                            <?php  $cnt1=$cnt1+1;}}?>
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
                                            <form method="post">
                                            
                                            <td><input type="text" style="border: none; width: 80px;" name="name" value="<?php echo $row2 -> surname ;?>"></td>
                                            <td><input type="text" name="reg"style="border: none; width: 80px;" value="<?php echo $row2 -> reg ;?>" ></td>
                                            
                                            <td><input type="number" class="form-control-sm" min=0  max=25  name="mark" style="width: 63px;height: 32px;" value="<?php echo $row2->{$title} ;?>"></td>
                                            <td><button  type="submit"  name="save"  class="form-control-sm" style="width: 63px;height: 32px;"><i class="fas fa-edit"></i></button></td>
                                             </form>
                                        </tr> <?php  $cnt2=$cnt2+2;}}?>
                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Reg</strong></td>
                                           
                                            <td></td>
                                        </tr>
                                    </tfoot>
                                </table>
                                                                   
                            </div>
                            <div class="row">
                                <div class="col-md-6 align-self-center">
                                    <p id="dataTable_info" class="dataTables_info" role="status" aria-live="polite">Showing 1 to 10 of 27</p>
                                </div>
                                <div class="col-md-6" style="text-align: center;"><button class="btn btn-primary" type="button">Discard</button></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>LectureAide</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
        </div>
    </div>
    
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>
<?php }?>