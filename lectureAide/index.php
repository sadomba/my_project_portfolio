
<?php 

session_start();
error_reporting(0);
include('includes/config.php');
include("functions.php");

if($_SESSION['email']!=''){
$_SESSION['email']='';
}

if(isset($_POST['login']))
{
$email=$_POST['email'];
$password=md5($_POST['password']);
$sql ="SELECT email,password, role FROM user WHERE email=:email and password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':email', $email, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);


if($query->rowCount() > 0)
{ $_SESSION['email'] = $_POST['email'];
   $role = getrole($dbh, $email);
         if ($role == 'admin'){
            echo "<script type='text/javascript'> document.location = 'admin/dashboard.php'; </script>";
           

    }
    else{echo "<script type='text/javascript'> document.location = 'lecturer/dashboard.php'; </script>";}
   

} else{
    
    echo "<script>alert('Invalid Details');</script>";

}

}

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

<body class="bg-gradient-primary" style="background: blue;" >
    
    
    <section class="vh-100 gradient-custom">
  <div class="container py-5 h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card bg-dark text-white" style="border-radius: 1rem;">
          <div class="card-body p-5 text-center">

            <div class="mb-md-5 mt-md-4 pb-5">

              <h2 class="fw-bold mb-2 text-uppercase">Login</h2>
              <p class="text-white-50 mb-5">Please enter your email and password!</p>
<form action="" method="post">
              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" />
                <label class="form-label" for="typeEmailX">Email</label>
              </div>

              <div data-mdb-input-init class="form-outline form-white mb-4">
                <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                <label class="form-label" for="typePasswordX">Password</label>
              </div>

              <p class="small mb-5 pb-lg-2"><a class="text-white-50" href="#!">Forgot password?</a></p>

              <button data-mdb-button-init data-mdb-ripple-init class="btn btn-warning btn-lg px-5" type="submit" name="login">Login</button>

              <div class="d-flex justify-content-center text-center mt-4 pt-1">
            
              </div>
              </form>
            </div>

            

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/js/theme.js"></script>
</body>

</html>