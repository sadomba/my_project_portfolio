<?php 

include("../includes/config.php");

$sql ="SELECT email FROM user";
$query= $dbh -> prepare($sql);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);


if(isset($_POST['save']))
{
  

 $email= $_POST['email'];
 $c_id= $_POST['c_id'];
 $cname= $_POST['cname'];
 $part= $_POST['part'];
 $year= $_POST['year'];
 $type= $_POST['type'];

$sql1="INSERT into course (courseid,c_name,LecturerEmail,Year, Part,type)values(:c_id,:cname,:email,:year,:part,:type)";
$query1=$dbh->prepare($sql1);
$query1->bindParam(':c_id',$c_id,PDO::PARAM_STR);
$query1->bindParam(':cname',$cname,PDO::PARAM_STR);
$query1->bindParam(':email',$email,PDO::PARAM_STR);
$query1->bindParam(':year',$year,PDO::PARAM_STR);
$query1->bindParam(':part',$part,PDO::PARAM_STR);
$query1->bindParam(':type',$type,PDO::PARAM_STR);

$query1->execute();

 

$sql2 ="DROP TABLE IF EXISTS `$c_id`; CREATE TABLE IF NOT EXISTS `$c_id`(`reg` VARCHAR(20) PRIMARY KEY, surname VARCHAR(50)); INSERT INTO `aide`.`$c_id`(`reg`, `surname`) SELECT `reg`, `surname` FROM `aide`.`students`";
$query2= $dbh -> prepare($sql2);

if ($query2->execute()){


    echo '<script>alert("has been added")</script>';
} else{
    echo '<script>alert("has been added")</script>';
}

        }




?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>course- AIDE</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
    <link rel="stylesheet" href="assets/fonts/fontawesome-all.min.css">
</head>

<body class="bg-gradient-transparent">
    
<div id="wrapper">
<?php include("includes/leftbar.php");?>
    <div class="container">
        <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                   
                    <div class="container">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Assign course to lecturer</h4>
                            </div>
                            <form class="user" method="post">
                                <div class="row mb-3">


                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                    <select class="form-control form-control-user" name="email" placeholder="email">
                                    <option value="">--SELECT LECTURE--</option>
                                    <?php 
                            $cnt=1;
                            if($query->rowCount() > 0)
                            {
                            foreach($results as $row)
                            { 
                                      /*Filling data into cells*/
                                        ?> 

                                       <option value="<?php echo $row-> email ;?>"><?php echo $row-> email;?></option>

                                       <?php $cnt=$cnt+1;}}  ?>
                                    </select>  
                                    <select class="form-control form-control-user" name="type" placeholder="Email">
                              
                            

                                       <option value="">--SELECT COURSE TYPE--</option>
                                       <option value="practical">practical</option>
                                       <option value="theory">theory</option>

                                    </select>  
                                   
                                
                                </div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text"  placeholder="course id" name="c_id"></div>
                                </div>
                                <div class="mb-3"><input class="form-control form-control-user" type="text"  aria-describedby="emailHelp" placeholder="Course name" name="cname"></div>
                                <div class="row mb-3">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" placeholder="Year" name="year"></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" placeholder="part" name="part"></div>
                                </div>
                                
                                
                                <button class="btn btn-primary d-block btn-user w-100" type="submit" name="save" >Assign Course</button>
                                
                    
                            </form>
                          
                         
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